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

        if (Date::find($date_id)) {
            $filter_date = Date::find($date_id)->date;
        } else {
            $filter_date = Date::get()->last()->date;
        }

        $year = explode("-", $filter_date)[0];
        $start_date = $year.'-'.explode("-",Date::find($date_id) ? Date::find($date_id)->date : Date::get()->last()->date)[1].'-01';
        $start_year = $year.'-01-01';
        $date_id_min = Date::min('id');

        $all_bl = Process::whereIn('thead_id', collect($data)->flatten())
            ->whereBetween('date_id', [ Date::where('date',$start_date)->first() ? Date::where('date',$start_date)->first()->id : Date::find($date_id_min)->id , Date::find($date_id)->id])->get();
        $all_bl_year = Process::whereIn('thead_id', collect($data)->flatten())
            ->whereBetween('date_id', [Date::where('date',$start_year)->first() ? Date::where('date',$start_year)->first()->id : Date::find($date_id_min)->id, Date::find($date_id)->id])->get();

        return view('admin.ais.report.income', compact('heads', 'all_bl','all_bl_year', 'dates', 'date'));

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







}
