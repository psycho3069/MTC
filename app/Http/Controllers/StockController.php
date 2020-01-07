<?php

namespace App\Http\Controllers;

use App\Stock;
use App\StockHead;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type_id = $request->type_id != 5 ? 3 : 5;
        $stock_heads = StockHead::where( 'type_id', $type_id)->get();
        return view('admin.mis.stock.index', compact('stock_heads', 'type_id'));
    }



    public function list($type_id)
    {
        $type_id = ($type_id != 5) ? 3 : 5;
        $categories = StockHead::where('type_id', $type_id)->get();
        return view('admin.mis.stock.list', compact('categories'));
    }


    public function opening($type_id)
    {
        $type_id = ($type_id != 5) ? 3 : 5;
        $categories = StockHead::where('type_id', $type_id)->get();
        return view('admin.mis.stock.opening', compact('categories'));
    }


    public function balance(Request $request)
    {
        $input = $request->input;
//        return $input;
        foreach ($input as $key => $item) {
            $stock = Stock::find($key);
            $stock->update( $item);
            $stock->currentStock()->where( 'date_id', 0)->first()->update([ 'quantity_dr' => $stock->quantity]);
        }

        return redirect('stock/opening/'.$stock->stockHead->type_id);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type_id = $request->type_id != 5 ? 3 : 5;
        $stock_head_id = $request->stock_head_id;
        if ( $stock_head_id)
            return view('admin.mis.stock.create', compact('stock_head_id', 'type_id'));

        return view('admin.mis.stock.create', compact('type_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        if ($request->stock_head_id){
            $stock = Stock::create($input);
            $stock->currentStock()->create(['date_id' => 0 ]);
        }
        else {
            $input['type_id'] = $request->type_id;
            $input['category'] = $request->type_id ==3 ? 'restaurant' : 'inventory';
            StockHead::create($input);
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
