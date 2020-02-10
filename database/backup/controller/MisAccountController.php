<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\MisAccountHead;
use App\MISHead;
use App\TransactionHead;
use Illuminate\Http\Request;

class MisAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function main(Request $request)
    {
        $type = $request->type ? $request->type : 'hotel';
        $accounts = MisAccountHead::where( 'type', $type)->get();
        return view('admin.mis.index', compact('accounts', 'type'));

    }

    public function index()
    {
//        $type = MisAccountHead::orderBy('id')->get();
        $theads = TransactionHead::where('code','!=', 353)->get();
        $conf = Configuration::all();
//        return view('admin.mis.index', compact('type', 'theads', 'conf'));
        $mis_heads = MISHead::find([ 1, 2, 3, 6]);
//        return $mis_heads->first()->ledger[0]->credit_head_id;
        return view('admin.mis.index', compact('conf', 'mis_heads', 'theads'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = $request->type;
        $theads = TransactionHead::all();
        return view('admin.mis.create', compact('type', 'theads'));
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
            'software_start_date' => 'required',
        ],[
            'software_start_date.required' => 'Please Enter Software Date',
        ]);
        Configuration::find(1)->update(['software_start_date' => $request->software_start_date]);
        $input = $request->data;
        foreach ($request->conf as $key => $val) {
            Configuration::where( 'name', $key)->update([ 'value' => $val]);
        }

//        $accounts = MisAccountHead::all();
//        foreach ( $input as $key => $item) {
//            $accounts->find($key)->update( $item);
//        }
        return redirect()->back()->with('update', 'Configuration updated successfully');
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
