<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Date;
use App\Delivery;
use App\MISHeadChild_I;
use App\MISLedgerHead;
use App\Stock;
use App\StockHead;
use App\Unit;
use App\UnitType;
use Illuminate\Http\Request;

class StockDeliverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::orderBy('id', 'desc')->get();
//        return $deliveries;
        return view('admin.mis.stock.deliver.index', compact('deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stock_head = MISHeadChild_I::where( 'mis_head_id', 4)->has('ledger')->get();
        $data['units'] = Unit::get(['id', 'name', 'unit_type_id']);

        return view('admin.mis.stock.deliver.create', compact('stock_head', 'data'));
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

        $input = $request->input;
        $conf_date = Configuration::find(1)->software_start_date;
        $date = Date::where( 'date', $conf_date)->first();

        if ( empty($date) )
            $date = Date::create([ 'date' => $conf_date ]);

        foreach ($input as $item) {
            $stock = MISLedgerHead::find($item['stock_id']);
            $unit = $stock->unitType->units->find( $item['unit_id']);
            $quantity = $item['quantity'] / $unit->multiply_by;
            $total = $stock->currentStock->sum('quantity_dr') - $stock->currentStock->sum('quantity_cr');
            $item['quantity'] = $quantity > $total ? $total * $unit->multiply_by : $item['quantity'];

            $item['date_id'] = $date->id;
            $item['quantity_cr'] = $item['quantity'] / $unit->multiply_by;
            $cr_stock = $stock->currentStock()->create($item);
            $item['current_stock_id'] = $cr_stock->id;
            $stock->deliveries()->create($item);
        }


        $request->session()->flash('success', 'Items has been Delivered successfully');
        return redirect('stocks/deliver');

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
        $delivery = Delivery::find($id);
        $data['units'] = Unit::all();

        if ( $delivery)
            return view('admin.mis.stock.deliver.edit', compact('delivery', 'data'));

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
//        return $request->all();
        $input = $request->all();
        $delivery = Delivery::find( $id);
        $unit = $delivery->ledger->unitType->units->find( $input['unit_id']);
        $quantity_cr = $input['quantity'] / $unit->multiply_by;
        $total = $delivery->ledger->currentStock->sum('quantity_dr') - $delivery->ledger->currentStock->sum('quantity_cr') + $delivery->quantity / $delivery->unit->multiply_by;

        $input['quantity'] = $quantity_cr > $total ? $total * $unit->multiply_by : $input['quantity'];
        $delivery->update( $input);
        $delivery->currentStock->update([ 'quantity_cr' => $input['quantity'] / $unit->multiply_by ]);


        return redirect('stocks/deliver')->with('update', '<b>Operation successful</b>');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery = Delivery::find( $id);
        $delivery->currentStock->delete();
        $delivery->delete();

        session()->flash('success', '<b>Operation successful.</b> Delivery has been deleted');
        return 200;
    }
}
