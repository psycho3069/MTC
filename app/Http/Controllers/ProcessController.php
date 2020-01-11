<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Date;
use App\Process;
use App\TransactionHead;
use App\TransactionHistory;
use App\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ProcessController extends Controller
{
    public function index(Request $request)
    {
        $all_bl = Process::all();
        $dates = Date::all();

//        $data = Process::where('debit', '>', 0)->orWhere('credit', '>', 0)->get()->groupBy('date_id');
//        $data = new LengthAwarePaginator($data, count($data), 2);
//        $data->setPath('process');

        return view('admin.ais.process.index', compact('dates', 'all_bl'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function test()
    {
        $dates = Date::orderBy('id')->get();

        $x = $dates->where('status', 0);
        $date = $x->isEmpty() ? $dates->first() : $x->first();

        foreach ($dates as $item) {
            $year = date( 'Y', strtotime($item->date));
            $month[$year] = date( 'M', strtotime($item->date));
            $years[$year][$month[$year]][$item->id] = date( 'd', strtotime($item->date));
        }


//        return $years;


        return view('admin.ais.process.test', compact('dates', 'date', 'years') );
    }




    public function year(Request $request)
    {
//        return $request->all();
        $dates = Date::whereYear('date', $request->year)->get();
//        return $dates;

        foreach ($dates as $item) {
            $month[$item->id] = date( 'M', strtotime($item->date));
        }


        if ( $request->month){

            $dates = Date::all();
            $dt = $dates->find($request->month);
            $yr = date('Y', strtotime( $dt->date));
            $mo = date('M', strtotime( $dt->date));
            foreach ($dates as $item) {
                $yr_1 = date('Y', strtotime($item->date));
                $mo_1 = date('M', strtotime($item->date));
                if ( $yr == $yr_1 && $mo == $mo_1)
                    $days[$item->id] = date('d', strtotime($item->date));
            }
            $data['day'] = collect($days);
        }


        $data['month'] = collect($month)->unique();
        return $data;
    }


    public function list()
    {
        $dates = Date::orderBy('id')->get();


        foreach ($dates as $item) {

            $year = date( 'Y', strtotime($item->date));
            $month[$year] = date( 'M', strtotime($item->date));
            $years[$year][$month[$year]][$item->id] = date( 'd', strtotime($item->date));
        }

        $x = $dates->where('status', 0);
        $date = $x->isEmpty() ? $dates->first() : $x->first();



        return view('admin.ais.process.list', compact('dates', 'date', 'years') );
    }


    public function showList(Request $request)
    {
        $dates = Date::orderBy('id')->get();
        if ( $dates->isEmpty() ){
            $status = 0;
            return view('admin.ais.report.daily', compact('status'));
        }
        $date = $dates->find( $request->date_id);
//        return $request->all();
        return view('admin.ais.process.list', compact('dates', 'date') );

//        return $request->all();
    }


    public function record(Request $request)
    {
        $dates = Date::orderBy('id')->get();
        if ( $dates->isEmpty() ){
            $status = 0;
            return view('admin.ais.report.daily', compact('status'));
        }

    }


    public function listOld()
    {
        $dates = Date::get();
        $opening_bl = Process::where( 'date_id', 0 )->get();
        $all_bl = Process::all();

        return view('admin.ais.process.list', compact('dates', 'opening_bl', 'all_bl'));
    }


    public static function calculate($item)
    {
        $data = Process::where( 'thead_id', $item->thead_id)->where( 'date_id', '<=', $item->date_id)->get();
        $balance = ($item->thead->ac_head_id == 1) || ($item->thead->ac_head_id == 4) ? $data->sum('debit') - $data->sum('credit') : $data->sum('credit') - $data->sum('debit');
        return $balance;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     */

    public function store(Request $request)
    {
        $day_end = Date::find( $request->date_id);
        $day_end->status = 1;
        $day_end->save();
        $x = Configuration::find(1);
        $x->software_start_date = date('Y-m-d', strtotime('+1 day', strtotime($x->software_start_date)));;
        $x->save();

        return redirect('process/list');
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
        return $id;
    }
}
