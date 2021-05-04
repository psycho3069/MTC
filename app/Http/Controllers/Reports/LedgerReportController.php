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

class LedgerReportController extends Controller
{
    use SoftwareConfigurationTrait;


    public function getLedgerReport()
    {

    }



    public function ledger($thead_id = null)
    {
        $softwareStartDate = $this->getSoftwareStartDate();
        $data['start_date'] = $softwareStartDate->date;
        $data['dates'] = Date::get();
        $data['theads'] = TransactionHead::all();
        $data['types'] = VoucherType::all()->except([ 5, 6, 7, 8, 9]);

        if ( $thead_id){
            $thead = $data['theads']->find($thead_id);
            $current_bl = Process::where('thead_id', $thead->id )->get();
            $data['opening_bl'] = $current_bl->where('date_id', $softwareStartDate->id)->sum('credit')
                - $current_bl->where('date_id', $softwareStartDate->id)->sum('debit');

            $data['vouchers'] = Voucher::where('credit_head_id', $thead->id)
                ->orWhere('debit_head_id', $thead->id)
                ->get();

            foreach ($data['vouchers']->groupBy('date_id') as $key => $vouchers) {
                $balance = $current_bl->where('date_id', '<=', $key-1);
                $credit = 0; $debit =0;

                foreach ($vouchers as $voucher) {
                    if ( $voucher->credit_head_id == $thead->id)
                        $credit += $voucher->amount;
                    if ( $voucher->debit_head_id == $thead->id)
                        $debit += $voucher->amount;
                    $y = $balance->sum('debit') + $debit - $balance->sum('credit') - $credit ;
                    $amount[$voucher->id] = ( $thead->ac_head_id == 1 || $thead->ac_head_id == 4) ? $y  : -$y;
                }
            }
            return view('admin.ais.report.ledger', compact('data', 'amount', 'thead' ));

        }

        return view('admin.ais.report.ledger', compact('data' ));
    }



    public function showLedger(Request $request)
    {
        $softwareStartDate = $this->getSoftwareStartDate();

        $input = $request->all();
        $amount[] = 0;
        $data['dates'] = Date::whereBetween('date', [$input['start_date'], $input['end_date']])->get();

        if ( $data['dates']){
            $current_bl = Process::where('date_id', '<=', $data['dates']->max('id'))
                ->where('thead_id', $input['thead_id'] )
                ->get();

            $data['types'] = VoucherType::whereNotIn('id', [5,6,7,8,9])->get();
            $data['theads'] = TransactionHead::all();
            $thead = $data['theads']->find($request->thead_id);

            $vgroups = VoucherGroup::whereIn('date_id', $data['dates']->pluck('id'))
                ->orderBy('date_id', 'desc')
                ->get();

            if ($request->category == 1)
                $vgroups = $vgroups->where('type_id', '>', 4);
            if ( $request->category == 2)
                $vgroups = $vgroups->where('type_id', '<', 5);
            if ($request->type_id)
                $vgroups = $vgroups->where('type_id', $request->type_id);


            $data['vouchers'] = Voucher::where('credit_head_id', $request->thead_id)
                ->orWhere('debit_head_id', $request->thead_id)
                ->get()
                ->whereIn('v_group_id', $vgroups->pluck('id'));

            $data['opening_bl'] = $current_bl->where('date_id', $softwareStartDate->id)->sum('credit')
                - $current_bl->where('date_id', $softwareStartDate->id)->sum('debit');

            $data['prev_bl'] = $current_bl->where('date_id', $data['dates']
                    ->min('date_id'))->sum('credit') - $current_bl->where('date_id', $data['dates']
                    ->min('date_id'))->sum('debit');

            if ( ($thead->ac_head_id == 1 || $thead->ac_head_id == 4)){
                if( $data['opening_bl'])
                    $data['opening_bl'] = - $data['opening_bl'];
                if ( $data['prev_bl'])
                    $data['prev_bl'] = - $data['prev_bl'];
            }


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

            return view('admin.ais.report.show_ledger', compact('current_bl', 'data', 'input', 'amount'));

        }


    }
}
