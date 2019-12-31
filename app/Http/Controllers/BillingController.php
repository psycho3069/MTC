<?php

namespace App\Http\Controllers;

use App\Billing;
use Illuminate\Http\Request;

class BillingController extends Controller
{
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

    public function index()
    {
        $billing = Billing::orderBy('id','desc')->get();
//        foreach ($billing as $bill) {
//            $data[$bill->id]['vat'] = $bill->total_bill * 5 / 100;
//        }
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
        $bill = Billing::find( $id);

//        return $bill->restaurant;
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
