<?php

namespace App\Http\Controllers;

use App\MISHead;
use App\MISHeadChild_I;
use App\MISLedgerHead;
use App\Stock;
use App\StockHead;
use App\UnitType;
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
        $mis_head_id = $request->mis_head_id != 5 ? 4 : 5;
        $mis_heads = MISHeadChild_I::where( 'mis_head_id', $mis_head_id)->get();


        return view('admin.mis.stock.index', compact('mis_heads', 'mis_head_id'));
    }


    public function test()
    {


//        $ledgers = MISLedgerHead::whereIn('mis_head_id', [4,5])->get();
//        foreach ($ledgers as $ledger) {
//            $ledger->currentStock()->create(['date_id' => 0]);
//        }


        $x = MISLedgerHead::all();
//        foreach ($x as $key => $item) {
//            $item->update(['credit_head_id' => 353, 'debit_head_id' => 16, ]);
//            $item->update(['unit_type_id' => 1]);
//        }



        $main = MISHead::find([4, 5]);
        $stock_heads = StockHead::all();
        $code = 1300;

        foreach ($stock_heads as $stock_head) {

            $x = $stock_head->type_id == 3 ? $main->find(4) : $main->find(5);
            $mis_head = $x->child()->create([
                'name' => $stock_head->name,
                'credit_head_id' => $x->credit_head_id,
                'debit_head_id' => $x->debit_head_id,
            ]);

            foreach ( $stock_head->stock as $stock){
                $code += 100;
                $ledger = $mis_head->ledger()->create([
                    'name' => $stock->name,
                    'code' => $code,
                    'mis_head_id' => $mis_head->mis_head_id,
                    'credit_head_id' => $mis_head->credit_head_id,
                    'debit_head_id' => $mis_head->debit_head_id,
                    'unit_type_id' => 1,
                ]);
                $ledger->currentStock()->create([ 'date_id' => 0]);
            }
        }

    }



    public function list($mis_head_id)
    {
        $mis_head_id = ($mis_head_id != 5) ? 4 : 5;
        $categories = MISHeadChild_I::where('mis_head_id', $mis_head_id)->get();
        return view('admin.mis.stock.list', compact('categories', 'mis_head_id'));
    }


    public function opening($mis_head_id)
    {
        $mis_head_id = $mis_head_id != 5 ? 4 : 5;
        $categories = MISHeadChild_I::where('mis_head_id', $mis_head_id)->get();
        $units = UnitType::all();
        return view('admin.mis.stock.opening', compact('categories', 'units'));
    }


    public function balance(Request $request)
    {

        $request->validate([
            'input.*.amount' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
        ], [
            'input.*.amount.regex' => 'Only Decimal Values are Allowed',
        ]);

        $input = $request->input;

        foreach ($input as $key => $item) {
            $ledger = MISLedgerHead::find($key);
            $ledger->update( $item);
            $ledger->currentStock()->where( 'date_id', 0)->update([ 'quantity_dr' => $ledger->amount]);
        }

        $request->session()->flash('update', 'Opening balance has been updated');

        return redirect('stock/opening/'.$ledger->mis_head_id );
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $mis_head_id = $request->mis_head_id != 5 ? 4 : 5;
        $cat_id = $request->cat_id;
        $units = UnitType::all();

        if ( $cat_id)
            return view('admin.mis.stock.create', compact('cat_id', 'mis_head_id', 'units'));

        return view('admin.mis.stock.create', compact('mis_head_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( $request->cat_id)
            $request->validate([
                'name' => 'required',
                'unit_type_id' => 'required',
            ]);

        $request->validate([
            'name' => 'required',
        ]);

        $input = $request->all();


        $mis_head = MISHead::find( $input['mis_head_id']);

        if ( $request->cat_id){
            $kate = MISHeadChild_I::find( $request->cat_id);
            $code= MISLedgerHead::withTrashed()->orderBy('id', 'desc')->first();
            $input['code'] = !$code ? 1000 : $code->code + 100;

            $input['credit_head_id'] = $kate->credit_head_id;
            $input['debit_head_id'] = $kate->debit_head_id;
            $stock = $kate->ledger()->create( $input);

            $stock->currentStock()->create(['date_id' => 0 ]);
            $request->session()->flash('create', '<b>'.$stock->name.'</b> has been added to the <b>'.$stock->ledgerable->name.'</b> category list');
        }
        else{
            $input['credit_head_id'] = $mis_head->credit_head_id;
            $input['debit_head_id'] = $mis_head->debit_head_id;
            $item = $mis_head->child()->create( $input);
            $request->session()->flash('create', '<b>'.$item->name.'</b> has been added to the category list');
        }
        return redirect('stock?mis_head_id='.$request->mis_head_id);
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
        $mis_head = MISHeadChild_I::find( $id);
        $units = UnitType::get();
        return view('admin.mis.stock.edit', compact('mis_head', 'units'));

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
            'input.*.unit_type_id' => 'required',
        ],[
            'name.required' => 'Please Enter Category Name',
            'input.*.name.required' => 'Please Enter Item Name',
            'input.*.unit_type_id.required' => 'Please Select A Unit',
        ]);
//        return $request->all();
        $input = $request->input ? $request->input : [];
        $mis_head = MISHeadChild_I::find( $id);

        foreach ( $input as $key => $item) {
                $mis_head->ledger->find( $key)->update( $item);
            }

        $mis_head->update( $request->except('_token', 'input'));
        return redirect('stock?mis_head_id='.$mis_head->mis_head_id)->with('update', '<b>'. $mis_head->name.'</b> has been Updated successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
//        return $request->all();

        $i = 0; $operation = false;

        if ( !$request->type){
            $mis_head = MISHeadChild_I::find($id);
            $cat = '<b>'.$mis_head->name.'</b>';

            if ( $mis_head->ledger->isNotEmpty() ){
                foreach ( $mis_head->ledger as $item) {
                    if ( $item->purchases->isEmpty() && $item->deliveries->isEmpty()){
                        $item->currentStock()->where('date_id', 0)->delete();
                        $item->delete(); $i++;
                    }
                 $operation = count( $mis_head->ledger) == $i ? true : false;
                }
            }

            $operation = $mis_head->ledger->isNotEmpty() ? false : true;

            if ( $operation)
                $mis_head->delete();

            $operation ? $request->session()->flash('success', $cat. ' has been removed from category list') : $request->session()->flash('warning', 'Not all Items in category '.$cat.' is Empty');

        }

        if ( $request->type){

            $item = MISLedgerHead::find($id);

            if( $item->purchases->isEmpty() && $item->deliveries->isEmpty() && count($item->currentStock) == 1 ){
                $item->currentStock()->where('date_id', 0)->delete();
                $item->delete();
                $operation = true;
            }

            $operation ? $request->session()->flash('success', '<b>'.$item->name.'</b> has been deleted successfully') : $request->session()->flash('failed', '<b> Operation Unsuccessful. '.$item->name.'</b> Has Dependencies.');
        }


        return 101;


    }



}
