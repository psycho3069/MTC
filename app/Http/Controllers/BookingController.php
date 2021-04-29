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
            ->where('booking_status', '!=', 0)
            ->pluck('room_id');

        $rooms = Room::whereNotIn('id', $booked)->get();
        $venues = Venue::whereNotIn('id', $booked)->get();
        $preSelected = $request->room_id ? $request->room_id : 0;

        return view('admin.mis.hotel.booking.create', compact(
            'rooms','venues', 'preSelected','softwareDate'
        ));
    }


    public function storeNew(BookingRequest $request)
    {
        DB::beginTransaction();

        $softwareDate = $this->getSoftwareDate();
        $billing = $this->createBillingForGuest($request, $softwareDate);

       return $request;


        return $guest;

        return $request;
    }


    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(BookingRequest $request)
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

            $vatOthers = 0;
            if ($request->vat){
                $configuration = $this->getVatOthers();
                $vatOthers = $configuration->value;
            }

            $guest = $this->createGuest($request->guest);
            $charge['room'] = 0; $charge['venue'] = 0; $hotel_bill = 0;

            foreach ($input['booking'] as $key => $item) {
                $item = $this->getBookingRoom($item);
                $item['booking_status'] = Booking::$bookingStatus['booked'];
                $item['guest_id'] = $guest->id;
                $item['vat'] = $vatOthers;

                if ($item['room_id'] < 50 || $item['room_id'] > 499){
                    $charge['room'] += $item['bill'];
                }else{
                    $charge['venue'] += $item['bill'];
                }

                $hotel_bill += $item['bill'];
                $input['booking'][$key] = $item;
            }

            $hotel_vat = $hotel_bill * $vatOthers / 100;
            $totalBill = $hotel_bill + $hotel_vat;


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
            foreach ($input['booking'] as $item) {
                $booking = new Booking();
                $booking->guest_id = $guest->id;
                $booking->billing_id = $billing->id;
                $booking->room_id = $item['room_id'];
                $booking->booking_status = Booking::$bookingStatus['booked'];
                $booking->start_date = $item['start_date'];
                $booking->end_date = $item['end_date'];
                $booking->discount = $item['discount'];
                $booking->no_of_visitors = $item['no_of_visitors'];
                $booking->bill = $item['bill'];
                $booking->vat = $item['vat'];

                $booking->save();
            }


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
        foreach ($bill->booking as $item ) {
            $days = ( strtotime($item->end_date) - strtotime($item->start_date) ) / (60 * 60 * 24);
            $data['room_cost'][$item->id] = ( $item->room_id < 50 || $item->room_id > 499 ? $item->room->price : $item->venue->price) * $days - $item->discount;
            $data['total'] += $data['room_cost'][$item->id];
        }

//        return $data;

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
