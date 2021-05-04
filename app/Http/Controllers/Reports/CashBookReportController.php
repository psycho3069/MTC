<?php

namespace App\Http\Controllers\Reports;

use App\Date;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\Process;
use App\TransactionHead;
use App\Voucher;
use App\VoucherGroup;
use App\VoucherType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashBookReportController extends Controller
{
    use SoftwareConfigurationTrait;


    public function cashBook(Request $request)
    {
        $input = $request->all();
        $softwareStartDate = $this->getSoftwareStartDate();

        $data['start_date'] = Date::value('date');
        $data['end_date'] = Date::orderby('id', 'desc')->value('date');
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
        $data['types'] = $this->getVoucherTypes();
        $thead = $data['theads']->find(353);
        $current_bl = Process::where('date_id', '<=', $data['dates']->max('id'))
            ->where('thead_id', $thead->id )
            ->get();

        $vgroups = VoucherGroup::whereIn('date_id', $data['dates']->pluck('id'))
            ->orderBy('date_id', 'desc')
            ->get();

        if ($request->category == 1)
            $vgroups = $vgroups->where('type_id', '>', 4);
        if ( $request->category == 2)
            $vgroups = $vgroups->where('type_id', '<', 5);
        if ($request->type_id)
            $vgroups = $vgroups->where('type_id', $request->type_id);

        $data['opening_credit'] = $current_bl->where('date_id', $softwareStartDate->id)->sum('credit');
        $data['opening_debit'] = $current_bl->where('date_id', $softwareStartDate->id)->sum('debit');

        $data['prev_credit'] = $current_bl->where('date_id','<=', $data['dates']
                ->min('id'))->sum('credit');
        $data['prev_debit'] = $current_bl->where('date_id','<=', $data['dates']
                ->min('id'))->sum('debit');

        $data['opening_bl'] = $data['opening_credit'] - $data['opening_debit'];
        $data['prev_bl'] = $data['prev_debit'] - $data['prev_credit'];

        if ( ($thead->ac_head_id == 1 || $thead->ac_head_id == 4)){
            $data['opening_bl'] = -1 * $data['opening_bl'];
        }

        $data['vouchers'] = Voucher::where('credit_head_id', $thead->id)
            ->orWhere('debit_head_id', $thead->id)
            ->get()
            ->whereIn('v_group_id', $vgroups->pluck('id'));

        $amount=[];
        foreach ($data['vouchers']->groupBy('date_id') as $key => $items) {
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
        $softwareStartDate = $this->getSoftwareStartDate();

        $data['start_date'] = Date::value('date');
        $data['end_date'] = Date::orderby('id', 'desc')->value('date');
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

        $data['types'] = $this->getVoucherTypes();

        $thead = $request->thead_id ? $data['theads']->find($request->thead_id) : null;

        if ($thead){
            $current_bl = Process::where('date_id', '<=', $data['dates']
                ->max('id'))->where('thead_id', $thead->id )->get();

            $vgroups = VoucherGroup::whereIn('date_id', $data['dates']->pluck('id'))
                ->orderBy('date_id', 'desc')->get();
            if ($request->category == 1)
                $vgroups = $vgroups->where('type_id', '>', 4);
            if ( $request->category == 2)
                $vgroups = $vgroups->where('type_id', '<', 5);
            if ($request->type_id)
                $vgroups = $vgroups->where('type_id', $request->type_id);

            $data['opening_credit'] = $current_bl->where('date_id', $softwareStartDate->id)->sum('credit');
            $data['opening_debit'] = $current_bl->where('date_id', $softwareStartDate->id)->sum('debit');

            $data['prev_credit'] = $current_bl->where('date_id','<=', $data['dates']
                    ->min('id'))->sum('credit');
            $data['prev_debit'] = $current_bl->where('date_id','<=', $data['dates']
                    ->min('id'))->sum('debit');


            $data['opening_bl'] = $data['opening_credit'] - $data['opening_debit'];
            $data['prev_bl'] = $data['prev_debit'] - $data['prev_credit'];

            if ( ($thead->ac_head_id == 1 || $thead->ac_head_id == 4)){
                    $data['opening_bl'] = -1 * $data['opening_bl'];
            }

            $data['vouchers'] = Voucher::where('credit_head_id', $thead->id)
                ->orWhere('debit_head_id', $thead->id)
                ->get()
                ->whereIn('v_group_id', $vgroups->pluck('id'));

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
        $softwareStartDate = $this->getSoftwareStartDate();

        $data['start_date'] = Date::value('date');
        $data['end_date'] = Date::orderby('id', 'desc')->value('date');
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
        $data['types'] = $this->getVoucherTypes();

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
            $current_bl = Process::where('date_id', '<=', $data['dates']->max('id'))
                ->where('thead_id', $thead->id )->get();

            $current_balance = Process::where('date_id','<=', $data['dates']->min('id'))
                ->where('thead_id', $thead->id )->get();

            $vgroups = VoucherGroup::whereIn('date_id', $data['dates']->pluck('id'))
                ->orderBy('date_id', 'desc')
                ->get();

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

                    $data['opening_credit_cash'] += $current_bl->where('date_id', $softwareStartDate->id)->sum('credit');
                    $data['opening_debit_cash'] += $current_bl->where('date_id', $softwareStartDate->id)->sum('debit');
                    $data['opening_bl_cash'] += $current_bl->where('date_id', $softwareStartDate->id)->sum('credit')
                        - $current_bl->where('date_id', $softwareStartDate->id)->sum('debit');
                } else {
                    $data['prev_credit_bank'] += $item->credit;
                    $data['prev_debit_bank'] += $item->debit;
                    $data['prev_bl_bank'] += $item->debit - $item->credit;

                    $data['opening_credit_bank'] += $current_bl->where('date_id', $softwareStartDate->id)->sum('credit');
                    $data['opening_debit_bank'] += $current_bl->where('date_id', $softwareStartDate->id)->sum('debit');
                    $data['opening_bl_bank'] += $current_bl->where('date_id', $softwareStartDate->id)->sum('credit')
                        - $current_bl->where('date_id', $softwareStartDate->id)->sum('debit');
                }
            }

//            }

            $data['vouchers'][$i] = Voucher::where('credit_head_id', $thead->id)
                ->orWhere('debit_head_id', $thead->id)
                ->get()
                ->whereIn('v_group_id', $vgroups->pluck('id'));

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



}
