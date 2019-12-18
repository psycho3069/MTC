<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  // type_id = 3 - Restaurant, cat_id = 1 - supplier,

        $data['type_id'] = $request->type_id ? $request->type_id : 3;
        $data['cat_id'] = $request->cat_id ? $request->cat_id : 1;
        $suppliers = Staff::where( 'type_id', $data['type_id'])->get();
        $receivers = Employee::where('type_id', $data['type_id'])->get();
        if ( $data['cat_id'] == 1)
            return view('admin.mis.staff.index', compact( 'data', 'suppliers'));
        if ( $data['cat_id'] == 2)
            return view('admin.mis.staff.index', compact( 'data', 'receivers'));
    }


    public function create(Request $request)
    {
        //type_id = 3 - Restaurant, cat_id = 1 - supplier,

        $data['type_id'] = $request->type_id ? $request->type_id : 3;
        $data['cat_id'] = $request->cat_id ? $request->cat_id : 1;
        $receivers = Employee::all();
        if ( $data['cat_id'] == 2)
            return view('admin.mis.staff.create', compact('data', 'receivers'));

        return view('admin.mis.staff.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //type_id = 3 - Restaurant, cat_id = 1 - supplier,

//        return $request->all();
        $input = $request->all();
        if ($input['cat_id'] == 1)
            Staff::create($input);
        if ( $input['cat_id'] == 2)
            Employee::find($request->employee_id)->update($input);
        return redirect('staff?type_id='.$request->type_id.'&cat_id='.$request->cat_id);
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
