<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Date;
use App\Delivery;
use App\Stock;
use App\StockHead;
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
        $stock_head = StockHead::where( 'type_id', 3)->get();
        return view('admin.mis.stock.deliver.create', compact('stock_head'));

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
//        return $input;

        $conf_date = Configuration::find(1)->software_start_date;
        $date = Date::where( 'date', $conf_date)->first();

        if ( empty($date) )
            $date = Date::create([ 'date' => $conf_date ]);

        foreach ($input as $item) {
            $stock = Stock::find($item['stock_id']);
            $total = $stock->currentStock->sum('quantity_dr') - $stock->currentStock->sum('quantity_cr');

            if ( $total >= $item['quantity']){
                $item['date_id'] = $date->id;
                $stock->deliver()->create($item);

                $item['quantity_cr'] = $item['quantity'];
                $stock->currentStock()->create($item);
            }

        }

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
