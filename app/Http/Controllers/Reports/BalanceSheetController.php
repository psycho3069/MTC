<?php

namespace App\Http\Controllers\Reports;

use App\AccountHead;
use App\Date;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\Process;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BalanceSheetController extends Controller
{
    use SoftwareConfigurationTrait;


    public function balance(Request $request)
    {
        $dates = Date::all();
        $date_id = $request->date_id ? $request->date_id : Date::max('id');

        $heads = AccountHead::all();

        foreach ($heads as $head) {
            $balance = Process::whereIn('thead_id', $head->theads->pluck('id'))->where( 'date_id', '<=', $date_id)->get();
            $pr_bl[$head->id] = $balance->sum('credit') - $balance->sum('debit');
            if($head->id == 1 || $head->id ==4)
                $pr_bl[$head->id] = -1 * $pr_bl[$head->id];

            if ( $head->id == 1 ){
                foreach ( $head->theads as $asset){
                    $data['asset'][] = $asset->id;
                }
            }

            if ( $head->id == 2){
                foreach ( $head->theads as $liability ){
                    $data['liability'][] = $liability->id;
                }
            }
        }


        $all_bl = Process::whereIn('thead_id', collect($data)->flatten())->where( 'date_id', '<=', $date_id)->get();

        return view('admin.ais.report.balance', compact('heads', 'all_bl', 'dates', 'date_id', 'pr_bl'));

    }

}
