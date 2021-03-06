<?php

namespace App\Http\Controllers;

use App\Stock;
use App\StockHead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LedgerHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type_id = $request->type_id != 5 ? 4 : 5;
        $stock_heads = StockHead::where( 'type_id', $type_id)->get();
        return view('admin.mis.stock.index', compact('stock_heads', 'type_id'));
    }



    public function list($type_id)
    {
        $type_id = ($type_id != 5) ? 3 : 5;
        $categories = StockHead::where('type_id', $type_id)->get();
        return view('admin.mis.stock.list', compact('categories', 'type_id'));
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

        $request->session()->flash('update', 'Opening balance has been updated');

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

        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Please Enter Category Name',
        ]);

        $input = $request->all();

        if ($request->stock_head_id){
            $stock = Stock::create($input);
            $stock->currentStock()->create(['date_id' => 0 ]);
            $request->session()->flash('create', '<b>'.$stock->name.'</b> has been added to the <b>'.$stock->stockHead->name.'</b> category list');
        }
        else {
            $input['type_id'] = $request->type_id;
            $input['category'] = $request->type_id ==3 ? 'restaurant' : 'inventory';
            $item = StockHead::create($input);
            $request->session()->flash('create', '<b>'.$item->name.'</b> has been added to the category list');
        }
        return redirect('stock?type_id='.$request->type_id);
//        return redirect()->back();
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
//        return $stock_head->stock;
        $stock_head = StockHead::find( $id);
        return view('admin.mis.stock.edit', compact('stock_head'));

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
        $request->validate([
            'name' => 'required',
            'input.*.name' => 'required',
            'input.*.unit' => 'required',
        ],[
            'name.required' => 'Please Enter Category Name',
            'input.*.name.required' => 'Please Enter Item Name',
            'input.*.unit.required' => 'Please Select A Unit',
        ]);
//        return $request->all();
        $input = $request->input;
        $stock_head = StockHead::find( $id);

        if( $request->input)
            foreach ( $input as $key => $item) {
                $stock_head->stock->find( $key)->update( $item);
            }

        $stock_head->update( $request->except('_token', 'input'));
        return redirect('stock?type_id='.$stock_head->type_id)->with('update', 'Updated successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
//        return $request->all();

        $i = 0; $operation = false;

        if ( !$request->type){
            $stock_head = StockHead::find($id);
            $cat = '<b>'.$stock_head->name.'</b>';

            if ( $stock_head->stock->isNotEmpty() ){
                foreach ( $stock_head->stock as $item) {
                    if ( $item->purchase->isEmpty() && $item->deliver->isEmpty()){
                        $item->currentStock()->where('date_id', 0)->delete();
                        $item->delete(); $i++;
                    }
                    $operation = count($stock_head->stock) == $i ? true : false;
                }
            }

            if ( $stock_head->stock->isEmpty())
                $operation = true;

            if ( $operation)
                $stock_head->delete();

            $operation ? $request->session()->flash('success', $cat. ' has been removed from category list') : $request->session()->flash('warning', 'Not all Items in category '.$cat.' is Empty');

        }

        if ( $request->type){
            $item = Stock::find($id);
            if( $item->purchase->isEmpty() && $item->deliver->isEmpty()){
                $item->currentStock()->where('date_id', 0)->delete();
                $item->delete();
                $operation = true;
            }

            $operation ? $request->session()->flash('success', '<b>'.$item->name.'</b> has been deleted successfully') : $request->session()->flash('failed', '<b> Operation Unsuccessfull. '.$item->name.'</b> Has Dependencies.');
        }


        return 101;


    }



}
