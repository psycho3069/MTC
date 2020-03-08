<?php

namespace App\Http\Controllers;

use App\Unit;
use App\UnitType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unit_types = UnitType::get();

//        $unit_types = Unit::onlyTrashed()->restore();
//        return $unit_types;

        return view('admin.mis.stock.units.index', compact('unit_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type_id = $request->type_id ? $request->type_id : '';
        if ( $type_id)
            return view('admin.mis.stock.units.create', compact('type_id'));

        return view('admin.mis.stock.units.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( $request->type_id)
            $request->validate([
                'name' => 'required',
                'short_name' => 'required',
                'multiply_by' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
            ], [
                'multiply_by.required' => 'Please Enter Unit Value',
                'multiply_by.regex' => 'Only Decimal Values Are Allowed',
            ]);

        $request->validate([
            'name' => 'required',
            'short_name' => 'required',
        ]);


        if ( !$request->type_id)
            $item = UnitType::create( $request->all());

        if ( $request->type_id){
            $item = UnitType::find( $request->type_id);
            $item = $item->units()->create( $request->all());
        }

        return redirect('units')->with('success', '<b>'.$item->name.'</b> has been created Successfully');
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
        $unit_type = UnitType::find($id);

        return view('admin.mis.stock.units.edit', compact('unit_type'));
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
            'short_name' => 'required',
            'input.*.name' => 'required',
            'input.*.short_name' => 'required',
            'input.*.multiply_by' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
        ],[
            'name.required' => 'Please Enter Name',
            'short_name.required' => 'Please Enter Short Name',
            'input.*.name.required' => 'Please Enter Unit Name',
            'input.*.short_name.required' => 'Please Enter Unit Short Name',
            'input.*.multiply_by.required' => 'Please Enter Units Info',
            'input.*.multiply_by.regex' => 'Only Decimal Values Are Allowed',
        ]);

        $input = $request->input ? $request->input : [];
        $type = UnitType::find($id);
        foreach ( $input as $key => $item) {
            $type->units->find($key)->update( $item);
        }

        $type->update( $request->except('_token', 'input'));

        return redirect('units')->with('update', '<b>'. $type->name.'</b> has been Updated successfully');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
//        return $request->id .' ->' .$id;

        $i = 0; $operation = false;

        if ( !$request->type){
            $type = UnitType::find($id);
            $cat = '<b>'.$type->name.'</b>';

            if ( $type->units->isNotEmpty() ){
                foreach ( $type->units as $unit) {
                    if ( $unit->inPurchase->isEmpty() && $unit->inDelivery->isEmpty()){
                        $unit->delete();
                        $i++;
                    }
                }
                $operation = count( $type->units) == $i ? true : false;
            }

            $operation = $type->inLedger->isNotEmpty() ? false : true;

            if ( $operation)
                $type->delete();

            $operation ? $request->session()->flash('success', $cat. ' has been removed from Unit List') : $request->session()->flash('failed', '<b>Operation Unsuccessful!</b> Not all units in '.$cat.' type is Empty');

        }

        if ( $request->type){
            $unit = Unit::find($id);
            if( $unit->inPurchase->isEmpty() && $unit->inDelivery->isEmpty() ){
                $unit->delete();
                $operation = true;
            }

            $operation ? $request->session()->flash('success', '<b>'.$unit->name.'</b> has been removed from unit list successfully') : $request->session()->flash('failed', '<b> Operation Unsuccessful! '.$unit->name.'</b> Has Dependencies.');
        }

        return 101;
    }
}
