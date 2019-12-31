<?php

namespace App\Http\Controllers;

use App\Billing;
use App\FoodSale;
use App\Menu;
use App\MenuType;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 55;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $billing = Billing::where('checkout_status', 0)->get();
        $menu_type = MenuType::all();

        return view('admin.mis.hotel.restaurant.sale.create', compact('billing', 'menu_type'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->input;

        foreach ( $input as $item ) {
            $item['bill'] = Menu::find($item['menu_id'])->price * $item['quantity'];
            $food_bill = FoodSale::create( $item);
            $vat = ($food_bill->bill * 10) / 100;

            $food_bill->billing->total_bill += $food_bill->bill + $vat;
            $food_bill->billing->save();
//            return $item;
        }

        return redirect('billing');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill = Billing::find($id);


        return MenuType::find(1)->menu;

        foreach ($bill->booking as $item) {
            $room[$item->id] = $item->room_id < 50 ? 'Room No-'.$item->room->room_no : $item->venue->name;
        }

        return $room;

        return $bill->booking->pluck('room_id');
        return $id;
    }


    public function room(Request $request)
    {
        $bill = Billing::find($request->bill_id);

        foreach ( $bill->booking as $book ) {
            $room[$book->id] = $book->room_id < 50 ? 'Room No-'.$book->room->room_no : $book->venue->name;
        }

        return $room;
//        return $request->bill_id;
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
