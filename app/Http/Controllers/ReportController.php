<?php

namespace App\Http\Controllers;

use App\AccountHead;
use App\AccountHeadChild_II;
use App\Date;
use App\Process;
use App\TransactionHead;
use App\Voucher;
use App\VoucherGroup;
use App\VoucherType;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function indexOld()
    {
        $ac_head = AccountHead::find([3,4]);

        foreach ($ac_head as $head) {
            if ( $head->id == 3 )
                foreach ( $head->theads as $income)
                    $data['income'][] = $income->id;
            if ( $head->id == 4)
                foreach ( $head->theads as $expense )
                    $data['expense'][] = $expense->id;
        }

//        $balance['income'] = Process::whereIn('thead_id', $data['income'])->get()->groupBy('date_id');
//        $balance['expense'] = Process::whereIn('thead_id', $data['expense'])->get()->groupBy('date_id');

        return view('admin.ais.report.index', compact('all_bl', 'data'));
    }



    public function indexOld3()
    {
        $head = AccountHead::find(3);

        $current_bl = Process::where( 'date_id', 1)->get();

        foreach ($head->child as $child_i) {
            if ( $child_i->transaction()->exists())
                foreach ($child_i->transaction as $thead)
                    foreach ($thead->currentBalance->where('date_id', 1) as $bl)
                        echo $bl->debit.'<br>';
        }
//        return view('admin.ais.report.index', compact('head'));
    }


    public function incomeOld()
    {

        $heads = AccountHead::find([3,4]);
        foreach ($heads as $head){
            foreach ($head->theads as $thead )
                if ( count($thead->currentBalance->Where( 'date_id', 0)))
                    $balance[$head->id][] = $thead->currentBalance->firstWhere( 'date_id', 0);
        }

        return $balance[3]->first();


        return view('admin.ais.report.income', compact('balance'));
    }



    public function index()
    {
        $heads = AccountHead::find([3,4]);

        foreach ($heads as $head) {
            if ( $head->id == 3 )
                foreach ( $head->theads as $income)
                    $data['income'][] = $income->id;
            if ( $head->id == 4)
                foreach ( $head->theads as $expense )
                    $data['expense'][] = $expense->id;
        }

        $all_bl = Process::whereIn('thead_id', collect($data)->flatten())->where( 'date_id', '<=', 8)->get();

        $balance['income'] = $all_bl->where('date_id', 7)->whereIn('thead_id', $data['income']);
        $balance['expense'] = $all_bl->where('date_id', 7)->whereIn('thead_id', $data['expense']);

//        return $balance['income'];

        return view('admin.ais.report.index', compact('all_bl', 'balance', 'data'));
    }


    public function income_data_table()
    {
        $heads = AccountHead::find([3,4]);

        foreach ($heads as $head) {
            if ( $head->id == 3 )
                foreach ( $head->theads as $income)
                    $data['income'][] = $income->id;
            if ( $head->id == 4)
                foreach ( $head->theads as $expense )
                    $data['expense'][] = $expense->id;
        }

        $all_bl = Process::whereIn('thead_id', collect($data)->flatten())->where( 'date_id', '<=', 8)->get();
//        return $all_bl->where('thead_id', 61)->sum();

        return view('admin.ais.report.income', compact('heads', 'all_bl'));
    }


    public function get(Request $request)
    {

        $input = $request->date ? $request->date : date('Y-m-d');
        $date = Date::Where( 'date', $input )->get();

        if ( $date->isEmpty() ){
            $status = 0;
            return view('admin.ais.report.daily', compact('status'));
        }

        $input = $request->date ? $request->date : date('Y-m-d');
        $date = Date::Where( 'date', $input )->get()->first();
        if ( empty($date) )
            $date = Date::create([ 'date' => $input ]);
        return $date->date;
    }


    public function income(Request $request)
    {
//        return $this->test();

        $dates = Date::all();
        $date_id = $request->date_id ? $request->date_id : Date::max('id');

        if ( $dates->isEmpty() ){
            $status = 0;
            return view('admin.ais.report.daily', compact('status'));
        }

        $heads = AccountHead::find([3,4]);
        foreach ($heads as $head) {
            if ( $head->id == 3 )
                foreach ( $head->theads as $income)
                    $data['income'][] = $income->id;
            if ( $head->id == 4)
                foreach ( $head->theads as $expense )
                    $data['expense'][] = $expense->id;
        }

        $all_bl = Process::whereIn('thead_id', collect($data)->flatten())->where( 'date_id', '<=', $date_id)->get();

        return view('admin.ais.report.income', compact('heads', 'all_bl', 'dates', 'date_id'));
    }


    public function test()
    {
        $heads = AccountHead::all();
//        return $heads;

        foreach ($heads as $head) {
            if ($head->transaction->isNotEmpty())
                $data[$head->id][] = $head;
            foreach ( $head->child as $child_i) {
                if ($child_i->transaction->isNotEmpty())
                    $data['child_i'][$child_i->id] = $child_i->id;
                foreach ($child_i->child as $child_ii) {
                    if ($child_ii->transaction->isNotEmpty())
                        $data['child_ii'][$child_ii->id] = $child_ii->transaction->pluck('id');
                    foreach ( $child_ii->child as $child_iii) {
                        if ($child_iii->transaction->isNotEmpty())
                            $data['child_iii'][$child_iii->id] = $child_iii->transaction->pluck('id');
                    }
                }

            }
        }

        return $data;
    }






    public function balance(Request $request)
    {
        $dates = Date::all();
        $date_id = $request->date_id ? $request->date_id : Date::max('id');

        if ( $dates->isEmpty() ){
            $status = 0;
            return view('admin.ais.report.daily', compact('status'));
        }

        $heads = AccountHead::all();

        foreach ($heads as $head) {
            $balance = Process::whereIn('thead_id', $head->theads->pluck('id'))->where( 'date_id', '<=', $date_id)->get();
            $pr_bl[$head->id] = $head->id == 1 || $head->id ==4 ? $balance->sum('debit') - $balance->sum('credit') : $balance->sum('credit') - $balance->sum('debit');
            if ( $head->id == 1 )
                foreach ( $head->theads as $asset)
                    $data['asset'][] = $asset->id;
            if ( $head->id == 2)
                foreach ( $head->theads as $liability )
                    $data['liability'][] = $liability->id;
        }

//        return Process::whereIn('thead_id', $data['liability'])->get()->sum('credit');

        $all_bl = Process::whereIn('thead_id', collect($data)->flatten())->where( 'date_id', '<=', $date_id)->get();

        return view('admin.ais.report.balance', compact('heads', 'all_bl', 'dates', 'date_id', 'pr_bl'));

    }

    public function cash()
    {
        $vouchers = Voucher::where('credit_head_id', 353)->orWhere('debit_head_id', 353)->get();
//        foreach ($data as $item) {
//            if ( $item->credit_head_id == 353 )
//                $voucher['credit'][] = $item;
//            else
//                $voucher['debit'][] = $item;
//         }
//        $debit_vouchers = Voucher::where('credit_head_id', 353)->get();
        return view('admin.ais.report.cash', compact('vouchers'));
    }


    public function ledger($thead_id = null)
    {
//        return $thead_id;
        $data['start_date'] = Date::find(1)->date;
        $data['dates'] = Date::where('id', '>', 1)->get();
        $data['theads'] = TransactionHead::all();
//        return $data['theads']->where('id', $thead_id);
        $data['types'] = VoucherType::all();

        if ( $data['dates']->isEmpty() ){
            $status = 0;
            return view('admin.ais.report.daily', compact('status'));
        }

        if ( $thead_id){
            $thead = $data['theads']->find($thead_id);
            $current_bl = Process::where('thead_id', $thead->id )->get();
            $data['opening_bl'] = $current_bl->where('date_id', 0)->sum('credit') - $current_bl->where('date_id', 0)->sum('debit');
            $data['vouchers'] = Voucher::where('credit_head_id', $thead->id)->orWhere('debit_head_id', $thead->id)->get();
//            return $data['vouchers']->groupBy('date_id');

            foreach ($data['vouchers']->groupBy('date_id') as $key => $items) {
                $balance = $current_bl->where('date_id', '<=', $key-1);
                $credit = 0; $debit =0;

                foreach ($items as $item) {
                    if ( $item->credit_head_id == $thead->id)
                        $credit += $item->amount;
                    if ( $item->debit_head_id == $thead->id)
                        $debit += $item->amount;
                    $y = $balance->sum('debit') + $debit - $balance->sum('credit') - $credit ;
                    $amount[$item->id] = ( $thead->ac_head_id == 1 || $thead->ac_head_id == 4) ? $y  : -$y;
                }
            }
            return view('admin.ais.report.ledger', compact('data', 'amount', 'thead' ));

        }

        return view('admin.ais.report.ledger', compact('data' ));
    }


    public function showLedger(Request $request)
    {
        $input = $request->all();
//        return $input;
        $amount[] = 0;
        $data['dates'] = Date::whereBetween('date', [$input['start_date'], $input['end_date']])->get();

        if ( $data['dates']){
            $current_bl = Process::where('date_id', '<=', $data['dates']->max('id'))->where('thead_id', $input['thead_id'] )->get();
            $data['types'] = VoucherType::all();
            $data['theads'] = TransactionHead::all();
            $thead = $data['theads']->find($request->thead_id);

            $vgroups = VoucherGroup::whereIn('date_id', $data['dates']->pluck('id'))->orderBy('date_id', 'desc')->get();
            if ($request->category == 1)
                $vgroups = $vgroups->where('type_id', '>', 4);
            if ( $request->category == 2)
                $vgroups = $vgroups->where('type_id', '<', 4);
            if ($request->type_id)
                $vgroups = $vgroups->where('type_id', $request->type_id);


//        $vgroups = VoucherGroup::where('type_id', '>',4)->whereIn('date_id', $data['dates']->pluck('id'))->orderBy('id')->get();
//        if ( $request->category == 2)
//            $vgroups = VoucherGroup::where('type_id', '<', 4)->whereIn('date_id', $data['dates']->pluck('id'))->orderBy('id')->get();
//        if ($request->type_id)
//            $vgroups = $vgroups->where('type_id', $request->type_id);

            $data['vouchers'] = Voucher::where('credit_head_id', $request->thead_id)->orWhere('debit_head_id', $request->thead_id)->get()->whereIn('v_group_id', $vgroups->pluck('id'));

            $data['opening_bl'] = $current_bl->where('date_id', 0)->sum('credit') - $current_bl->where('date_id', 0)->sum('debit');
            $data['prev_bl'] = $current_bl->where('date_id', $data['dates']->min('date_id'))->sum('credit') - $current_bl->where('date_id', $data['dates']->min('date_id'))->sum('debit');

            if ( ($thead->ac_head_id == 1 || $thead->ac_head_id == 4)){
                if( $data['opening_bl'])
                    $data['opening_bl'] = - $data['opening_bl'];
                if ( $data['prev_bl'])
                    $data['prev_bl'] = - $data['prev_bl'];
            }


            foreach ($data['vouchers']->groupBy('date_id') as $key => $items) {
                $balance = $current_bl->where('date_id', '<=', $key-1);
//            $z = $balance->sum('debit') - $balance->sum('credit');
//            $data['prev_bl'][$items->first()->id] = ( $thead->ac_head_id == 1 || $thead->ac_head_id == 4) ? $z : -$z;
//            $data['prev_bl'] = ( $thead->ac_head_id == 1 || $thead->ac_head_id == 4) ? $z : -$z;
                $credit = 0; $debit =0;

                foreach ($items as $item) {
                    if ( $item->credit_head_id == $thead->id)
                        $credit += $item->amount;
                    if ( $item->debit_head_id == $thead->id)
                        $debit += $item->amount;
                    $y = $balance->sum('debit') + $debit - $balance->sum('credit') - $credit ;
                    $amount[$item->id] = ( $thead->ac_head_id == 1 || $thead->ac_head_id == 4) ? $y  : -$y;
                }
            }

            return view('admin.ais.report.show_ledger', compact('current_bl', 'data', 'input', 'amount'));

        }

//        return view('admin.ais.report.show_ledger', compact('current_bl', 'data', 'input', 'amount'));

//        return $data;

    }


    public function daily()
    {
        $data['date'] = Date::orderBy('id', 'desc')->where('id', '>', 1)->get();
//        $data['date'] = Date::orderBy('id', 'desc')->get();
        $data['types'] = VoucherType::all(['name', 'id']);
        $theads = TransactionHead::all();

        if ( $data['date']->isEmpty() ){
            $status = 0;
            return view('admin.ais.report.daily', compact('status'));
        }else{
            $i = 0;
            foreach ($data['date'] as $date) {
                foreach ( $date->vGroup as $v_group) {
                    $i ++;
                    foreach ( $v_group->vouchers as $voucher) {
                        $record[$i][$voucher->debit_head_id]['debit'] = $v_group->vouchers->where('debit_head_id', $voucher->debit_head_id)->sum('amount');
                        $record[$i][$voucher->credit_head_id]['credit'] = $v_group->vouchers->where('credit_head_id', $voucher->credit_head_id)->sum('amount');

                        if ( !isset($record[$i][$voucher->debit_head_id]['credit']))
                            $record[$i][$voucher->debit_head_id]['credit'] = 0;
                        if ( !isset($record[$i][$voucher->credit_head_id]['debit']) )
                            $record[$i][$voucher->credit_head_id]['debit'] = 0;

//                    $dr_ac_bl = $record[$i][$voucher->debit_head_id]['debit'] - $record[$i][$voucher->debit_head_id]['credit'];
//                    $cr_ac_bl = $record[$i][$voucher->credit_head_id]['debit'] - $record[$i][$voucher->credit_head_id]['credit'];

//                    $record[$i][$voucher->debit_head_id]['amount'] = ($voucher->debitAccount->ac_head_id == 1) || ($voucher->debitAccount->ac_head_id == 4) ? $dr_ac_bl : -$dr_ac_bl;
//                    $record[$i][$voucher->credit_head_id]['amount'] = ($voucher->creditAccount->ac_head_id == 1) || ($voucher->creditAccount->ac_head_id == 4) ? $cr_ac_bl : -$cr_ac_bl;

                        $record[$i][$voucher->debit_head_id]['thead'] = $voucher->debitAccount->name;
                        $record[$i][$voucher->credit_head_id]['thead'] = $voucher->creditAccount->name;
                        $info[$i]['note'] = $v_group->note;
                        $info[$i]['code'] = $v_group->code;
                        $info[$i]['date'] = $v_group->date->date;
                        $info[$i]['type'] = $v_group->type->name;
//                    return $record;
                    }
                }
            }


            return view('admin.ais.report.daily', compact('data', 'record', 'info'));
        }

    }


    public function showDaily(Request $request)
    {
//        return $request->all();
        $input = $request->all();

        $data['date'] = Date::whereBetween('date', [ $input['start_date'], $input['end_date'] ])->orderBy('id', 'desc')->get();
        $data['types'] = VoucherType::all(['name', 'id']);
        $theads = TransactionHead::all();

        if ( $data['date']->isEmpty() ){
            $status = 0;
            return view('admin.ais.report.daily', compact('status'));
        }

        $i = 0;
        foreach ($data['date'] as $date) {

//            $vgroups = VoucherGroup::whereIn('date_id', $data['dates']->pluck('id'))->orderBy('date_id', 'desc')->get();
            $vgroups = $date->vGroup;

            if ($request->category == 1)
                $vgroups = $vgroups->where('type_id', '>', 4);
            if ( $request->category == 2)
                $vgroups = $vgroups->where('type_id', '<', 4);
            if ($request->type_id)
                $vgroups = $vgroups->where('type_id', $request->type_id);

//            return $date->vGroup;
            foreach ( $vgroups as $v_group) {
                $i ++;
                foreach ( $v_group->vouchers as $voucher) {
                    $record[$i][$voucher->debit_head_id]['debit'] = $v_group->vouchers->where('debit_head_id', $voucher->debit_head_id)->sum('amount');
                    $record[$i][$voucher->credit_head_id]['credit'] = $v_group->vouchers->where('credit_head_id', $voucher->credit_head_id)->sum('amount');

                    if ( !isset($record[$i][$voucher->debit_head_id]['credit']))
                        $record[$i][$voucher->debit_head_id]['credit'] = 0;
                    if ( !isset($record[$i][$voucher->credit_head_id]['debit']) )
                        $record[$i][$voucher->credit_head_id]['debit'] = 0;

//                    $dr_ac_bl = $record[$i][$voucher->debit_head_id]['debit'] - $record[$i][$voucher->debit_head_id]['credit'];
//                    $cr_ac_bl = $record[$i][$voucher->credit_head_id]['debit'] - $record[$i][$voucher->credit_head_id]['credit'];

//                    $record[$i][$voucher->debit_head_id]['amount'] = ($voucher->debitAccount->ac_head_id == 1) || ($voucher->debitAccount->ac_head_id == 4) ? $dr_ac_bl : -$dr_ac_bl;
//                    $record[$i][$voucher->credit_head_id]['amount'] = ($voucher->creditAccount->ac_head_id == 1) || ($voucher->creditAccount->ac_head_id == 4) ? $cr_ac_bl : -$cr_ac_bl;

                    $record[$i][$voucher->debit_head_id]['thead'] = $voucher->debitAccount->name;
                    $record[$i][$voucher->credit_head_id]['thead'] = $voucher->creditAccount->name;
                    $info[$i]['note'] = $v_group->note;
                    $info[$i]['code'] = $v_group->code;
                    $info[$i]['date'] = $v_group->date->date;
                    $info[$i]['type'] = $v_group->type->name;

//                    return $record;


                }
            }
        }



        return view('admin.ais.report.daily', compact('data', 'record', 'info', 'input'));

    }
















}
