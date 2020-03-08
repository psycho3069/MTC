<?php

namespace App\Http\Controllers;

use App\AccountHead;
use App\AccountHeadChild_I;
use App\AccountHeadChild_II;
use App\AccountHeadChild_III;
use App\AccountHeadChild_IV;
use App\TransactionHead;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $heads = AccountHead::all();
        return view('admin.ais.account.index', compact('heads'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = $request->type;

        $data['parent'] = AccountHead::findOrfail($request->head);

        if ( $request->child_i )
            $data['child_i'] = AccountHeadChild_I::findOrfail( $request->child_i);

        if ( $request->child_ii )
            $data['child_ii'] = AccountHeadChild_II::findOrfail( $request->child_ii);

        if ( $request->child_iii )
            $data['child_iii'] = AccountHeadChild_III::findOrfail( $request->child_iii);

//        return $data;

//        return $request->all();
        return view('admin.ais.account.create', compact('data', 'type'));
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

        $request->validate([
            'name' => 'required',
            'code' => 'required',
        ],[
            'name.required' => 'Please Enter A Name',
            'code.required' => 'Please Enter A Code',
        ]);

        $type = $request->type;
        $input = $request->all();
        $input['ac_head_id'] = $request->parent;

        if ( $request->child_iii ){
            if ( $type != 2 ) {
                $input['ac_head_child_iii_id'] = $request->child_iii;
                AccountHeadChild_IV::create($input);
            } else {
                $head = AccountHeadChild_III::find( $request->child_iii );
                $thead = $head->transaction()->create( $input );
                $thead->currentBalance()->create();
            }
        } elseif ( $request->child_ii ){
            if ( $type != 2 ){
                $input['ac_head_child_ii_id'] = $request->child_ii;
                AccountHeadChild_III::create($input);
            } else {
                $head = AccountHeadChild_II::find( $request->child_ii );
                $thead = $head->transaction()->create( $input );
                $thead->currentBalance()->create();
            }
        } elseif ( $request->child_i ){
            if ( $type != 2 ){
                $input['ac_head_child_i_id'] = $request->child_i;
                AccountHeadChild_II::create($input);
            } else {
                $head = AccountHeadChild_I::find( $request->child_i );
                $thead = $head->transaction()->create( $input );
                $thead->currentBalance()->create();
            }
        } elseif ( $request->parent ){
            if ( $type != 2 ){
                AccountHeadChild_I::create($input);
            } else {
                $head = AccountHead::find( $request->parent );
                $thead = $head->transaction()->create( $input );
                $thead->currentBalance()->create();
            }
        }

        $request->session()->flash('create', 'Operation Successful');


        return redirect('accounts');

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
        $thead = TransactionHead::find($id);

        if ( $thead->currentBalance->sum('debit') || $thead->currentBalance->sum('credit'))
            return redirect()->back()->with('delete', 'Operation can\'t be done.');

        $thead->currentBalance()->delete();
        $thead->delete();
        return redirect()->back()->with('success', 'Operation Successful');
    }



    public function balance()
    {
        $heads = AccountHead::all();
        $theads = TransactionHead::all();

        $data = TransactionHead::find(11);
//        return $data->transactionable->parent;
        foreach ($theads as $thead) {
//            echo $thead->name.' - ';
//            echo $thead->transactionable->id.'-'.$thead->transactionable->name.'<br>';
            if ( $id = $thead->transactionable->ac_head_child_ii_id )
                echo $thead->transactionable->parent->parent->parent->name.'&rarr;'.$thead->transactionable->parent->parent->name.'&rarr;'.$thead->transactionable->parent->name.'&rarr;'.$thead->transactionable->name;
        }
        return view('admin.ais.account.opening_balance', compact('heads', 'theads'));
    }
}
