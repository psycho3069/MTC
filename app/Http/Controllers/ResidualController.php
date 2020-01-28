<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Booking;
use App\Configuration;
use App\Guest;
use App\Http\Traits\CustomTrait;
use App\Room;
use App\Venue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResidualController extends Controller
{
    //
    use CustomTrait;


    public function discount()
    {
        $bills = Billing::orderby('id', 'desc')->get();
        $data['bill'] = [];

        foreach ($bills as $bill) {
            if ( $bill->discount || $bill->restaurant->sum('discount') || $bill->booking->sum('discount'))
                $data['bill'][] = $bill;
        }
//        return $data;
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

        $request->validate([
            'guest.name' => 'required',
            'guest.contact_no' => 'required',
            'booking.*.*' => 'required',
        ]);


        $input = $request->except('_token');
        $input['billing']['code'] = $this->code();

        $count = $this->checkBooking($input['booking']);
        if ( $count > 0)
            return redirect()->back()->with('danger', '<b>Room Has Been Already Taken.</b> Please Select Another Room or <b>Refresh the Page</b>');

        $check_guest = Guest::where( 'contact_no', $input['guest']['contact_no'])->get()->last();
        $guest = Guest::create($input['guest']);
        if ( $check_guest)
            $guest->update([ 'appearance' => $check_guest->appearance + 1 ]);


        $hotel_bill = 0;
        $vat = $request->vat ? Configuration::where( 'name', 'vat_others')->first()->value : 0;
        foreach ($input['booking'] as $item) {
            $days = ( strtotime($item['end_date']) - strtotime($item['start_date']) ) / (60 * 60 * 24);
            $room_price = $item['room_id'] <50 ?  Room::find($item['room_id'])->price : Venue::find( $item['room_id'])->price;
            $hotel_bill += $room_price * $days;

            $booking['bill'][$item['room_id']] = $room_price * $days;
        }

        $input['billing']['total_bill'] = $hotel_bill + ( $hotel_bill * $vat) / 100;
        $input['billing']['guest_id'] = $guest->id;
        $input['billing']['reserved'] = 1;

        //Compute AIS
        $input['billing']['mis_voucher_id'] = 0;
        $billing = Billing::create( $input['billing']);

        //Store Booking Data
        foreach ($input['booking'] as $item) {

            $item['guest_id'] = $guest->id;
            $item['start_date'] = date('Y-m-d', strtotime($item['start_date']));
            $item['end_date'] = date('Y-m-d', strtotime($item['end_date']));
            $item['bill'] = $booking['bill'][$item['room_id']];
            $item['vat'] = $vat;
            $item['booking_status'] = 1;
            $billing->booking()->create($item);
        }

        $request->session()->flash('create', 'Room has been reserved successfully');

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



}
