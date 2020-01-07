<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Employee;
use App\Http\Traits\CustomTrait;
use App\MisCurrentStock;
use App\Staff;
use App\StockHead;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    use CustomTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        return $request->all();
        $data = [];
        $type_id = $request->type_id != 5 ? 3 : 5;
        $stock_head = StockHead::where( 'type_id', $type_id)->get(['id']);
        foreach ( $stock_head as $item) {
            if ($item->stock->isNotEmpty())
                $data[] = $item->stock->modelKeys(['amount']);
        }
        $stock_id = collect($data)->flatten();
        $current_stock = MisCurrentStock::whereIn( 'stock_id', $stock_id)->get();
        return view('admin.mis.purchase.index', compact('current_stock'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type_id = $request->type_id != 5 ? 3 : 5;
        $data['supplier'] = Staff::get()->where( 'type_id', $type_id);
        $data['receiver'] = Employee::get()->where( 'type_id', $type_id);
        $stock_head = StockHead::where( 'type_id', $type_id)->get();
        $conf = Configuration::find(1)->software_start_date;
        return view('admin.mis.purchase.create', compact('stock_head', 'type_id', 'data', 'conf'));
    }


    public function item(Request $request)
    {
//        return $request->all();
        $data = StockHead::find($request->stock_head_id);
        return $data->stock->pluck('name', 'id');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request->all();

        $input = collect($request->input);
//        return $voucher;
        if ( $request->mis_ac_head_id == 3)
            $data['type'] = 'restaurant_pv';
        if ( $request->mis_ac_head_id == 5)
            $data['type'] = 'inventory_pv';

        $data['mis_ac_head_id'] = $request->mis_ac_head_id;
        $data['amount'] = $input->sum('amount');
        $date = Configuration::find(1)->software_start_date;

        $mis_voucher = $this->computeAIS( $data, $date );

        $p_group['date_id'] = $mis_voucher->date->id;
        $p_group['user_id'] = auth()->user()->id;
        $p_group['type_id'] = $data['mis_ac_head_id'];

        $purchase_group = $mis_voucher->purchaseGroup()->create( $p_group);

        foreach ($input as $item) {
//            return $item;
            $item['quantity_dr'] = $item['quantity'];
            $purchase = $purchase_group->purchases()->create( $item);


            $joji['stock_id'] = $item['stock_id'];
            $joji['quantity_dr'] = $item['quantity_dr'];
            $mis_stock = MisCurrentStock::where('stock_id', $item['stock_id'])->where('date_id', $purchase_group->date_id )->get()->first();
            if ( $mis_stock)
                $mis_stock->update(['quantity_dr' => $mis_stock->quantity_dr + $item['quantity_dr'] ]);
            else
                $purchase_group->date->misStock()->create( $joji);
        }

        return redirect()->back();

    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
