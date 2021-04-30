<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Booking;
use App\Configuration;
use App\Date;
use App\Guest;
use App\Http\Traits\BillingTrait;
use App\Http\Traits\CustomTrait;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\Http\Traits\VoucherTrait;
use App\Payment;
use App\Room;
use App\Venue;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use NumberFormatter;
use PDF;
use Illuminate\Http\Request;
class BillingController extends Controller
{
    use SoftwareConfigurationTrait, BillingTrait, VoucherTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index(Request $request)
    {
        $data['reserved'] = $request->res ? 1 : 0;
        $data['checkout'] = $request->chk ? 1 : 0;
        $billing = Billing::where('reserved', 0)
                            ->orderBy('id','desc')
                            ->get();
        $billing = $data['checkout'] ? $billing->where('checkout_status', 1) : $billing->where('checkout_status', 0);

        if ( $request->res){
            $billing = Billing::where('reserved', 1)->orderBy('id','desc')->get();
            return view('admin.mis.hotel.billing.reservation.index', compact('billing'));
        }

        return view('admin.mis.hotel.billing.index', compact('billing', 'data'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function export($id)
    {
        $bill = Billing::find($id);
        $export = 1;
        $all = $this->show($id, $export);
        $bill = $all['bill']; $booking = $all['booking']; $restaurant = $all['restaurant']; $data = $all['data']; $info = $all['info'];


        view()->share('bill',$bill);
        view()->share('booking',$booking);
        view()->share('restaurant',$restaurant);
        view()->share('data',$data);
        view()->share('info',$info);


//        return $all;

        $pdf = PDF::loadView('admin.mis.hotel.billing.export.pdf');


//        return $pdf->download('invoice.pdf');
        return view('admin.mis.hotel.billing.export.pdf', compact('bill', 'booking', 'restaurant', 'data', 'info'));

    }

    public function show($id, $export = null)
    {
//        return $id;
        $bill = Billing::find( $id);

        $vat = 0; //for "only food-sale"
        foreach ($bill->booking as $item ) {
            $vat = $item->vat;
            $bookingType = $this->getRoomType($item->room_id);

            if ( $bookingType == Booking::$roomType['room']){
                $data['room'][$item->id] = $item;
            }

            if ( $bookingType == Booking::$roomType['venue']){
                $data['venue'][$item->id] = $item;
            }

            $days = $this->daysCalculator($item->start_date, $item->end_date, $item->room_id);

            $room = $this->getRoomDetails($item->room_id);

            $booking[$item->id]['days'] = $days;
            $booking[$item->id]['room_no'] = $room->getName(true);
            $booking[$item->id]['unit_price'] = $room->price;
        }


        $info['venue']['total'] = isset($data['venue']) ? collect( $data['venue'])->sum('bill') : 0;
        $info['room']['total'] = isset($data['room']) ? collect( $data['room'])->sum('bill') : 0;

        $info['venue']['vat'] = $info['venue']['total'] * $vat / 100;
        $info['room']['vat'] = $info['room']['total'] * $vat / 100;

        $booking['vat'] = $bill->booking->sum('bill') * $vat / 100;
        $booking['total'] = $bill->booking->sum('bill') + $booking['vat'];

        $restaurant['vat']['%'] = $bill->restaurant->isNotEmpty() ? $bill->restaurant[0]->vat : 0;
        $restaurant['service']['%'] = $bill->restaurant->isNotEmpty() ? $bill->restaurant[0]->service_charge : 0;
        $restaurant['vat']['total'] = ( $bill->restaurant->sum('bill') * $restaurant['vat']['%']) / 100;
        $restaurant['service']['total'] = ( $bill->restaurant->sum('bill') * $restaurant['service']['%']) / 100;
        $restaurant['total'] = $bill->restaurant->sum('bill') + $restaurant['vat']['total'] + $restaurant['service']['total'];

        $x = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $data['words']['total_bill'] = $x->format( $bill->total_bill);
        $data['date'] = $this->getSoftwareDate();


        $all['bill'] = $bill; $all['booking'] = $booking; $all['restaurant'] = $restaurant; $all['data'] = $data; $all['info'] = $info;

        if ( $export)
            return $all;

        return view('admin.mis.hotel.billing.show', compact('bill', 'booking', 'restaurant', 'data', 'info'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $softwareDate = $this->getSoftwareDate();
        $booked = Booking::whereDate('end_date', '>=', $softwareDate->date)
            ->where('booking_status', '!=', Booking::$bookingStatus['open'])
            ->pluck('room_id');
        $rooms = Room::with('roomCat')->whereNotIn('id', $booked)->get();
        $venues = Venue::whereNotIn('id', $booked)->get();

        $discounts = [];
        $roomDetails = [];
        $billing = Billing::with('booking', 'guest')->find($id);
        foreach ($billing->booking as $key => $booking) {
            $room = $this->getRoomDetails($booking->room_id);
            $roomDetails[$booking->room_id] = $room->getName();

            $days = $this->daysCalculator($booking->start_date, $booking->end_date, $booking->room_id);
            $discounts[$booking->id] = $booking->discount/$days;
        }

        return view('admin.mis.hotel.billing.edit', compact(
            'softwareDate','billing', 'rooms', 'venues',
            'roomDetails', 'discounts'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $softwareDate = $this->getSoftwareDate();
            $billing = Billing::with('booking')->findOrFail($id);
            $bookedRoom = $this->validateBooking($softwareDate, (array) $request->new_booking);

            if ($bookedRoom > 0){
                session()->flash('danger', '<b>Room Has Been Already Taken.</b> Please Select Another Room or <b>Refresh the Page</b>');
                throw new \Exception('room.booked', 401);
            }

            $billing = $this->updateBooking($request, $billing, $softwareDate);

            DB::commit();
            session()->flash('success', 'Booking successfully updated');
            return redirect()->route('billing.show', $billing->id);
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('booking.error', ['error' => $exception->getMessage()]);

            return redirect()->back()->withInput($request->all());
        }


    }


    public function updateBooking($request, $billing, $softwareDate)
    {
        $newBill = 0;
        $oldVat = $billing->getBookingVat();
        $oldBill = $billing->booking->sum('bill');

        $vatOthers = $request->vat ? $this->getVatOthers()->value : 0;
        $vatOthers = $billing->checkout_status ? $oldVat : $vatOthers;

        foreach ((array)$request->booking as $bookingId => $input) {
            $booking = Booking::where('billing_id', $billing->id)
                ->where('room_id', $input['room_id'])
                ->firstOrFail();

            $discount = $billing->checkout_status ? $booking->discount : $input['discount'];
            $booking = $this->saveBooking($billing, $booking, $input, $discount, $vatOthers);
            $newBill += $booking->bill;
        }


        $bookingType = "";
        foreach ((array)$request->new_booking as $input) {
            $booking = new Booking();
            $booking = $this->saveBooking($billing, $booking, $input, $input['discount'], $vatOthers);
            $bookingType = $this->getRoomType($booking->room_id);
            $newBill += $booking->bill;
        }


        $oldBill += ($oldBill * $oldVat)/ 100;
        $newBill += ($newBill * $vatOthers)/ 100;
        $newAdvancePaid = $request->billing['advance_paid'];

        if ($billing->advance_paid != $newAdvancePaid){

            $note = 'Room booking advance payment edited - [id: '.$billing->id .']';

            if ($billing->mis_voucher_id){
                $aisVoucher = $billing->misVoucher->voucher;
                $this->updateVoucherAmount($aisVoucher, $newAdvancePaid, $billing->advance_paid, $note);
                $payment = $billing->advancePayment;
            }

            if (!$billing->mis_voucher_id){
                $ledgerHead = $bookingType == Booking::$roomType['room'] ? $this->getRoomBookingAccount() : $this->getVenueBookingAccount();
                $misVoucher = $this->createMISVoucher($ledgerHead, $softwareDate, $newAdvancePaid);
                $billing->mis_voucher_id = $misVoucher->id;

                $payment = new Payment();
                $payment->payment_type = $this->getPaymentType($ledgerHead->misHead);
            }


            $billing->total_paid +=  $newAdvancePaid - $billing->advance_paid;
            $billing->advance_paid = $newAdvancePaid;
            $payment = $this->saveAdvancePayment($billing, $payment);
        }

        $billing->total_bill += $newBill - $oldBill;
        $billing->save();

        return $billing;

    }




    public function updateOld(Request $request, $id)
    {
        DB::beginTransaction();
        $input = $request->all();
        $softwareDate = $this->getSoftwareDate();

        $bill = Billing::with('booking')->findOrFail($id);

        $oldBill = 0;
        $newBill = 0;
        $oldVat = $bill->getBookingVat();
        $vatOthers = $request->vat ? $this->getVatOthers()->value : 0;
        $vatOthers = $bill->checkout_status ? $oldVat : $vatOthers;

        foreach ($input['booking'] as $id => $room) {
            $booking = $bill->booking()->findOrFail($id);
            $discount = $bill->checkout_status ? $booking->discount : $room['discount'];
            $billInfo = $this->getBookingCharge($room['start_date'], $room['end_date'], $booking->room_id, $discount);

            $oldBill += $booking->bill;
            $newBill += $billInfo['bill'];

            $booking->discount = $billInfo['discount'];
            $booking->bill = $billInfo['bill'];
            $booking->vat = $vatOthers;
            $booking->no_of_visitors = $room['no_of_visitors'];
            $booking->start_date = $room['start_date'];
            $booking->end_date = $room['end_date'];
            $booking->save();

        }


        if ( isset($input['new_booking'])){
            $bookedRoom = $this->validateBooking($softwareDate, $input['new_booking']);

            if ($bookedRoom > 0){
                session()->flash('danger', '<b>Room Has Been Already Taken.</b> Please Select Another Room or <b>Refresh the Page</b>');
                return redirect()->back()->withInput($input);
            }

            foreach ($input['new_booking'] as $item) {
                $item = $this->getRoomInfo( $item);
                $item['guest_id'] = $bill->guest_id;
                $item['vat'] = $vat;
                $bill->booking()->create( $item);
                $new_bill += $item['bill'];
            }
        }



        $old_bill += ($old_bill * $old_vat) / 100;
        $new_bill += ($new_bill * $vat) / 100;

        $input['billing']['total_paid'] = $bill->total_paid - $bill->advance_paid + $input['billing']['advance_paid'];
        $input['billing']['total_bill'] = $bill->total_bill - $old_bill + $new_bill;
        $input['billing']['discount'] = $bill->checkout_status ? $bill->discount : $input['billing']['discount'];

        //updating AIS
        $data['note'] = 'Edited From MIS Bill- [id: '.$bill->id .']';
        $data['new_amount'] = $input['billing']['advance_paid'];
        if ( $bill->advance_paid != $input['billing']['advance_paid'])
            $this->updateAIS( $bill->misVoucher->voucher, $data);

        //updating bill info
        $bill->guest->update( $input['billing']);
        $bill->update( $input['billing']);
        $bill->booking()->update([ 'vat' => $vat]);
        $bill->payments[0]->update([ 'amount' => $bill->advance_paid ]);

        $request->session()->flash('update', 'Booking has been Updated');

        return redirect('billing/'.$bill->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $billing = Billing::findOrFail($id);

            foreach ($billing->payments as $payment) {
                $deleteNote = 'Deleted billings form MIS  - [payment_id: '.$payment->id. ']';
                $misVoucher = $payment->misVoucher;

                $this->deleteAISVoucher($misVoucher->voucher, $deleteNote);
                $misVoucher->delete();
                $payment->delete();
            }

            $billing->booking()->delete();
            $billing->restaurant()->delete();
            $billing->delete();

            session()->flash('success', '<b>Operation Successful.</b> Bill has been Deleted.');
            DB::commit();

            return 200;
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('booking.delete.error', ['error' => $exception->getMessage()]);

            return 403;
        }




        return 200;

    }




}
