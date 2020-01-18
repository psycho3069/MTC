<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Booking;
use App\Configuration;
use App\Guest;
use App\Http\Traits\CustomTrait;
use App\Room;
use App\Venue;
use PDF;
use Illuminate\Http\Request;
use NumberFormatter;

class BillingController extends Controller
{
    use CustomTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOld()
    {
        $billing = Billing::orderBy('id','desc')->get();
        foreach ($billing as $bill) {
            $data[$bill->id]['booking'] = 0;
            foreach ($bill->booking as $item) {
                $days = ( strtotime($item->end_date) - strtotime($item->start_date) ) / (60 * 60 * 24);
                $price = $item->room_id < 50 ? $item->room->price : $item->venue->price;
                $data[$bill->id]['booking'] += $price * $days - $item->discount;
            }
            $data[$bill->id]['tax'] = $data[$bill->id]['booking'] * 5 / 100;
        }
        return view('admin.mis.hotel.billing.index', compact('billing', 'data'));
    }


    public function test()
    {
        return view('admin.mis.hotel.billing.test');
    }




    public function index(Request $request)
    {
        $data['reserved'] = $request->res ? 1 : 0;
        $data['checkout'] = $request->chk ? 1 : 0;
        $billing = Billing::where('reserved', 0)->orderBy('id','desc')->get();
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
    public function showOld($id)
    {
//        return $id;
        $bill = Billing::find( $id);

//        return $bill->checkout_status ? 0 : 1;

        $data['total'] = 0;
//        return $bill->booking->sum('bill');
        foreach ($bill->booking as $item ) {
            $booking[$item->id]['days'] = ( strtotime($item->end_date) - strtotime($item->start_date) ) / (60 * 60 * 24);
            $booking[$item->id]['room_no'] = $item->room_id < 50 ? 'Room No-'.$item->room->room_no : $item->venue->name;
            $booking[$item->id]['unit_price'] = ( $item->room_id < 50 ? $item->room->price : $item->venue->price);
        }
        $booking['vat'] = $bill->booking->sum('bill') * 5 / 100;
        $booking['total'] = $bill->booking->sum('bill') + $booking['vat'];
        $restaurant['vat'] = $bill->restaurant->sum('bill') * 10 / 100;
        $restaurant['total'] = $bill->restaurant->sum('bill') + $restaurant['vat'];

        return view('admin.mis.hotel.billing.showOld', compact('bill', 'booking', 'restaurant'));
    }


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

        $pdf = PDF::loadView('admin.mis.hotel.billing.export.pdf');


       // return $pdf->download('invoice.pdf');
        return view('admin.mis.hotel.billing.export.pdf', compact('bill', 'booking', 'restaurant', 'data', 'info'));
//



//        $pdf = PDF::loadView('admin.mis.hotel.billing.export.pdf', compact('bill', 'booking', 'restaurant', 'data', 'info'));


//        return view('')


        return $bill;
    }

