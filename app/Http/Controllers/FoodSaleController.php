<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Configuration;
use App\FoodMenu;
use App\FoodSale;
use App\Guest;
use App\Http\Traits\BillingTrait;
use App\Http\Traits\CustomTrait;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\Menu;
use App\MenuType;
use App\MISHead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FoodSaleController extends Controller
{
    use CustomTrait, SoftwareConfigurationTrait, BillingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billing = Billing::where('reserved', 0)->orderBy('id', 'desc')->get();
        $data = [];

        foreach ($billing as $bill) {
            $data[$bill->id]['bill'] = 0;
            $food_bill = $bill->restaurant->sum('bill');
            if ( $bill->restaurant->isNotEmpty())
                $data[$bill->id]['bill'] = $food_bill + $food_bill * ( $bill->restaurant[0]->vat + $bill->restaurant[0]->service_charge) / 100;
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
        $billing = Billing::where('reserved', 0)
            ->where('checkout_status', 0)
            ->orderBy('id', 'desc')
            ->get();

        $data['bill_id'] = $request->bill_id ? $request->bill_id : 0;
        $data['menu_type'] = MenuType::all();

        return view('admin.mis.hotel.restaurant.sale.create', compact('billing', 'data'));

    }


    public function menu(Request $request)
    {
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
     */
    public function store(Request $request)
    {
        $food_sale_flag = 0;
        $input = $request->input;

        $vatFood = $request->vat ? $this->getVatFood()->value : 0;
        $vatService = $request->service_charge ? $this->getVatService()->value : 0;
        $softwareDate = $this->getSoftwareDate();

        if ($input[1]['billing_id'] == '0'){
            $guestInfo['name'] = $input[1]['guest_name'];
            $guestInfo['contact_no'] = $input[1]['guest_contact'];

            $billing = $this->createBillingForGuest($guestInfo, $softwareDate);
        }


        foreach ( $input as $key => $item ) {
            if ($item['billing_id'] == '0'){
                $food_sale_flag = 1;
                $item['billing_id'] = $billing->id;
            }

            $bill = Billing::find( $item['billing_id']);
            $old_bill[$bill->id] = 0;
            $new_bill[$bill->id] = 0;
            if ( $bill->restaurant->isNotEmpty()){
                foreach ( $bill->restaurant as $foodSale ) {
                    $old_bill[$bill->id] += $foodSale->bill + $foodSale->bill * ( $foodSale->vat + $foodSale->service_charge) / 100;
                    $new_bill[$bill->id] += $foodSale->bill + $foodSale->bill * ( $vatFood + $vatService) / 100;
                }
            }

            $item['date_id'] = $softwareDate->id;
            $item['discount'] = $item['quantity'] * $item['discount'];
            $item['bill'] = ( FoodMenu::find($item['menu_id'])->price * $item['quantity']) - $item['discount'];
            $food_bill = FoodSale::create( $item);

            $new_bill[$bill->id] += $food_bill->bill + $food_bill->bill * ( $vatFood + $vatService) / 100;

            $bill->total_bill = $bill->total_bill - $old_bill[$bill->id] + $new_bill[$bill->id];
            $bill->save();
            $bill->restaurant()->update([ 'vat' => $vatFood, 'service_charge' => $vatService]);
        }

        if ($food_sale_flag){

//             restautant (personal)
//            $food['amount'] = $input['amount'];
//            if ( isset( $food['amount']) && $food['amount'] != 0 ){
//                $food['ledger'] = $mis_heads->find(3)->ledger->last();
//                $food['payment_type'] = 'food';
//                $total_paid += $this->ais( $food, $bill);
//            }

            $request->session()->flash('create', '<b>Food has been sold And added to the food-sales</b>');
            return redirect()->back();
        } else{
            $request->session()->flash('create', '<b>Food has been sold And added to the bill</b>');
            return redirect('billing/'.$bill->id );
        }
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

    public function saleFoodForNewGuest($guest){
        $check_guest = Guest::where( 'contact_no', $guest->guest_contact)->get()->last();
        $new_guest = Guest::create($guest);

        if ( $check_guest)
            $new_guest->update([ 'appearance' => $check_guest->appearance + 1 ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($bill_id)
    {
        $data['date'] = $this->getDate();

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
        $input = $request->except('_token', '_method');
        $bill = Billing::find($bill_id);
        $vatFood = $request->vat ? $this->getVatFood()->value : 0;
        $vatService = $request->service_charge ? $this->getVatService()->value : 0;
        $softwareDate = $this->getSoftwareDate();


        $new_bill = 0; $old_bill = 0;
        if ( isset($input['food']))
            foreach ($input['food'] as $key => $item) {
                $item['vat'] = $vatFood;
                $item['service_charge'] = $vatService;
                $food = FoodSale::find($key);
                $item['discount'] = $item['discount'] * $item['quantity'];
                $item['bill'] = ( $food->menu->price * $item['quantity']) - $item['discount'];

                $old_bill += $food->bill + $food->bill * ( $food->vat + $food->service_charge) / 100;
                $new_bill += $item['bill'] + $item['bill'] * ( $vatFood + $vatService) / 100;
                $food->update($item);
            }


        if ( isset($input['new_food']))
            foreach ($input['new_food'] as $item) {
                $item['vat'] = $vatFood;
                $item['date_id'] = $softwareDate->id;
                $item['service_charge'] = $vatService;
                $item['discount'] = $item['discount'] * $item['quantity'];
                $item['bill'] = ( FoodMenu::find($item['menu_id'])->price * $item['quantity']) - $item['discount'];

                $new_bill += $item['bill'] + $item['bill'] * ( $vatFood + $vatService) / 100;
                $bill->restaurant()->create($item);
            }

        $bill->update([ 'total_bill' => $bill->total_bill + $new_bill - $old_bill ]);
        $request->session()->flash('update', '<b> Food sale has been updated</b>');

        return redirect()->route('sales.show', $bill->id);
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
