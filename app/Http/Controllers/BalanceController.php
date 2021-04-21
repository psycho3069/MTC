<?php

namespace App\Http\Controllers;

use App\AccountHeadChild_I;
use App\AccountHeadChild_II;
use App\AccountHeadChild_III;
use App\Http\Traits\SystemConfigurationTrait;
use App\Process;
use App\TransactionHead;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BalanceController extends Controller
{
    use SystemConfigurationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = TransactionHead::query();

        $query->with([
            'accountHead' => function($query){
                $query->select('id', 'name', 'code');
            },

            'transactionable' => function(MorphTo $morphTo){
            $morphTo->morphWith([
                AccountHeadChild_I::class => ['parent:id,name,code'],
                AccountHeadChild_II::class => ['parent.parent:id,name,code'],
                AccountHeadChild_III::class => ['parent.parent.parent:id,name,code'],
            ]);
        }]);

        $query->orderBy('ac_head_id', 'asc');
        $theads = $query->get();

        $data = [];

        $count = 0;
        foreach ($theads as $thead) {
            $count++;
            $parent = "";
            $info = (object)[];
            $info->id = $thead->id;
            $info->name = $thead->name;
            $info->code = $thead->code;
            $info->debit = $thead->debit;
            $info->credit = $thead->credit;
            $info->amount = $thead->amount;
            $info->ac_head_id = $thead->ac_head_id;
            $info->ac_head_name = $thead->accountHead->name;

            if($thead->transactionable->ac_head_child_ii_id){
                $parent = $thead->transactionable->parent->parent->name.'-'. $thead->transactionable->parent->name.'-';
            }

            if($thead->transactionable->ac_head_child_i_id){
                $parent = $thead->transactionable->parent->name;
            }

//            $info->parent = $info->ac_head_name.'-'.$parent.'-'.$thead->transactionable->name;
            $info->parent = $thead->transactionable->name;

            $data[$count] = $info;
        }

        $total['debit'] = $theads->sum('debit');
        $total['credit'] = $theads->sum('credit');

//        return view('admin.ais.account.balance.openeing-balance', compact( 'data', 'total'));
        return view('admin.ais.account.balance.list', compact( 'data', 'total'));
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

        $startDate = $this->getSoftwareStartDate();

        DB::beginTransaction();
        try {
            if ( $debit->sum() == $credit->sum() ){
                foreach ( $debit as $key => $balance_dr ) {
                    $thead = TransactionHead::find($key);

                    /*
                     * get Current balance for software start date
                     * subtract the old amount and add the new amount
                     * */
                    $currentBalance = Process::firstOrNew([
                        'thead_id' => $thead->id,
                        'date_id' => $startDate->id
                    ]);

                    $currentBalance->debit = $currentBalance->debit - $thead->debit + $balance_dr;
                    $currentBalance->credit = $currentBalance->credit - $thead->credit + $credit[$key];
                    $currentBalance->save();

                    /*
                     * Update Transaction head data
                     * For Asset & Expense balance = debit - credit
                     * For Liability, income balance = credit - debit
                     * */

                    $thead->debit = $balance_dr;
                    $thead->credit = $credit[$key];

                    if ($thead->ac_head_id == 1 || $thead->ac_head_id == 4){
                        $thead->amount = $thead->debit - $thead->credit;
                    }

                    if ($thead->ac_head_id == 2 || $thead->ac_head_id == 3 || $thead->ac_head_id == 5){
                        $thead->amount = $thead->credit - $thead->debit;
                    }

                    $thead->save();

                }

                DB::commit();
                session()->flash('update', '<b>Opening Balance</b> has been successfully updated');
            }else{
                session()->flash('danger', '<b>Failed!! </b> Debit and Credit isn\'t equal');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('danger', '<b>Internal server error</b>');
            Log::error($exception->getMessage(), $exception->getTrace());
        }

        return redirect()->back()->withInput();
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
