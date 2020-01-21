<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\MisAccountHead;
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
        $type = MisAccountHead::orderBy('id')->get();
        $theads = TransactionHead::where('code','!=', 353)->get();
        $configuration = Configuration::find(1);
//        return $type;
        return view('admin.mis.index', compact('type', 'theads', 'configuration'));

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

        $input = $request->data;
//        Configuration::find(1)->update(['software_start_date' => $request->software_start_date]);

        $accounts = MisAccountHead::all();
        foreach ( $input as $key => $item) {
            $accounts->find($key)->update( $item);
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
