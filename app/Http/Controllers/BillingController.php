<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Http\Traits\CustomTrait;
use App\Room;
use App\Venue;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        $data['reserved'] = $request->res ? 1 : 0;
        $billing = Billing::where('reserved', 0)->orderBy('id','desc')->get();
        if ($request->res){
            $billing = Billing::where('reserved', 1)->orderBy('id','desc')->get();
            return view('admin.mis.hotel.billing.reservation.index', compact('billing'));
        }

        return view('admin.mis.hotel.billing.index', compact('billing'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        return $id;
        $bill = Billing::find( $id);

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

        return view('admin.mis.hotel.billing.show', compact('bill', 'booking', 'restaurant'));
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

//        return $input;

        $old_bill = 0;
        $new_bill = 0;
        foreach ($input['booking'] as $key => $item) {
//            return $item;
            $book = $bill->booking->find($key);
            $days = ( strtotime( $item['end_date']) - strtotime( $item['start_date'])) / (60*60*24);
            $price = $book->room_id < 50 ? $book->room->price : $book->venue->price;
            $item['discount'] = $item['discount'] * $days;
            $item['bill'] = $price * $days - $item['discount'];

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

        $bill->update( $input['billing']);

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
