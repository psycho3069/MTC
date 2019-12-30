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
        foreach ($billing as $bill) {
            $data[$bill->id]['vat'] = $bill->total_bill * 5 / 100;
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
        $data['total'] = 0;
        foreach ($bill->booking as $item ) {
            $data['days'][$item->id] = ( strtotime($item->end_date) - strtotime($item->start_date) ) / (60 * 60 * 24);
//            $data['room_no'] = $item->room_id < 50 ? $item->room->room_no : $item->venue->name;
            $data['unit_price'][$item->id] = ( $item->room_id < 50 ? $item->room->price : $item->venue->price);
            $data['room_cost'][$item->id] = ( $item->room_id < 50 ? $item->room->price : $item->venue->price) * $data['days'][$item->id] - $item->discount;
            $data['total'] += $data['room_cost'][$item->id];
        }
        $data['vat'] = $bill->total_bill * 5 / 100;
        return view('admin.mis.hotel.billing.show', compact('bill', 'data'));
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
