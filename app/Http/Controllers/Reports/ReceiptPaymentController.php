<?php

namespace App\Http\Controllers\Reports;

use App\Date;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\TransactionHead;
use App\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReceiptPaymentController extends Controller
{
    use SoftwareConfigurationTrait;


    public function receiptPayment(Request $request)
    {
//        $this->fixThead();

        $softwareDate = $this->getSoftwareDate();
        $date = $request->date ?: $softwareDate->date;

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

        $input['date'] = $date;

        return view('admin.ais.report.receipt_payment', compact('data', 'input'));
//        return view('admin.ais.report.firefox_receipt_payment', compact('data', 'input'));

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
