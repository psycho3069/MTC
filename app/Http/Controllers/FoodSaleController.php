<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Configuration;
use App\FoodMenu;
use App\FoodSale;
use App\Menu;
use App\MenuType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FoodSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $sales = FoodSale::get()->groupBy('billing_id');
        $billing = Billing::where('reserved', 0)->orderBy('id', 'desc')->get();
        $data = [];

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

        $billing = Billing::where('reserved', 0)->where('checkout_status', 0)->orderBy('id', 'desc')->get();
        $data['menu_type'] = MenuType::all();

        return view('admin.mis.hotel.restaurant.sale.create', compact('billing', 'data'));

    }


    public function menu(Request $request)
    {
//        return $request->all();
        $menu_type = MenuType::find( $request->menu_type);
        foreach ($menu_type->menu as $item) {
            $data['menu'][$item->id]['name'] = $item->name;
            $data['menu'][$item->id]['price'] = $item->price;
        }

        return $data;

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

        $vat = $request->vat ? Configuration::where('name', 'vat_food')->first()->value : 0;
        $service_charge = $request->service_charge ? Configuration::where('name', 'vat_service')->first()->value : 0;

//        return $item;
        foreach ( $input as $item ) {
            $bill = Billing::find( $item['billing_id']);
            $old_bill[$bill->id] = 0;
            $new_bill[$bill->id] = 0;
            if ( $bill->restaurant->isNotEmpty()){
                foreach ( $bill->restaurant as $val ) {
                    $old_bill[$bill->id] += $val->bill + $val->bill * ( $val->vat + $val->service_charge) / 100;
                    $new_bill[$bill->id] += $val->bill + $val->bill * ( $vat + $service_charge) / 100;
                }
            }

            $item['discount'] = $item['quantity'] * $item['discount'];
            $item['bill'] = ( FoodMenu::find($item['menu_id'])->price * $item['quantity']) - $item['discount'];
            $food_bill = FoodSale::create( $item);

            $new_bill[$bill->id] += $food_bill->bill + $food_bill->bill * ( $vat + $service_charge) / 100;

            $bill->total_bill = $bill->total_bill - $old_bill[$bill->id] + $new_bill[$bill->id];
            $bill->save();
            $bill->restaurant()->update([ 'vat' => $vat, 'service_charge' => $service_charge]);
        }

        $request->session()->flash('create', '<b>Food has been sold And added to the bill</b>');

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
        $data['vat']['%'] = $bill->restaurant->isNotEmpty() ? $bill->restaurant[0]->vat : 0;
        $data['service']['%'] = $bill->restaurant->isNotEmpty() ? $bill->restaurant[0]->service_charge : 0;

        $data['vat']['total'] = $bill->restaurant->sum('bill') * $data['vat']['%'] / 100;
        $data['service']['total'] = $bill->restaurant->sum('bill') * $data['service']['%'] / 100;
        $data['total'] = $bill->restaurant->sum('bill') + $data['vat']['total'] + $data['service']['total'];
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

//        return 3 + 3 *( 3 + 2) / 10;
        $input = $request->except('_token', '_method');
        $bill = Billing::find($bill_id);

        $vat = $request->vat ? Configuration::where('name', 'vat_food')->first()->value : 0;
        $service_charge = $request->service_charge ? Configuration::where('name', 'vat_service')->first()->value : 0;

        $new_bill = 0; $old_bill = 0;
        if ( isset($input['food']))
            foreach ($input['food'] as $key => $item) {
                $item['vat'] = $vat;
                $item['service_charge'] = $service_charge;
                $food = FoodSale::find($key);
                $item['discount'] = $item['discount'] * $item['quantity'];
                $item['bill'] = ( $food->menu->price * $item['quantity']) - $item['discount'];

                $new_bill += $item['bill'] + $item['bill'] * ( $vat + $service_charge) / 100;
                $old_bill += $food->bill + $food->bill * ( $food->vat + $food->service_charge) / 100;
                $food->update($item);
            }


        if ( isset($input['new_food']))
            foreach ($input['new_food'] as $item) {
                $item['vat'] = $vat;
                $item['service_charge'] = $service_charge;
                $item['discount'] = $item['discount'] * $item['quantity'];
                $item['bill'] = ( FoodMenu::find($item['menu_id'])->price * $item['quantity']) - $item['discount'];

                $new_bill += $item['bill'] + $item['bill'] * ( $vat + $service_charge) / 100;
                $bill->restaurant()->create($item);
            }

        $bill->update([ 'total_bill' => $bill->total_bill + $new_bill - $old_bill ]);
        $request->session()->flash('update', 'Sale has been updated');

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
