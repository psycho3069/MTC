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
//        $sales = FoodSale::get()->groupBy('billing_id');
        $billing = Billing::orderBy('id', 'desc')->get();

        foreach ($billing as $item) {
            $food_bill = $item->restaurant->sum('bill');
            $data[$item->id]['bill'] = $food_bill + $food_bill*10 / 100;
        }

        return view('admin.mis.hotel.restaurant.sale.index', compact('billing', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['bill_id'] = $request->bill_id ? $request->bill_id : 0;

        $billing = Billing::where('checkout_status', 0)->get();
        $data['menu_type'] = MenuType::all();

        return view('admin.mis.hotel.restaurant.sale.create', compact('billing', 'data'));

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

        return redirect('billing/'.$food_bill->billing_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($bill_id)
    {
        $bill = Billing::find($bill_id);
        $data['vat'] = $bill->restaurant->sum('bill') * 5 / 100;
        $data['total'] = $bill->restaurant->sum('bill') + $data['vat'] ;
        return view('admin.mis.hotel.restaurant.sale.show', compact('bill', 'data'));
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
    public function edit($bill_id)
    {
        $bill = Billing::find($bill_id);
        $menu_type = MenuType::all();

//        return $bill->restaurant->pluck('id');
        return view('admin.mis.hotel.restaurant.sale.edit', compact('bill', 'menu_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bill_id)
    {
        $input = $request->except('_token', '_method');
        $bill = Billing::find($bill_id);

        $new_bill = 0;
        foreach ($input['food'] as $key => $item) {
            $food = FoodSale::find($key);
            $item['bill'] = $food->menu->price * $item['quantity'];
            $new_bill += $item['bill'] - $food->bill;
            $food->update($item);
        }

        if ( isset($input['new_food']))
            foreach ($input['new_food'] as $item) {
//            return $item;
                $item['bill'] = Menu::find($item['menu_id'])->price * $item['quantity'];
                $new_bill += $item['bill'];
                $bill->restaurant()->create($item);
            }

        $vat = $new_bill * 10 / 100;
        $new_bill += $vat;
        $bill->update([ 'total_bill' => $bill->total_bill + $new_bill ]);

        return redirect('restaurant/sales/'.$bill_id);
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
