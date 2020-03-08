<?php

namespace App\Http\Controllers;

use App\Stock;
use App\StockHead;
use Illuminate\Http\Request;

class MisInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = StockHead::all();
        return view('admin.mis.inventory.index', compact('inventories'));
    }


    public function list()
    {
        $categories = StockHead::where('category', 'inventory')->get();
        return view('admin.mis.inventory.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stock_head_id = $request->stock_head_id;
        if ( $stock_head_id)
            return view('admin.mis.inventory.create', compact('stock_head_id'));

        return view('admin.mis.inventory.create' );
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

        if ($request->stock_head_id)
            Stock::create($input);
         else {
            $input['type_id'] = 5;
            $input['category'] = 'inventory';
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
