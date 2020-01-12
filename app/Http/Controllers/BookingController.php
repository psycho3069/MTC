<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Booking;
use App\Configuration;
use App\Guest;
use App\Http\Traits\CustomTrait;
use App\Room;
use App\Venue;
use App\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use CustomTrait;
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
            $visitor = Visitor::where( 'contact_no', $item['contact_no'])->get()->last();
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
//        return $request->all();
        $booked = Booking::where('end_date','>=', date('Y-m-d'))->get()->pluck('room_id');
//        return $booked;
        $data['room'] = Room::get()->except($booked->toArray());
        $data['venue'] = Venue::get()->except($booked->toArray());
//        return $data['venue'];
        $data['selected'] = $request->room_id ? $request->room_id : 0;
        $data['reserved'] = $request->res ? 1 : 0;

//        return !$data['reservation'] ? 55 : 'Nazia';
        return view('admin.mis.hotel.booking.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request->all();

        $input = $request->except('_token');

//        return $item['booking_status'] = $input['billing']['reserved'] ? 1 : 2;

        $input['billing']['advance_paid'] = $input['billing']['reserved'] ? 0 : $input['billing']['advance_paid'];

        $hotel_bill = 0;
        $guest = Guest::where( 'contact_no', $request->guest['contact_no'])->get()->first();
        if ( !$guest)
            $guest = Guest::create($input['guest']);
        $guest->update([ 'appearance' => $guest->appearance + 1 ]);

        //total bill
        foreach ($input['booking'] as $item) {
            $days = ( strtotime($item['end_date']) - strtotime($item['start_date']) ) / (60 * 60 * 24);
            $room_price = $item['room_id'] <50 ?  Room::find($item['room_id'])->price : Venue::find( $item['room_id'])->price;
            $hotel_bill += $room_price * $days - $item['discount'] * $days;

            $booking['bill'][$item['room_id']] = $room_price * $days - $item['discount'] * $days;
            $booking['discount'][$item['room_id']] = $item['discount'] * $days;
        }

        $vat = ($hotel_bill * 5) / 100;
        $input['billing']['total_bill'] = $hotel_bill + $vat - $input['billing']['discount'];
        $input['billing']['total_paid'] = $input['billing']['advance_paid'];
        $input['billing']['guest_id'] = $guest->id;


        $data['amount'] = $input['billing']['total_paid'];
        $data['mis_ac_head_id'] = 1;
        $data['type'] = 'hotel_rv';
        $date = Configuration::find(1)->software_start_date;

        //Compute AIS
        if ( !$input['billing']['reserved'])
            $voucher = $this->computeAIS( $data, $date);
        $input['billing']['mis_voucher_id'] = $input['billing']['reserved'] ? 0 : $voucher->id;
        $billing = Billing::create( $input['billing']);

        //Store Booking Data
        foreach ($input['booking'] as $item) {
            $item['type_id'] = $item['room_id'] < 50 ? 1 : 2;
            $item['guest_id'] = $guest->id;
            $item['bill'] = $booking['bill'][$item['room_id']];
            $item['discount'] = $booking['discount'][$item['room_id']];
            $item['booking_status'] = $input['billing']['reserved'] ? 1 : 2;
            $billing->booking()->create($item);
        }

        if ( $request->check)
            return redirect('restaurant/sales/create?bill_id='.$billing->id );

        return redirect('billing/'.$billing->id );
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
            $data['room_cost'][$item->id] = ( $item->room_id < 50 ? $item->room->price : $item->venue->price) * $days - $item->discount;
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
