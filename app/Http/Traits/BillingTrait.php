<?php


namespace App\Http\Traits;


use App\Billing;
use App\Booking;
use App\Guest;
use App\Payment;
use App\Room;
use App\Venue;
use App\VoucherGroup;

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

        return $billing;

    }




    /*
     * Check if any selected room is booked
     * */
    public function validateBooking($softwareDate, $bookingInput)
    {
        return Booking::whereDate('end_date', '>=', $softwareDate->date)
            ->whereIn('room_id', array_column($bookingInput, 'room_id'))
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




    /*Old Code*/

    public function getBookingRoom($room)
    {
//        return $room;

        $room['start_date'] = date('Y-m-d', strtotime($room['start_date']));
        $room['end_date'] = date('Y-m-d', strtotime($room['end_date']));

        $days = (strtotime( $room['end_date']) - strtotime( $room['start_date']) ) / (60 * 60 * 24);
        $days = $room['room_id'] < 50 || $room['room_id'] > 499 ? ( $days == 0 ? 1 : $days) : $days + 1;

        $room_price = $room['room_id'] < 50 || $room['room_id'] > 499 ? Room::find($room['room_id'])->price : Venue::find( $room['room_id'])->price;
        $room['discount'] = $room['discount'] * $days;
        $room['bill'] = $room_price * $days - $room['discount'];
        $room['days'] = $days;

        return $room;
    }



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
