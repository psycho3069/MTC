<?php

namespace App\Http\Controllers;


use App\Http\Traits\IncomeStatementTrait;

class AISReportController extends Controller
{
    use IncomeStatementTrait;



    public function incomeStatement()
    {
        $ac_head = [3, 4];

        $date = request('date') ?: date('Y-m-d');
//        $date = date('2020-03-26');
        $dates_id = $this->getLookupDates($date);
        $income = $this->getMonthlyIncome($dates_id, $ac_head);
        $accountHeads = $this->getIncomeAccounts($ac_head, array_keys($income));

        $data = [];

        foreach ($accountHeads as $head) {
            $data[$head->id]['name'] = $head->name;

            foreach ($head->theads as $thead) {
                $subHead = $thead->transactionable;
                $thead_info = $this->getTransactionHeadInfo($thead, $income[$thead->id]);

                $x = $this->getAccountHeadInfo($data[$head->id], $thead_info, $head);
                $data[$head->id] = array_replace($data[$head->id], $x);

                if ($subHead->ac_head_id){
                    $data[$head->id][$subHead->ac_head_id][$thead->id] = $thead_info;

                    $x = $this->getAccountHeadInfo($data[$head->id][$subHead->ac_head_id], $thead_info, $subHead);
                    $data[$head->id][$subHead->ac_head_id] = array_replace($data[$head->id][$subHead->ac_head_id], $x);

                    continue;
                }

                if($subHead->ac_head_child_i_id){
                    $data[$head->id][$subHead->parent->id][$subHead->id][$thead->id] = $thead_info;

                    $x = $this->getAccountHeadInfo($data[$head->id][$subHead->parent->id][$subHead->id], $thead_info, $subHead);
                    $y = $this->getAccountHeadInfo($data[$head->id][$subHead->parent->id], $thead_info, $subHead->parent);

                    $data[$head->id][$subHead->parent->id][$subHead->id] = array_replace($data[$head->id][$subHead->parent->id][$subHead->id], $x);
                    $data[$head->id][$subHead->parent->id] = array_replace($data[$head->id][$subHead->parent->id], $y);

                    continue;
                }



                if($subHead->ac_head_child_ii_id){
                    $data[$head->id][$subHead->parent->parent->id][$subHead->parent->id][$subHead->id][$thead->id] = $thead_info;

                    $x = $this->getAccountHeadInfo($data[$head->id][$subHead->parent->parent->id][$subHead->parent->id][$subHead->id], $thead_info, $subHead);
                    $y = $this->getAccountHeadInfo($data[$head->id][$subHead->parent->parent->id][$subHead->parent->id], $thead_info, $subHead->parent);
                    $z = $this->getAccountHeadInfo($data[$head->id][$subHead->parent->parent->id], $thead_info, $subHead->parent->parent);

                    $data[$head->id][$subHead->parent->parent->id][$subHead->parent->id][$subHead->id] = array_replace($data[$head->id][$subHead->parent->parent->id][$subHead->parent->id][$subHead->id], $x);
                    $data[$head->id][$subHead->parent->parent->id][$subHead->parent->id] = array_replace($data[$head->id][$subHead->parent->parent->id][$subHead->parent->id], $y);
                    $data[$head->id][$subHead->parent->parent->id] = array_replace($data[$head->id][$subHead->parent->parent->id], $z);
                }

            }
        }

        return view('admin.ais.report.income-statement', compact('data', 'date'));
    }


}
