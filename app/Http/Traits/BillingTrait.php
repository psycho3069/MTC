<?php


namespace App\Http\Traits;


use App\Billing;
use App\Booking;
use App\Guest;
use App\Payment;
use App\Room;
use App\Venue;
use App\VoucherGroup;
use Carbon\Carbon;

trait BillingTrait
{


    /*
     * To be implemented
     * */
    public function createBillingForGuest($guestInfo, $softwareDate, $isReserved = 0)
    {
        $guest = $this->createGuest($guestInfo);

        $billing = new Billing();
        $billing->guest_id = $guest->id;
        $billing->date_id = $softwareDate->id;
        $billing->reserved = $isReserved;
        $billing->code = $this->getBillingCode();
        $billing->save();

        return $billing;#
    }



    public function saveAdvancePayment($billing, $payment, $paymentType = null)
    {
        $payment->billing_id = $billing->id;
        $payment->amount = $billing->advance_paid;
        $payment->mis_voucher_id = $billing->mis_voucher_id;
        $payment->payment_type = $payment->payment_type ?: $paymentType;
        $payment->note = 'Advance payment';
        $payment->save();

        return $payment;
    }

    /*
     * Check if any selected room is booked
     * */
    public function validateBooking($softwareDate, $bookingInput)
    {
        return Booking::whereDate('end_date', '>=', $softwareDate->date)
            ->whereIn('room_id', array_column($bookingInput, 'room_id'))
            ->where('booking_status', '!=', Booking::$bookingStatus['open'])
            ->count();
    }


    public function createGuest($guestInfo)
    {
        $guest = new Guest();
        $guestLastVisit = Guest::where( 'contact_no', $guestInfo['contact_no'])
            ->orderBy('created_at', 'desc')
            ->first();

        $appearance = $guestLastVisit->appearance ?? 0;

        $guest->name = $guestInfo['name'];
        $guest->contact_no = $guestInfo['contact_no'];
        $guest->address = $guestInfo['address'] ?? '';
        $guest->org_name = $guestInfo['org_name'] ?? '';
        $guest->designation = $guestInfo['designation'] ?? '';
        $guest->appearance = $appearance + 1;
        $guest->save();

        return $guest;
    }



    public function getBillingCode()
    {
        $billNumber = 0;
        $prefix = 'aspada_'.date('d_m_y');
        $latestBill = Billing::whereDate('created_at', date('Y-m-d'))
            ->orderBy('created_at', 'desc')
            ->first();

        if ($latestBill){
            $billNumber = substr( $latestBill->code, -3);
        }
        $billNumber += 1;
        $billNumber = str_pad( $billNumber, 3, '0', STR_PAD_LEFT);

        return $prefix .'_' . $billNumber;
    }




    public function saveBooking($billing, $booking, $input, $discount, $vat)
    {
        $roomCharge = $this->getBookingCharge($input['start_date'], $input['end_date'], $input['room_id'], $discount);

        $booking->billing_id = $billing->id;
        $booking->guest_id = $billing->guest_id;
        $booking->vat = $vat;
        $booking->bill = $roomCharge['bill'];
        $booking->discount = $roomCharge['discount'];

        $booking->room_id = $input['room_id'];
        $booking->start_date = $input['start_date'];
        $booking->end_date = $input['end_date'];
        $booking->no_of_visitors = $input['no_of_visitors'];
        $booking->booking_status = Booking::$bookingStatus['booked'];

        if ($booking->isDirty())
            $booking->save();

        return $booking;
    }



    public function getBookingCharge($startDate, $endDate, $roomId, $discount)
    {
        $room = $this->getRoomDetails($roomId);
        $days = $this->daysCalculator($startDate, $endDate, $roomId);

        $discount = $discount * $days;
        $bill = $room->price * $days - $discount;

        return [
            'bill' => $bill,
            'discount' => $discount,
            'days' => $days,
            'type' => $this->getRoomType($roomId)
        ];
    }




    public function daysCalculator($startDate, $endDate, $roomId)
    {
        $roomType = $this->getRoomType($roomId);
        $startDate = new Carbon($startDate);
        $days = $startDate->diffInDays($endDate, false);

        if ($roomType == Booking::$roomType['room']){
            $days = $days == 0 ? 1 : $days;
        }

        if ($roomType == Booking::$roomType['venue']){
            $days += 1;
        }

        return $days;
    }



    public function getRoomDetails($roomId)
    {
        $roomType = $this->getRoomType($roomId);

        if ($roomType == Booking::$roomType['room']){
            return Room::findOrFail($roomId);
        }


        if ($roomType == Booking::$roomType['venue']){
            return Venue::findOrFail($roomId);
        }

    }


    public function getRoomType($roomId)
    {
        if ($roomId < 50 || $roomId >= 500){
            return Booking::$roomType['room'];
        }

        if ($roomId >= 50 && $roomId < 500){
            return Booking::$roomType['venue'];
        }

    }



    /*Old Code*/





    public function getBillingDetails($bill)
    {
        $charge['room']['total'] = $bill->booking->where('room_id', '<', 50)->sum('bill');
        $charge['room']['total'] += $bill->booking->where('room_id', '>', 499)->sum('bill');
        $charge['venue']['total'] = $bill->booking->whereBetween('room_id', [50, 499])->sum('bill');
        $charge['food']['total'] = $bill->restaurant->sum('bill');

        if ($bill->mis_voucher_id){ //if mis_voucher_id not null
            $charge['room']['total'] += $charge['room']['total'] * $bill->booking[0]->vat / 100;
            $charge['venue']['total'] += $charge['venue']['total'] * $bill->booking[0]->vat / 100;
        }

        if ( $bill->restaurant->isNotEmpty()){
            $charge['food']['total'] += $charge['food']['total'] * ( $bill->restaurant[0]->vat + $bill->restaurant[0]->service_charge ) / 100;
        }

        $charge['room']['paid'] = $bill->payments->where('payment_type', Payment::$paymentType['room'])->sum('amount');
        $charge['venue']['paid'] = $bill->payments->where('payment_type', Payment::$paymentType['venue'])->sum('amount');
        $charge['food']['paid'] = $bill->payments->where('payment_type', Payment::$paymentType['food'])->sum('amount');


        $max = collect($charge)->sortByDesc('total')->keys()->first();

        $charge['all']['total'] = $charge['room']['total'] + $charge['venue']['total'] + $charge['food']['total'];
        $charge['all']['max'] = $max;

        return $charge;
    }





}
