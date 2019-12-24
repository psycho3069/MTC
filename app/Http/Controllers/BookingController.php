<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Booking;
use App\Guest;
use App\Room;
use App\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billing = Billing::all();
//        foreach ($billing as $item) {
//            return $item->booking->pluck('room_id');
//        }
        return view('admin.mis.booking.index', compact('billing'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['room'] = Room::all();
        $data['venue'] = Venue::all();

        return view('admin.mis.booking.create', compact('data'));
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
        $total_bill = 0;

        $guest = Guest::where( 'contact_no', $request->guest['contact_no'])->get()->first();
        if ( !$guest)
            $guest = Guest::create($input['guest']);
        $guest->update([ 'appearance' => $guest->appearance + 1 ]);

//        return $input['billing'];

        foreach ($input['booking'] as $item) {
            $days = ( strtotime($item['end_date']) - strtotime($item['start_date']) ) / (60 * 60 * 24);
            $total_bill = ( $total_bill - $item['discount'] ) + ( $item['room_id'] <50 ? ( Room::find($item['room_id'])->price * $days ) : ( Venue::find( $item['room_id'])->price * $days ) );
//            $input['billing']['total_bill'] = $input['billing']['total_bill'] + $total - $item['discount'];
        }
        $input['billing']['total_bill'] = $total_bill - $input['billing']['discount'];
        $input['billing']['total_paid'] = $input['billing']['advance_paid'];
        $input['billing']['guest_id'] = $guest->id;

        $billing = Billing::create( $input['billing']);

        foreach ($input['booking'] as $item) {
            $item['type_id'] = $item['room_id'] < 50 ? 1 : 2;
            $item['guest_id'] = $guest->id;
            $billing->booking()->create($item);
        }

        return redirect('booking/'.$billing->id );
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
        foreach ($bill->booking as $key => $item ) {
            $days = ( strtotime($item->end_date) - strtotime($item->start_date) ) / (60 * 60 * 24);
            $data['room_cost'][$key] = ( $item->room_id < 50 ? $item->room->price : $item->venue->price) * $days - $item->discount;
            $data['total'] += $data['room_cost'][$key];
        }

//        return $data;

        return view('admin.mis.booking.show', compact('bill', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
