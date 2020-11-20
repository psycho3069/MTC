<?php

namespace App\Http\Controllers;

use App\Process;
use App\TransactionHead;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $theads = TransactionHead::orderBy('ac_head_id', 'asc')->get();
        $theads->load('transactionable');
        return view('admin.ais.account.balance.index', compact( 'theads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $debit = collect( $request->debit );
        $credit = collect( $request->credit );

        if ( $debit->sum() == $credit->sum() ){

            foreach ( $debit as $key => $balance_dr ) {
                $thead = TransactionHead::find( $key );
                $thead->amount = ( $thead->ac_head_id == 1 || $thead->ac_head_id == 4 ) ?  ( $balance_dr - $credit[$key] ) : ( $credit[$key] - $balance_dr );
                $thead->debit = $balance_dr;
                $thead->credit = $credit[$key];
                $thead->save();

                $thead->currentBalance()->updateOrCreate(['date_id' => 0], [
                    'debit' => $thead->debit,
                    'credit' => $thead->credit,
                    'amount' => $thead->amount,
                ]);
            }

            $request->session()->flash('update', '<b>Opening Balance</b> has been successfully updated');


            return redirect('accounts/balance');
        } else{
            $request->session()->flash('danger', '<b>Failed!! </b> Debit and Credit isn\'t equal');
            return redirect()->back()->withInput();
        }

    }



    public function check(Request $request)
    {
        $debit = collect( array_combine( $request->debit_key, $request->debit_val ));
        $credit = collect( array_combine($request->credit_key, $request->credit_val) );
        $debit_total = $debit->sum();
        $credit_total = $credit->sum();

        if ( $debit_total != $credit_total )
                return response()->json(['error'=> 'Debit and Credit Isn\'t Equal ' ]);
        else  {
            foreach ( $debit as $key => $item ) {
                $thead = TransactionHead::find( $key );
                $thead->amount = ( $thead->ac_head_id == 1 || $thead->ac_head_id == 4 ) ?  ( $item - $credit[$key] ) : ( $credit[$key] - $item );
                $thead->debit = $item;
                $thead->credit = $credit[$key];
//                $thead->amount += $balance;
                $thead->save();

                $op_bl = $thead->currentBalance->where( 'date_id', 0 )->first();

                $all_bl = Process::where( 'thead_id', $thead->id )->get();

                foreach ( $all_bl as $current_bl ) {
                    $current_bl->update([
                        'debit' => $thead->debit - $op_bl->debit + $current_bl->debit,
                        'credit' => $thead->credit - $op_bl->credit + $current_bl->credit,
                        'amount' => $thead->amount - $op_bl->amount + $current_bl->amount,
                    ]);
                }
//                return $thead->currentBalance;
            }
            return response()->json(['success' => 'Opening Balance Successfully Updated. ']);

        }






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