    public function show($id, $export = null)
    {
//        return $id;
        $bill = Billing::find( $id);

        foreach ($bill->booking as $item ) {

            if ( $item->room_id < 50)
                $data['room'][$item->id] = $item;

            if ( $item->room_id >= 50)
                $data['venue'][$item->id] = $item;

            $booking[$item->id]['days'] = ( strtotime($item->end_date) - strtotime($item->start_date) ) / (60 * 60 * 24);
            $booking[$item->id]['room_no'] = $item->room_id < 50 ? 'Room No-'.$item->room->room_no : $item->venue->name;
            $booking[$item->id]['unit_price'] = ( $item->room_id < 50 ? $item->room->price : $item->venue->price);
        }

        $info['venue']['total'] = isset($data['venue']) ? collect( $data['venue'])->sum('bill') : 0;
        $info['room']['total'] = isset($data['room']) ? collect( $data['room'])->sum('bill') : 0;

        $info['venue']['vat'] = $info['venue']['total'] * 5 / 100;
        $info['room']['vat'] = $info['room']['total'] * 5 / 100;

        $booking['vat'] = $bill->booking->sum('bill') * 5 / 100;
        $booking['total'] = $bill->booking->sum('bill') + $booking['vat'];
        $restaurant['vat'] = $bill->restaurant->sum('bill') * 10 / 100;
        $restaurant['total'] = $bill->restaurant->sum('bill') + $restaurant['vat'];

        $x = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $data['words']['total_bill'] = $x->format( $bill->total_bill);

        $all['bill'] = $bill; $all['booking'] = $booking; $all['restaurant'] = $restaurant; $all['data'] = $data; $all['info'] = $info;

        if ( $export)
            return $all;

        return view('admin.mis.hotel.billing.show', compact('bill', 'booking', 'restaurant', 'data', 'info'));
//        return view('admin.mis.hotel.billing.dropdown', compact('bill', 'booking', 'restaurant', 'data', 'info'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bill = Billing::find($id);
        $data['room'] = Room::get();
        $data['venue'] = Venue::all();

//        return $bill->booking;
        foreach ($bill->booking as $key => $book) {
//            return $key;
            $days = ( strtotime($book->end_date) - strtotime($book->start_date)) / (60*60*24);
            $data['discount'][$book->id] = $book->discount / $days;
        }

//        return $data['discount'];
        return view('admin.mis.hotel.billing.edit', compact('bill', 'data'));
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

        $input = $request->except('_token', '_method');
        $bill = Billing::find($id);

//        return $input['billing'];

        $old_bill = 0;
        $new_bill = 0;
        foreach ($input['booking'] as $key => $item) {
//            return $item;
            $book = $bill->booking->find($key);
            $days = ( strtotime( $item['end_date']) - strtotime( $item['start_date'])) / (60*60*24);
            $price = $book->room_id < 50 ? $book->room->price : $book->venue->price;
            $item['discount'] = $item['discount'] * $days;
            $item['bill'] = $price * $days - $item['discount'];

            $item['start_date'] = date('Y-m-d', strtotime($item['start_date']));
            $item['end_date'] = date('Y-m-d', strtotime($item['end_date']));

            $old_bill += $book->bill;
            $new_bill += $item['bill'];
//            return $item;
            $book->update( $item);
        }

//        return $new_bill;
        if ( isset($input['new_booking']))
            foreach ($input['new_booking'] as $item) {
                $days = ( strtotime($item['end_date']) - strtotime($item['start_date']) ) / (60 * 60 * 24);
                $price = $item['room_id'] <50 ?  Room::find($item['room_id'])->price : Venue::find( $item['room_id'])->price;
                $item['discount'] = $item['discount'] * $days;
                $item['bill'] = $price * $days - $item['discount'];
                $item['guest_id'] = $bill->guest_id;
                $item['start_date'] = date('Y-m-d', strtotime($item['start_date']));
                $item['end_date'] = date('Y-m-d', strtotime($item['end_date']));
                $bill->booking()->create( $item);

                $new_bill += $item['bill'];
            }

        $old_bill += ($old_bill * 5) / 100;
        $new_bill += ($new_bill * 5) / 100;

//        return $new_bill;


        $input['billing']['total_paid'] = $bill->total_paid + $input['billing']['advance_paid'] - $bill->advance_paid;
        $input['billing']['total_bill'] = $bill->total_bill + $new_bill - $old_bill + $bill->discount - $input['billing']['discount'];

//        return $input


        //updating AIS
        $amount['old'] = $bill->total_paid;
        $amount['new'] = $input['billing']['total_paid'];
        $data['note'] = 'Edited From MIS Bill';
        if ( $amount['old'] != $amount['new'])
            $this->updateAIS( $bill, $amount, $data);

        $bill->guest->update( $input['billing']);
        $bill->update( $input['billing']);

        $request->session()->flash('update', 'Booking has been Updated');

        return redirect('billing/'.$bill->id);
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
