<?php

namespace App\Http\Controllers;

use App\AccountHead;
use App\AccountHeadChild_II;
use App\Date;
use App\MISHead;
use App\MISHeadChild_I;
use App\MISLedgerHead;
use App\Process;
use App\PurchaseGroup;
use App\TransactionHead;
use App\Voucher;
use App\VoucherGroup;
use App\VoucherType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{


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
//        return Date::first()->date;
        $dates = Date::all();
        $date = $request->date;
        if ($date <= Date::first()->date){
            $date_id = Date::min('id');
        } else{
            $date_id = Date::where('date',$date)->get()->first() ? Date::where('date',$date)->get()->first()->id : Date::max('id');
        }


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

        $year = explode("-",Date::find($date_id) ? Date::find($date_id)->date : Date::get()->last()->date)[0];
        $start_date = $year.'-'.explode("-",Date::find($date_id) ? Date::find($date_id)->date : Date::get()->last()->date)[1].'-01';
        $start_year = $year.'-01-01';
        $date_id_min = Date::min('id');

        $all_bl = Process::whereIn('thead_id', collect($data)->flatten())->whereBetween('date_id', [ Date::where('date',$start_date)->first() ? Date::where('date',$start_date)->first()->id : Date::find($date_id_min)->id , Date::find($date_id)->id])->get();
        $all_bl_year = Process::whereIn('thead_id', collect($data)->flatten())->whereBetween('date_id', [Date::where('date',$start_year)->first() ? Date::where('date',$start_year)->first()->id : Date::find($date_id_min)->id, Date::find($date_id)->id])->get();

        return view('admin.ais.report.income', compact('heads', 'all_bl','all_bl_year', 'dates', 'date'));

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
        $data['dates'] = Date::get();
        $data['theads'] = TransactionHead::all();
        $data['types'] = VoucherType::all()->except([ 5, 6, 7, 8, 9]);

        if ( count($data['dates']) == 0  ){
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
            $data['types'] = VoucherType::all()->except([5,6,7,8,9]);
            $data['theads'] = TransactionHead::all();
            $thead = $data['theads']->find($request->thead_id);

            $vgroups = VoucherGroup::whereIn('date_id', $data['dates']->pluck('id'))->orderBy('date_id', 'desc')->get();
            if ($request->category == 1)
                $vgroups = $vgroups->where('type_id', '>', 4);
            if ( $request->category == 2)
                $vgroups = $vgroups->where('type_id', '<', 5);
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

    public function cashBook(Request $request)
    {
        $input = $request->all();

        $data['start_date'] = Date::find(1)->date;
        $data['end_date'] = Date::all()->last()->date;
        $data['category'] = $request->category;
        $data['type'] = $request->type_id;

        if ($request->start_date && $request->end_date){
            $data['dates'] = Date::whereBetween('date', [$input['start_date'], $input['end_date']])->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
        } else if(!$request->start_date && $request->end_date){
            $data['dates'] = Date::whereBetween('date', [$data['start_date'], $input['end_date']])->get();
            $data['end_date'] = $request->end_date;
        } else if($request->start_date && !$request->end_date){
            $data['dates'] = Date::whereBetween('date', [$data['start_date'], $data['end_date']])->get();
            $data['start_date'] = $request->start_date;
        } else {
            $data['dates'] = Date::get();
        }

        $data['theads'] = TransactionHead::all();
        $data['types'] = VoucherType::all()->except([ 5, 6, 7, 8, 9]);
        $thead = $data['theads']->find(353);
        $current_bl = Process::where('date_id', '<=', $data['dates']->max('id'))->where('thead_id', $thead->id )->get();

        $vgroups = VoucherGroup::whereIn('date_id', $data['dates']->pluck('id'))->orderBy('date_id', 'desc')->get();
        if ($request->category == 1)
            $vgroups = $vgroups->where('type_id', '>', 4);
        if ( $request->category == 2)
            $vgroups = $vgroups->where('type_id', '<', 5);
        if ($request->type_id)
            $vgroups = $vgroups->where('type_id', $request->type_id);

        $data['opening_credit'] = $current_bl->where('date_id', 0)->sum('credit');
        $data['opening_debit'] = $current_bl->where('date_id', 0)->sum('debit');
        $data['opening_bl'] = $current_bl->where('date_id', 0)->sum('credit') - $current_bl->where('date_id', 0)->sum('debit');

        $data['prev_credit'] = $current_bl->where('date_id','<=', $data['dates']->min('id')-1)->sum('credit');
        $data['prev_debit'] = $current_bl->where('date_id','<=', $data['dates']->min('id')-1)->sum('debit');
        $data['prev_bl'] = $current_bl->where('date_id','<=', $data['dates']->min('id')-1)->sum('debit') - $current_bl->where('date_id','<=', $data['dates']->min('id')-1)->sum('credit');

        if ( ($thead->ac_head_id == 1 || $thead->ac_head_id == 4)){
            if( $data['opening_bl'])
                $data['opening_bl'] = - $data['opening_bl'];
//            if ( $data['prev_bl'])
//                $data['prev_bl'] = - $data['prev_bl'];
        }

        $data['vouchers'] = Voucher::where('credit_head_id', $thead->id)->orWhere('debit_head_id', $thead->id)->get()->whereIn('v_group_id', $vgroups->pluck('id'));

        $amount=[];
        foreach ($data['vouchers']->groupBy('date_id') as $key => $items) {
//            return $items;
            $balance = $current_bl->where('date_id', '<=', $key-1);
            $credit = 0; $debit = 0;

            foreach ($items as $item) {

                if ( $item->credit_head_id == $thead->id)
                    $credit += $item->amount;
                if ( $item->debit_head_id == $thead->id)
                    $debit += $item->amount;
                $y = $balance->sum('debit') + $debit - $balance->sum('credit') - $credit ;
                $amount[$item->id] = ( $thead->ac_head_id == 1 || $thead->ac_head_id == 4) ? $y : -$y;
            }
        }
        return view('admin.ais.report.cash-book', compact('data', 'amount', 'thead' ));

    }

    public function bankBook(Request $request)
    {
        $input = $request->all();

        $data['start_date'] = Date::find(1)->date;
        $data['end_date'] = Date::all()->last()->date;
        $data['category'] = $request->category;
        $data['type'] = $request->type_id;

        if ($request->start_date && $request->end_date){
            $data['dates'] = Date::whereBetween('date', [$input['start_date'], $input['end_date']])->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
        } else if(!$request->start_date && $request->end_date){
            $data['dates'] = Date::whereBetween('date', [$data['start_date'], $input['end_date']])->get();
            $data['end_date'] = $request->end_date;
        } else if($request->start_date && !$request->end_date){
            $data['dates'] = Date::whereBetween('date', [$data['start_date'], $data['end_date']])->get();
            $data['start_date'] = $request->start_date;
        } else {
            $data['dates'] = Date::get();
        }
        $data['theads'] = TransactionHead::where('transactionable_id',2)
                                            ->where('ac_head_id',1)
                                            ->where('transactionable_type','App\AccountHeadChild_III')
                                            ->get();
        $data['types'] = VoucherType::all()->except([ 5, 6, 7, 8, 9]);

        $request->thead_id ? $thead = $data['theads']->find($request->thead_id) : $thead = '';

        if ($thead){
            $current_bl = Process::where('date_id', '<=', $data['dates']->max('id'))->where('thead_id', $thead->id )->get();

            $vgroups = VoucherGroup::whereIn('date_id', $data['dates']->pluck('id'))->orderBy('date_id', 'desc')->get();
            if ($request->category == 1)
                $vgroups = $vgroups->where('type_id', '>', 4);
            if ( $request->category == 2)
                $vgroups = $vgroups->where('type_id', '<', 5);
            if ($request->type_id)
                $vgroups = $vgroups->where('type_id', $request->type_id);

            $data['opening_credit'] = $current_bl->where('date_id', 0)->sum('credit');
            $data['opening_debit'] = $current_bl->where('date_id', 0)->sum('debit');
            $data['opening_bl'] = $current_bl->where('date_id', 0)->sum('credit') - $current_bl->where('date_id', 0)->sum('debit');

            $data['prev_credit'] = $current_bl->where('date_id','<=', $data['dates']->min('id')-1)->sum('credit');
            $data['prev_debit'] = $current_bl->where('date_id','<=', $data['dates']->min('id')-1)->sum('debit');
            $data['prev_bl'] = $current_bl->where('date_id','<=', $data['dates']->min('id')-1)->sum('debit') - $current_bl->where('date_id','<=', $data['dates']->min('id')-1)->sum('credit');

            if ( ($thead->ac_head_id == 1 || $thead->ac_head_id == 4)){
                if( $data['opening_bl'])
                    $data['opening_bl'] = - $data['opening_bl'];
//                if ( $data['prev_bl'])
//                    $data['prev_bl'] = - $data['prev_bl'];
            }

            $data['vouchers'] = Voucher::where('credit_head_id', $thead->id)->orWhere('debit_head_id', $thead->id)->get()->whereIn('v_group_id', $vgroups->pluck('id'));

            $amount=[];
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
            return view('admin.ais.report.bank-book', compact('data', 'amount', 'thead' ));
        } else {
            return view('admin.ais.report.bank-book', compact('data' ));
        }

    }

    public function cashBankBook(Request $request)
    {
        $input = $request->all();

        $data['start_date'] = Date::find(1)->date;
        $data['end_date'] = Date::all()->last()->date;
        $data['category'] = $request->category;
        $data['type'] = $request->type_id;

        if ($request->start_date && $request->end_date){
            $data['dates'] = Date::whereBetween('date', [$input['start_date'], $input['end_date']])->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
        } else if(!$request->start_date && $request->end_date){
            $data['dates'] = Date::whereBetween('date', [$data['start_date'], $input['end_date']])->get();
            $data['end_date'] = $request->end_date;
        } else if($request->start_date && !$request->end_date){
            $data['dates'] = Date::whereBetween('date', [$data['start_date'], $data['end_date']])->get();
            $data['start_date'] = $request->start_date;
        } else {
            $data['dates'] = Date::get();
        }
        $data['types'] = VoucherType::all()->except([ 5, 6, 7, 8, 9]);

        $theads = TransactionHead::whereBetween('transactionable_id',[1,2])
                                ->where('ac_head_id',1)
                                ->where('transactionable_type','App\AccountHeadChild_III')
                                ->get();

        $data['prev_credit_cash']=0;
        $data['prev_debit_cash']=0;
        $data['prev_bl_cash']=0;
        $data['opening_credit_cash']=0;
        $data['opening_debit_cash']=0;
        $data['opening_bl_cash']=0;

        $data['prev_credit_bank']=0;
        $data['prev_debit_bank']=0;
        $data['prev_bl_bank']=0;
        $data['opening_credit_bank']=0;
        $data['opening_debit_bank']=0;
        $data['opening_bl_bank']=0;

        $y=0; $amount=[]; $total_balance = 0;
        $data['vouchers'][] = array();

        $i = 0;
        foreach ($theads as $thead){
            $thead_size = count($theads);
            $current_bl = Process::where('date_id', '<=', $data['dates']->max('id'))->where('thead_id', $thead->id )->get();
            $current_balance = Process::where('date_id','<=', $data['dates']->min('id')-1)->where('thead_id', $thead->id )->get();

            $vgroups = VoucherGroup::whereIn('date_id', $data['dates']->pluck('id'))->orderBy('date_id', 'desc')->get();
            if ($request->category == 1)
                $vgroups = $vgroups->where('type_id', '>', 4);
            if ( $request->category == 2)
                $vgroups = $vgroups->where('type_id', '<', 5);
            if ($request->type_id)
                $vgroups = $vgroups->where('type_id', $request->type_id);

            foreach ($current_balance as $item){
                if ($item->thead->transactionable_id == 1){
                    $data['prev_credit_cash'] += $item->credit;
                    $data['prev_debit_cash'] += $item->debit;
                    $data['prev_bl_cash'] += $item->debit - $item->credit;

                    $data['opening_credit_cash'] += $current_bl->where('date_id', 0)->sum('credit');
                    $data['opening_debit_cash'] += $current_bl->where('date_id', 0)->sum('debit');
                    $data['opening_bl_cash'] += $current_bl->where('date_id', 0)->sum('credit') - $current_bl->where('date_id', 0)->sum('debit');
                } else {
                    $data['prev_credit_bank'] += $item->credit;
                    $data['prev_debit_bank'] += $item->debit;
                    $data['prev_bl_bank'] += $item->debit - $item->credit;

                    $data['opening_credit_bank'] += $current_bl->where('date_id', 0)->sum('credit');
                    $data['opening_debit_bank'] += $current_bl->where('date_id', 0)->sum('debit');
                    $data['opening_bl_bank'] += $current_bl->where('date_id', 0)->sum('credit') - $current_bl->where('date_id', 0)->sum('debit');
                }
            }

//            if ( ($thead->ac_head_id == 1 || $thead->ac_head_id == 4)){
//                if( $data['opening_bl'])
//                    $data['opening_bl'] = - $data['opening_bl'];
//                if ( $data['prev_bl'])
//                    $data['prev_bl'] = - $data['prev_bl'];
//            }

            $data['vouchers'][$i] = Voucher::where('credit_head_id', $thead->id)->orWhere('debit_head_id', $thead->id)->get()->whereIn('v_group_id', $vgroups->pluck('id'));

            $j = 0;
            foreach ($data['vouchers'][$i]->groupBy('date_id') as $key => $items) {

                $data_voucher_size = count($data['vouchers'][$i]);
                $balance = $current_bl->where('date_id', '<=', $key-1);
                $credit = 0; $debit = 0;
                $k = 0;
                foreach ($items as $item) {
                    $item_size = count($items);
                    if ( $item->credit_head_id == $thead->id){
                        $credit += $item->amount;
                    }
                    if ( $item->debit_head_id == $thead->id){
                        $debit += $item->amount;
                    }

                    $y = $balance->sum('debit') + $debit - $balance->sum('credit') - $credit + $total_balance;
                    $amount[$item->id] = ( $thead->ac_head_id == 1 || $thead->ac_head_id == 4) ? $y  : -$y;

                    if ($k == $data_voucher_size-1){
                        $total_balance = $amount[$item->id];
                    }
                    $k++;
                }
                $j++;
            }
            $i++;
        }
        return view('admin.ais.report.cash-bank-book', compact('data', 'amount', 'theads' ));
    }

    public function daily()
    {
        $data['date'] = Date::orderBy('id', 'desc')->get();
        $data['types'] = VoucherType::all(['name', 'id'])->except([5,6,7,8,9]);
        $theads = TransactionHead::all();

        if ( count($data['date']) == 0 ){
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
        $data['types'] = VoucherType::all(['name', 'id'])->except([5,6,7,8,9]);
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
                $vgroups = $vgroups->where('type_id', '<', 5);
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


    public function showStock(Request $request)
    {
//        return $request->all();
        $mis_head = MISHead::find( $request->mis_head_id);
        $from = date( 'Y-m-d', strtotime( $request->from));
        $to = date( 'Y-m-d', strtotime( $request->to));
        $dates = Date::orderBy('id', 'asc')->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->get();


        if ( $request->kate_id == 'all')
            return $data = $this->getAllStock($mis_head, $dates);
        $category = MISHeadChild_I::find( $request->kate_id);
        $data = $this->getReport( $category, $dates);

        return $data;
    }

    public function stock( $mis_head_id)
    {
        $id = $mis_head_id != 4 ? 5 : 4;
        $mis_head = MISHead::find( $id);
        $dates = Date::orderBy('id', 'asc')->get();

        $data = $this->getAllStock($mis_head, $dates);

        return view('admin.mis.report.stock', compact('mis_head', 'data'));
    }

    public function getAllStock( $mis_head, $dates)
    {
        $results = [];
        foreach ($mis_head->child as $kate) {
            if ( $kate->ledger->isNotEmpty())
                $results[] = $this->getReport( $kate, $dates);
        }

        foreach ( $results as $item) {
            foreach ( $item['stock'] as $key => $stock) {
                $data['stock'][$key] = $stock;
            }
        }

        return $data;
    }


    public function fixThead()
    {
        $theads = TransactionHead::all();
        foreach ($theads as $thead) {
            if ($thead->transactionable->ac_head_child_ii_id )
                $ac_head_id = $thead->transactionable->parent->parent->parent->id;
            if ($thead->transactionable->ac_head_child_i_id )
                $ac_head_id = $thead->transactionable->parent->parent->id;
            if ($thead->transactionable->ac_head_id )
                $ac_head_id = $thead->transactionable->parent->id;

            $thead->update([ 'ac_head_id' => $ac_head_id]);
        }

        return 200;
    }

    public function receiptPayment(Request $request)
    {
        $this->fixThead();

        $date = $request->date ?: date('Y-m-d');

        $theads = TransactionHead::get();
        $ac_cash = $theads->firstWhere('code', 1751);
        $vouchers = Voucher::get();

        $dates['monthly'] = Date::get()->filter( function ($item) use ($date){
            return $item->date <= $date and Carbon::parse($item->date)->format('Y-m') == Carbon::parse($date)->format('Y-m');
        })->map(function ($item){
            return $item->id;
        });

        $dates['yearly'] = Date::whereDate('date', '<=', $date)->get()->map(function ($item) use ($date){
            $given_date = Carbon::parse($date);
            $present_date = Carbon::parse($item->date);

            if ($given_date->month >= 1 && $given_date->month < 7){
                if ($present_date->month >= 1 && $present_date->month < 7 && $present_date->year == $given_date->year)
                    return $item->id;
                if ($present_date->month >= 7 && $present_date->month <= 12 && $present_date->year == $given_date->year - 1)
                    return $item->id;
            }

            if ($given_date->month >= 7 && $given_date->month <= 12){
                if ($present_date->month >= 7 && $present_date->month <= 12 && $present_date->year == $given_date->year)
                    return $item->id;
                if ($present_date->month >= 1 && $present_date->month < 7 && $present_date->year == $given_date->year + 1)   //Not necessary
                    return $item->id;
            }

            return false;

        })->reject(function ($item){
            return !$item;
        });

        $balance['receipt'] = $vouchers->where('debit_head_id', $ac_cash->id)->groupBy('credit_head_id')
            ->filter(function ($item) use ($dates){
                return $item->whereIn('date_id', $dates['monthly'])->count();
            })
            ->map(function ($item) use ($dates){
                $cr_bl = $item[0]->creditAccount->currentBalance[0]->amount;
                $amount['monthly'] = $item->whereIn('date_id', $dates['monthly'])->sum('amount') + $cr_bl;
                $amount['yearly'] = $item->whereIn('date_id', $dates['yearly'])->sum('amount') + $cr_bl;
                return $amount;
            });

        $balance['payment'] = $vouchers->where('credit_head_id', $ac_cash->id)->groupBy('debit_head_id')
            ->filter(function ($item) use ($dates){
                return $item->whereIn('date_id', $dates['monthly'])->count();
            })
            ->map(function ($item) use ($dates){
                $cr_bl = $item[0]->debitAccount->currentBalance[0]->amount;
                $amount['monthly'] = $item->whereIn('date_id', $dates['monthly'])->sum('amount') + $cr_bl;
                $amount['yearly'] = $item->whereIn('date_id', $dates['yearly'])->sum('amount') + $cr_bl;
                return $amount;
            });

        $keys = $balance['receipt']->keys()->merge($balance['payment']->keys());
        $theads = $theads->only( $keys->toArray());

//        $a = ['name' => 'peter', 2 => ['name' => 255]];
//        $b = ['total' => ['r' => 20]];
//        $a['total'] = array_replace($a[2], ['r' => 20]);
//        $a['total'] = array_replace($a[2], ['r' => 25, 'f' => 35]);

        $i = 0;



        $data['receipt'] = [];
        $data['payment'] = [];

        foreach ( $theads as $thead) {
            $result = [];
            if ( $balance['receipt']->has($thead->id))
                $result[0] = 'receipt';

            if ( $balance['payment']->has($thead->id))
                $result[1] = 'payment';

            foreach ($result as $index) {
                $outcome = $this->generateReceiptPaymentReport($index, $data[$index], $thead, $balance[$index]);
                $data[$index] = array_replace($data[$index], $outcome);
            }

        }


        asort($data['receipt']);
        asort($data['payment']);

//        foreach ($data['payment'] as $key => $item_i) {
//            return $key;
//            return collect($item_i)->except('name', 'receipt');
//            foreach (collect($item_i)->except('receipt', 'name') as $item_ii) {
//                return $item_i;
//            }
//        }


        $input['date'] = $date;

        return view('admin.ais.report.receipt_payment', compact('data', 'input'));

    }

    public function generateReceiptPaymentReport($index, $data, $thead, $balance)
    {

        $thead_info[$index] = $balance[$thead->id] ?? false;
        $thead_info['name'] = $thead->name;

        $data[$thead->ac_head_id]['name'] = $thead->accountHead->name;

        $x = $this->getTotal( $data[$thead->ac_head_id], $index, $balance[$thead->id]);
        $data[$thead->ac_head_id] = array_replace($data[$thead->ac_head_id], $x);

        if ($thead->transactionable->ac_head_id){
            $data[$thead->ac_head_id][$thead->transactionable_id]['name'] = $thead->transactionable->name;
            $data[$thead->ac_head_id][$thead->transactionable_id][$thead->id] = $thead_info;

            $x = $this->getTotal( $data[$thead->ac_head_id][$thead->transactionable_id], $index, $balance[$thead->id]);
            $data[$thead->ac_head_id][$thead->transactionable_id] = array_replace( $data[$thead->ac_head_id][$thead->transactionable_id], $x);
        }
        if ( $thead->transactionable->ac_head_child_i_id){
            $data[$thead->ac_head_id][$thead->transactionable->parent->id]['name'] = $thead->transactionable->parent->name;
            $data[$thead->ac_head_id][$thead->transactionable->parent->id][$thead->transactionable_id]['name'] = $thead->transactionable->name;
            $data[$thead->ac_head_id][$thead->transactionable->parent->id][$thead->transactionable_id][$thead->id] = $thead_info;

            $x = $this->getTotal( $data[$thead->ac_head_id][$thead->transactionable->parent->id][$thead->transactionable_id], $index, $balance[$thead->id]);
            $data[$thead->ac_head_id][$thead->transactionable->parent->id][$thead->transactionable_id] = array_replace( $data[$thead->ac_head_id][$thead->transactionable->parent->id][$thead->transactionable_id], $x);

            $x = $this->getTotal( $data[$thead->ac_head_id][$thead->transactionable->parent->id], $index, $balance[$thead->id]);
            $data[$thead->ac_head_id][$thead->transactionable->parent->id] = array_replace( $data[$thead->ac_head_id][$thead->transactionable->parent->id], $x);
        }

        if ( $thead->transactionable->ac_head_child_ii_id){
            $data[$thead->ac_head_id][$thead->transactionable->parent->parent->id]['name'] = $thead->transactionable->parent->parent->name;
            $data[$thead->ac_head_id][$thead->transactionable->parent->parent->id][$thead->transactionable->parent->id]['name'] = $thead->transactionable->parent->name;
            $data[$thead->ac_head_id][$thead->transactionable->parent->parent->id][$thead->transactionable->parent->id][$thead->transactionable_id]['name'] = $thead->transactionable->name;
            $data[$thead->ac_head_id][$thead->transactionable->parent->parent->id][$thead->transactionable->parent->id][$thead->transactionable_id][$thead->id] = $thead_info;

            $x = $this->getTotal( $data[$thead->ac_head_id][$thead->transactionable->parent->parent->id][$thead->transactionable->parent->id][$thead->transactionable_id], $index, $balance[$thead->id]);
            $data[$thead->ac_head_id][$thead->transactionable->parent->parent->id][$thead->transactionable->parent->id][$thead->transactionable_id] = array_replace( $data[$thead->ac_head_id][$thead->transactionable->parent->parent->id][$thead->transactionable->parent->id][$thead->transactionable_id], $x);

            $x = $this->getTotal( $data[$thead->ac_head_id][$thead->transactionable->parent->parent->id][$thead->transactionable->parent->id], $index, $balance[$thead->id]);
            $data[$thead->ac_head_id][$thead->transactionable->parent->parent->id][$thead->transactionable->parent->id] = array_replace( $data[$thead->ac_head_id][$thead->transactionable->parent->parent->id][$thead->transactionable->parent->id], $x);

            $x = $this->getTotal( $data[$thead->ac_head_id][$thead->transactionable->parent->parent->id], $index, $balance[$thead->id]);
            $data[$thead->ac_head_id][$thead->transactionable->parent->parent->id] = array_replace( $data[$thead->ac_head_id][$thead->transactionable->parent->parent->id], $x);
        }

        return $data;
    }

    public function getTotal($prev_bl, $index, $balance)
    {
        $data[$index]['monthly'] = !isset($prev_bl[$index]['monthly']) ? $balance['monthly'] : $prev_bl[$index]['monthly'] + $balance['monthly'];
        $data[$index]['yearly'] = !isset($prev_bl[$index]['yearly']) ? $balance['yearly'] : $prev_bl[$index]['yearly'] + $balance['yearly'];
        return $data;

    }



}
