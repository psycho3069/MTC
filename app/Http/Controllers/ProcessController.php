<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Date;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\Process;
use App\TransactionHead;
use App\TransactionHistory;
use App\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessController extends Controller
{
    use SoftwareConfigurationTrait;


    public function index(Request $request)
    {
        $all_bl = Process::all();
        $dates = Date::all();
        return view('admin.ais.process.index', compact('dates', 'all_bl'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function list()
    {
        $dates = Date::select('id', 'date', 'status')->get();
        $x = $dates->where('status', 0);
        $date = $x->isEmpty() ? $dates->first() : $x->first();

        return $this->getDate($dates, $date);
    }


    public function showList(Request $request)
    {

        $query = Date::query();
        $query->with(['groupVouchers', 'groupVouchers.vouchers', 'groupVouchers.type']);
        $date = $query->find($request->date_id);
        $dates = Date::get();

        return $this->getDate($dates, $date);
    }

    public function getDate( $dates, $date)
    {
        $format['year'] = date('Y', strtotime( $date->date));
        $format['month'] = date('M', strtotime( $date->date));
        $format['day'] = date('d', strtotime( $date->date));


        foreach ($dates as $item) {
            $year = date( 'Y', strtotime($item->date));
            $month[$year] = date( 'M', strtotime($item->date));
            $data['years'][$year][$month[$year]][$item->id] = date( 'd', strtotime($item->date));
            if ( $format['year'] == $year ){
                $data['months'][$item->id] = date('M', strtotime( $item->date));
                if ( $format['month'] == $month[$year])
                    $data['days'][$item->id] = date('d', strtotime( $item->date));
            }
        }

        $data['months'] = collect($data['months'])->unique();

        return view('admin.ais.process.list', compact('date', 'data', 'format') );
    }







    public function year(Request $request)
    {

        $dates = Date::whereYear('date', $request->year)->get();

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



    public function listOld()
    {

        $defaultDate = Date::where('status', 0)->value('id');
        $query = Date::query();
        $query->with(['groupVouchers', 'groupVouchers.vouchers', 'groupVouchers.type']);
        $showDate = $query->find(request('date_id', $defaultDate));

        $dates = [];
        $query = Date::query();
        $query->selectRaw('id, YEAR(date) year, MONTHNAME(date) month, DAY(date) day');
        $query->orderBy('date');
        foreach ($query->get() as $date) {
            $dates[$date->year][$date->month][$date->day] = $date->id;
        }


        return view('admin.ais.process.list', compact('dates', 'showDate') );

    }



    public function record(Request $request)
    {
        $dates = Date::orderBy('id')->get();
        if ( $dates->isEmpty() ){
            $status = 0;
            return view('admin.ais.report.daily', compact('status'));
        }

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
        DB::beginTransaction();
        try {
            $date = Date::find($request->date_id);
            $date->status = 1;
            $date->save();

            $nextDate = Carbon::parse($date->date)->addDay();
            $nextDate = Date::firstOrCreate(['date' => $nextDate]);

            $softwareDate = $this->getSoftwareConfigurationDate();
            $softwareDate->date = $nextDate->date;
            $softwareDate->save();
            session()->flash('success', 'Operation successful');
            DB::commit();
            return redirect()->route('process.list');
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('process.error', ['error' => $exception->getMessage()]);

            return redirect()->back();
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
        return $id;
    }
}
