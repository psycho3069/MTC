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


    public function repay()
    {
        $heads = AccountHead::all();
        $data = [];

        $theads = TransactionHead::all();

        foreach ( $theads as $thead) {
            $cr_bl[$thead->id]['debit'] = $thead->currentBalance->sum('debit');
            $cr_bl[$thead->id]['credit'] = $thead->currentBalance->sum('credit');
        }

        foreach ($heads as $head) {

            foreach ($head->child as $child_i) {
                $prefix = 'head_i';
                $data[] = $this->repayCal($prefix, $child_i, $cr_bl);

                foreach ( $child_i->child as $child_ii) {
                    $prefix = 'head_ii';
                    $data[] = $this->repayCal($prefix, $child_ii, $cr_bl);

                    foreach ($child_ii->child as $child_iii) {
                        $prefix = 'head_iii';
                        $data[] = $this->repayCal($prefix, $child_iii, $cr_bl);
                    }
                }
            }

//            foreach ($head->child as $child) {
//                $data['head_i'][$child->id]['debit'] = 0;
//                $data['head_i'][$child->id]['credit'] = 0;
//                $data['head_i'][$child->id]['no'] = count( $child->transaction);
//
//                foreach ( $child->transaction as $thead) {
//                    $data['head_i'][$child->id]['debit'] += $cr_bl[$thead->id]['debit'];
//                    $data['head_i'][$child->id]['credit'] += $cr_bl[$thead->id]['credit'];
//                }
//                $total = $data['head_i'][$child->id]['debit'] - $data['head_i'][$child->id]['credit'];
//                $data['head_i'][$child->id]['total'] = $child->ac_head_id == 1 || $child->ac_head_id == 4 ? round($total, 2) : round(-$total, 2);
//
//            }

        }

        foreach ($data as $key => $types) {
            foreach ($types as $key => $head) {
                foreach ($head as $id => $value) {
                    $local[$key][$id] = $value;
                }
            }
        }

//        return $local;

        return view('admin.ais.report.receipt', compact('heads', 'local'));
    }


    public function repayCal( $prefix, $child, $cr_bl)
    {
        $data[$prefix][$child->id]['debit'] = 0;
        $data[$prefix][$child->id]['credit'] = 0;
        $data[$prefix][$child->id]['no'] = count( $child->transaction);

        foreach ( $child->transaction as $thead) {
            $data[$prefix][$child->id]['debit'] += $cr_bl[$thead->id]['debit'];
            $data[$prefix][$child->id]['credit'] += $cr_bl[$thead->id]['credit'];
        }
        $total = $data[$prefix][$child->id]['debit'] - $data[$prefix][$child->id]['credit'];
        $data[$prefix][$child->id]['total'] = $child->ac_head_id == 1 || $child->ac_head_id == 4 ? round($total, 2) : round(-$total, 2);

        return $data;
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

    public function getReport( $category, $dates)
    {
        if ( !count( $dates))
            return 220;

        $op_date = $dates->first()->id == 1 ? 1 : $dates->first()->id;

        foreach ( $category->ledger as $ledger) {

            $data['stock'][$ledger->id]['purchase'] = 0;
            $data['stock'][$ledger->id]['delivery'] = 0;
            $data['stock'][$ledger->id]['cost'] = 0;

            $data['stock'][$ledger->id]['name'] = $ledger->name;
            $data['stock'][$ledger->id]['category'] = $ledger->ledgerable->name;
            $data['stock'][$ledger->id]['unit'] = $ledger->unitType->name;

            $cr_stock = $ledger->currentStock->where('date_id', '<', $op_date);
            $purchases = $ledger->purchases->whereIn('date_id', $dates->pluck('id'));
            $deliveries = $ledger->deliveries->whereIn('date_id', $dates->pluck('id'));

            $data['stock'][$ledger->id]['op_bl'] = $cr_stock->sum('quantity_dr') - $cr_stock->sum('quantity_cr');

            foreach ( $purchases as $purchase) {
                $data['stock'][$ledger->id]['purchase'] += $purchase->currentStock->quantity_dr;
                $data['stock'][$ledger->id]['cost'] += $purchase->amount;
            }

            foreach ( $deliveries as $delivery) {
                $data['stock'][$ledger->id]['delivery'] += $delivery->currentStock->quantity_cr;
            }

            $data['stock'][$ledger->id]['cl_bl'] = $data['stock'][$ledger->id]['op_bl'] + $data['stock'][$ledger->id]['purchase'] - $data['stock'][$ledger->id]['delivery'];
        }

        return $data;
    }
}
