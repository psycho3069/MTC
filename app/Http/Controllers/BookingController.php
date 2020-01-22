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
use Illuminate\Support\Facades\Validator;

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
        $date = Configuration::find( 1)->software_start_date;
        $booked = Booking::where('end_date','>=', date('Y-m-d', strtotime( $date)))->get()->pluck('room_id');
//        return $booked;
        $data['room'] = Room::get()->except($booked->toArray());
        $data['venue'] = Venue::get()->except($booked->toArray());
        $data['selected'] = $request->room_id ? $request->room_id : 0;

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
        $request->validate([
            'guest.name' => 'required',
            'guest.contact_no' => 'required',
            'booking.*.*' => 'required',
        ]);

        $vat = $request->vat ? Configuration::where( 'name', 'vat_others')->first()->value : 0;

        $input = $request->except('_token');
        $input['billing']['code'] = $this->code();

        $hotel_bill = 0;
        $guest = Guest::create($input['guest']);
        $guest = Guest::where( 'contact_no', $guest->contact_no)->get()->last();
        $guest->update([ 'appearance' => $guest->appearance + 1 ]);

        //total bill
        foreach ($input['booking'] as $item) {
            $days = ( strtotime($item['end_date']) - strtotime($item['start_date']) ) / (60 * 60 * 24);
            $room_price = $item['room_id'] <50 ?  Room::find($item['room_id'])->price : Venue::find( $item['room_id'])->price;
            $hotel_bill += $room_price * $days - $item['discount'] * $days;

            $booking['bill'][$item['room_id']] = $room_price * $days - $item['discount'] * $days;
            $booking['discount'][$item['room_id']] = $item['discount'] * $days;
        }

//        return $hotel_bill;
        $hotel_vat = $hotel_bill * $vat / 100;
        $input['billing']['total_bill'] = $hotel_bill + $hotel_vat - $input['billing']['discount'];
        $input['billing']['total_paid'] = $input['billing']['advance_paid'];
        $input['billing']['guest_id'] = $guest->id;


        $data['amount'] = $input['billing']['total_paid'];
        $data['mis_ac_head_id'] = 1;
        $data['type'] = 'hotel_rv';
        $date = Configuration::find(1)->software_start_date;

        //Compute AIS
        $voucher = $this->computeAIS( $data, $date);
        $input['billing']['mis_voucher_id'] = $voucher->id;
        $billing = Billing::create( $input['billing']);

        //Store Booking Data
        foreach ($input['booking'] as $item) {
            $item['guest_id'] = $guest->id;
            $item['start_date'] = date('Y-m-d', strtotime($item['start_date']));
            $item['end_date'] = date('Y-m-d', strtotime($item['end_date']));
            $item['bill'] = $booking['bill'][$item['room_id']];
            $item['discount'] = $booking['discount'][$item['room_id']];
            $item['booking_status'] = 2;
            $item['vat'] = $vat;
            $billing->booking()->create($item);
        }

        $request->session()->flash('create', 'Room has been booked successfully');

        if ( $request->check)
            return redirect('restaurant/sales/create?bill_id='.$billing->id );

        return redirect('billing/'.$billing->id );
    }


    public function code()
    {
        $bill = Billing::whereDate('created_at', date('Y-m-d'))->get()->last();
        $preds = 'aspada_'.date('d_m_y');
        $slice_num = 0;
        if ( $bill )
            $slice_num = substr( $bill->code, -3);
        $slice_num += 1;
        $last_pad = str_pad( $slice_num, 3, '0', STR_PAD_LEFT);
        $code = $preds.'_'.$last_pad;

        return $code;

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
