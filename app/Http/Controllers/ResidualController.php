<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Booking;
use App\Configuration;
use App\Guest;
use App\Http\Traits\CustomTrait;
use App\MISHead;
use App\MISHeadChild_I;
use App\MISLedgerHead;
use App\Room;
use App\TransactionHead;
use App\Venue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ResidualController extends Controller
{
    //
    use CustomTrait;


    public function discount()
    {
        $bills = Billing::orderby('id', 'desc')->get();
        $data['bill'] = [];

        foreach ($bills as $bill) {
            if ( $bill->discount != 0 || $bill->restaurant->sum('discount') != 0 || $bill->booking->sum('discount') != 0 )
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
            $days = $item['room_id'] < 50 || $item['room_id'] > 499 ? ( $days == 0 ? 1 : $days) : $days + 1;
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


    public function ledger( $type)
    {
        $type_id = $type != 1 ? 5 : 4;
        $mis_head = MISHead::find( $type_id);
        $data['theads'] = TransactionHead::all();

        return view('admin.configuration.general.ledger', compact('data', 'mis_head'));
    }


    public function updateLedger(Request $request)
    {
        $input['kate'] = $request->input['kate'];
        $input['mis_head'] = isset( $request->input['mis_head'] ) ? $request->input['mis_head'] : [];
        $mis_types = MISHead::get();

        foreach ( $input['kate'] as $key => $item) {
            $mis_type = $mis_types->find( $key);
            $mis_type->update( $item);

            foreach ( $input['mis_head'] as $id => $val ) {
                $item['checked'] = $val['checked'];

                if ( isset( $val['checked']) && $val['checked'] == true)
                    $val = $item;

                $heath = $mis_type->child->find( $id);
                $heath->update( $val);
                $heath->ledger()->update( $val);

            }

        }


        return back()->with('update', 'Operation Successful!');

    }


    public function hotel()
    {

//        return 55;

        $theads = TransactionHead::where('code','!=', 353)->get();
        $conf = Configuration::all();
        $mis_heads = MISHead::all();
        $data['hotel'] = $mis_heads->find([ 1, 2, 3]);
        $data['discount'] = $mis_heads->find(6);

        return view('admin.configuration.general.hotel', compact('conf', 'data', 'theads'));

    }


    public function updateHotel(Request $request)
    {
        $request->validate([
            'software_start_date' => 'required',
        ],[
            'software_start_date.required' => 'Please Enter Software Date',
        ]);

//        return $request->all();

        $input = $request->input;
        $configurations = Configuration::get();
        $mis_heads = MISHead::all();

        $configurations->find(1)->update([ 'software_start_date' => $request->software_start_date]);

        foreach ( $request->conf as $key => $val) {
            $configurations->where( 'name', $key)->first()->update([ 'value' => $val]);
        }

        foreach ( $input as $accounts) {
            foreach ($accounts as $key => $item) {
             $mis_head = $mis_heads->find( $key);
             $mis_head->ledger()->update( $item);
             $mis_head->update( $item);
            }
        }

        return redirect()->back()->with('update', '<b>Configuration updated successfully</b>');
    }













}
