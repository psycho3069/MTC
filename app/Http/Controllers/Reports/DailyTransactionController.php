<?php

namespace App\Http\Controllers\Reports;

use App\Date;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\TransactionHead;
use App\VoucherType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DailyTransactionController extends Controller
{
    use SoftwareConfigurationTrait;

    public function daily()
    {

        $data['date'] = Date::orderBy('id', 'desc')->get();
        $data['types'] = $this->getVoucherTypes();
        $input['start_date'] = Date::value('date');
        $input['end_date'] = Date::orderBy('date', 'desc')->value('date');

        $i = 0;
        $record = []; $info = [];
        foreach ($data['date'] as $date) {
            foreach ($date->vGroup as $v_group) {
                $i ++;
                foreach ($v_group->vouchers as $voucher) {
                    $debitAcId = $voucher->debit_head_id;
                    $creditAcId = $voucher->credit_head_id;

                    $record[$i][$debitAcId]['debit'] = $v_group->vouchers->where('debit_head_id', $debitAcId)->sum('amount');
                    $record[$i][$creditAcId]['credit'] = $v_group->vouchers->where('credit_head_id', $creditAcId)->sum('amount');

                    if ( !isset($record[$i][$debitAcId]['credit']))
                        $record[$i][$debitAcId]['credit'] = 0;
                    if ( !isset($record[$i][$creditAcId]['debit']) )
                        $record[$i][$creditAcId]['debit'] = 0;


                    $record[$i][$debitAcId]['thead'] = $voucher->debitAccount->name;
                    $record[$i][$creditAcId]['thead'] = $voucher->creditAccount->name;
                    $info[$i]['note'] = $v_group->note;
                    $info[$i]['code'] = $v_group->code;
                    $info[$i]['date'] = $v_group->date->date;
                    $info[$i]['type'] = $v_group->type->name;
                }
            }
        }

        return view('admin.ais.report.daily', compact('data', 'record', 'info', 'input'));

    }


    public function showDaily(Request $request)
    {
        $input = $request->all();

        $data['date'] = Date::whereBetween('date', [ $input['start_date'], $input['end_date'] ])->orderBy('id', 'desc')->get();
        $data['types'] = $this->getVoucherTypes();

        $i = 0;
        $record = []; $info = [];
        foreach ($data['date'] as $date) {

            $vgroups = $date->vGroup;

            if ($request->category == 1)
                $vgroups = $vgroups->where('type_id', '>', 4);
            if ( $request->category == 2)
                $vgroups = $vgroups->where('type_id', '<', 5);
            if ($request->type_id)
                $vgroups = $vgroups->where('type_id', $request->type_id);

            foreach ( $vgroups as $v_group) {
                $i ++;
                foreach ( $v_group->vouchers as $voucher) {
                    $debitAcId = $voucher->debit_head_id;
                    $creditAcId = $voucher->credit_head_id;

                    $record[$i][$debitAcId]['debit'] = $v_group->vouchers->where('debit_head_id', $debitAcId)->sum('amount');
                    $record[$i][$creditAcId]['credit'] = $v_group->vouchers->where('credit_head_id', $creditAcId)->sum('amount');

                    if ( !isset($record[$i][$debitAcId]['credit']))
                        $record[$i][$debitAcId]['credit'] = 0;
                    if ( !isset($record[$i][$creditAcId]['debit']) )
                        $record[$i][$creditAcId]['debit'] = 0;

                    $record[$i][$debitAcId]['thead'] = $voucher->debitAccount->name;
                    $record[$i][$creditAcId]['thead'] = $voucher->creditAccount->name;
                    $info[$i]['note'] = $v_group->note;
                    $info[$i]['code'] = $v_group->code;
                    $info[$i]['date'] = $v_group->date->date;
                    $info[$i]['type'] = $v_group->type->name;

                }
            }
        }

        return view('admin.ais.report.daily', compact('data', 'record', 'info', 'input'));
    }


}
