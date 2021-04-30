<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Booking;
use App\Http\Requests\BookingRequest;
use App\Http\Traits\BillingTrait;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\Http\Traits\VoucherTrait;
use App\Payment;
use App\Room;
use App\Venue;
use App\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    use SoftwareConfigurationTrait, BillingTrait, VoucherTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billing = Billing::all();

        return view('admin.mis.hotel.booking.index', compact('billing'));
    }



    public function addVisitor($booking_id)
    {
        $booking = Booking::find($booking_id);
        return view('admin.mis.hotel.booking.visitor.add', compact('booking'));
    }


    public function storeVisitor(Request $request)
    {
        $booking = Booking::find( $request->booking_id);
        $input = $request->input;

        foreach ($input as $item) {
            $visitor = Visitor::where( 'contact_no', $item['contact_no'])->last();
            if ( isset($visitor->contact_no) && ($visitor->contact_no))
                $item['appearance'] = $visitor->appearance + 1;

            $item['guest_id'] = $booking->guest_id;
            $booking->visitors()->create( $item);
        }

//        return $booking->visitors;

        return redirect('booking/'.$booking->billing_id);


    }


    public function listVisitor($booking_id)
    {
        $booking = Booking::find($booking_id);
        return view('admin.mis.hotel.booking.visitor.list', compact('booking'));
    }



    /**
     * Get available room that is not booked
     */
    public function create(Request $request)
    {
        $softwareDate = $this->getSoftwareDate();
        $booked = Booking::whereDate('end_date', '>=', $softwareDate->date)
            ->where('booking_status', '!=', Booking::$bookingStatus['open'])
            ->pluck('room_id');

        $rooms = Room::whereNotIn('id', $booked)->get();
        $venues = Venue::whereNotIn('id', $booked)->get();
        $preSelected = $request->room_id ? $request->room_id : 0;

        return view('admin.mis.hotel.booking.create', compact(
            'rooms','venues', 'preSelected','softwareDate'
        ));
    }


    public function store(BookingRequest $request)
    {

        DB::beginTransaction();
        try {
            $softwareDate = $this->getSoftwareDate();
            $bookedRoom = $this->validateBooking($softwareDate, $request->booking);

            if ($bookedRoom > 0){
                session()->flash('danger', '<b>Room Has Been Already Taken.</b> Please Select Another Room or <b>Refresh the Page</b>');
                throw new \Exception('room.booked', 401);
            }

            $billing = $this->storeBilling($request, $softwareDate);

            DB::commit();
            session()->flash('create', 'Room has been booked successfully');
            if ( $request->check){
                return redirect()->route('sales.create', ['bill_id' => $billing->id]);
            }
            return redirect()->route('billing.show', $billing->id);
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('booking.error', ['error' => $exception->getMessage()]);

            return redirect()->back()->withInput($request->all());
        }




    }


    public function storeBilling($request, $softwareDate)
    {
        $billing = $this->createBillingForGuest($request->guest, $softwareDate);
        $vatOthers = $request->vat ? $this->getVatOthers()->value : 0;

        $roomCharge = 0;
        $venueCharge = 0;
        $hotelBill = 0;

        foreach ($request->booking as $key => $input) {
            $booking = new Booking();
            $booking = $this->saveBooking($billing, $booking, $input, $input['discount'], $vatOthers);
            $roomType = $this->getRoomType($booking->room_id);

            if ($roomType == Booking::$roomType['room']){
                $roomCharge += $booking->bill;
            }
            if ($roomType == Booking::$roomType['venue']){
                $venueCharge += $booking->bill;
            }

            $hotelBill += $booking->bill;
        }

        $totalBill = $hotelBill + ($hotelBill * $vatOthers)/100;
        $advancePaid = $request->billing['advance_paid'];

        $ledgerHead = $roomCharge > $venueCharge ? $this->getRoomBookingAccount() : $this->getVenueBookingAccount();
        $misVoucher = $this->createMISVoucher($ledgerHead, $softwareDate, $advancePaid);

        $billing->mis_voucher_id = $misVoucher->id;
        $billing->total_bill = $totalBill;
        $billing->advance_paid = $advancePaid;
        $billing->total_paid = $advancePaid;
        $billing->save();

        $payment = new Payment();
        $paymentType = $this->getPaymentType($ledgerHead->misHead);
        $payment = $this->saveAdvancePayment($billing, $payment, $paymentType);

        return $billing;

    }




    /**
     * Store a newly created resource in storage.
     *
     */
    public function storeOld(BookingRequest $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->except('_token');
            $softwareDate = $this->getSoftwareDate();
            $bookedRoom = $this->validateBooking($softwareDate, $input['booking']);

            if ($bookedRoom > 0){
                session()->flash('danger', '<b>Room Has Been Already Taken.</b> Please Select Another Room or <b>Refresh the Page</b>');
                return redirect()->back()->withInput($input);
            }


            $vatOthers = $request->vat ? $this->getVatOthers()->value : 0;
            $guest = $this->createGuest($request->guest);
            $charge['room'] = 0; $charge['venue'] = 0; $hotel_bill = 0;

            foreach ($input['booking'] as $key => $room) {

                $billInfo = $this->getBookingCharge($room['start_date'], $room['end_date'], $room['room_id'], $room['discount']);
                $room['discount'] = $billInfo['discount'];
                $room['bill'] = $billInfo['bill'];

                if ($billInfo['type'] == Booking::$roomType['room']){
                    $charge['room'] += $room['bill'];
                }

                if ($billInfo['type'] == Booking::$roomType['venue']){
                    $charge['venue'] += $room['bill'];
                }


                $hotel_bill += $room['bill'];
                $input['booking'][$key] = $room;

            }

            $totalVat = $hotel_bill * $vatOthers / 100;
            $totalBill = $hotel_bill + $totalVat;


            $ledgerHead = $charge['room'] > $charge['venue'] ? $this->getRoomBookingAccount() : $this->getVenueBookingAccount();

            $misVoucher = $this->createMISVoucher($ledgerHead, $softwareDate, $totalBill);

            $billing = new Billing();
            $billing->guest_id = $guest->id;
            $billing->date_id = $softwareDate->id;
            $billing->mis_voucher_id = $misVoucher->id;
            $billing->total_bill = $totalBill;
            $billing->advance_paid = $request->billing['advance_paid'];
            $billing->total_paid = $request->billing['advance_paid'];
            $billing->code = $this->getBillingCode();
            $billing->save();



            $payment = new Payment();
            $payment->billing_id = $billing->id;
            $payment->amount = $billing->advance_paid;
            $payment->note = 'Advance payment';
            $payment->payment_type = $this->getPaymentType($ledgerHead->misHead);
            $payment->mis_voucher_id = $misVoucher->id;
            $payment->save();


            //Store Booking Data
            foreach ($input['booking'] as $room) {
                $booking = new Booking();
                $booking->guest_id = $guest->id;
                $booking->billing_id = $billing->id;
                $booking->room_id = $room['room_id'];
                $booking->booking_status = Booking::$bookingStatus['booked'];
                $booking->start_date = $room['start_date'];
                $booking->end_date = $room['end_date'];
                $booking->discount = $room['discount'];
                $booking->no_of_visitors = $room['no_of_visitors'];
                $booking->bill = $room['bill'];
                $booking->vat = $vatOthers;

                $booking->save();
            }


//            DB::commit();

            session()->flash('create', 'Room has been booked successfully');

            if ( $request->check){
                return redirect()->route('sales.create', ['bill_id' => $billing->id]);
            }

            return redirect()->route('billing.show', $billing->id);

        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('booking.error', ['error' => $exception->getMessage()]);

            return redirect()->back()->withInput($input);

        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill = Billing::find( $id);

        $data['total'] = 0;
        foreach ($bill->booking as $booking ) {
            $days = $this->daysCalculator($booking->start_date, $booking->end_date, $booking->room_id);
            $room = $this->getRoomDetails($booking->room_id);

            $data['room_cost'][$booking->id] = $room->price * $days - $booking->discount;
            $data['total'] += $data['room_cost'][$booking->id];
        }

        return view('admin.mis.hotel.booking.show', compact('bill', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($bill_id)
    {
        return $bill_id;

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
