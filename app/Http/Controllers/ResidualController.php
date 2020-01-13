<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Booking;
use App\Configuration;
use App\Guest;
use App\Room;
use App\Venue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResidualController extends Controller
{
    //


    public function discount()
    {
        $bills = Billing::orderby('id', 'desc')->get();
        $data['bill'] = [];

        foreach ($bills as $bill) {
            if ( $bill->restaurant->sum('discount') || $bill->booking->sum('discount'))
                $data['bill'][] = $bill;
        }
        return view('admin.mis.hotel.discount.index', compact('data'));
    }


    public function reserve(Request $request)
    {
        $booked = Booking::where('end_date','>=', date('Y-m-d'))->get()->pluck('room_id');
//        return $booked;
        $data['room'] = Room::get()->except($booked->toArray());
        $data['venue'] = Venue::get()->except($booked->toArray());
        $data['selected'] = $request->room_id ? $request->room_id : 0;
        $data['reserved'] = $request->res ? 1 : 0;

        return view('admin.mis.hotel.booking.reserve.create', compact('data'));
    }


    public function reserveSTore(Request $request)
    {
        $input = $request->except('_token');

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
        $input['billing']['guest_id'] = $guest->id;

        //Compute AIS
        $input['billing']['mis_voucher_id'] = 0;
        $billing = Billing::create( $input['billing']);

        //Store Booking Data
        foreach ($input['booking'] as $item) {
            $item['guest_id'] = $guest->id;
            $item['bill'] = $booking['bill'][$item['room_id']];
            $item['discount'] = $booking['discount'][$item['room_id']];
            $item['booking_status'] = 1;
            $billing->booking()->create($item);
        }

        return redirect('/');
    }





}
