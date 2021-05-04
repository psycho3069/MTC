<?php


namespace App\Http\Traits;

use App\AccountHead;
use App\AccountHeadChild_I;
use App\AccountHeadChild_II;
use App\AccountHeadChild_III;
use App\TransactionHead;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;

trait IncomeStatementTrait

{


    public function getLookUpDates($date)
    {
        $date_arr = explode('-', $date);

        $year = $date_arr[0];
        $month = $date_arr[1];
        $day = $date_arr[2];

        return DB::table('dates')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->whereDay('date', '<=', $day)
            ->pluck('id');

    }


    public function getLookupDates1($date)
    {
        $date_arr = explode('-', $date);

        $year = $date_arr[0];
        $month = $date_arr[1];
        $day = $date_arr[2];

        return DB::table('dates')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->whereDay('date', '<=', $day)
            ->pluck('id');

    }



    public function getMonthlyIncome($dates, $ac_head)
    {
        $theads_id = TransactionHead::select('id')
            ->whereIn('ac_head_id', $ac_head)
            ->pluck('id');

        $balance['cumulative'] = DB::table('current_balance')
            ->selectRaw('thead_id, (SUM(debit) - SUM(credit)) AS total')
            ->whereIn('thead_id', $theads_id)
            ->groupBy('thead_id')
            ->having('total', '!=', 0)
            ->get();

        $balance['monthly'] = DB::table('current_balance')
            ->selectRaw('thead_id, (SUM(debit) - SUM(credit)) AS total')
            ->whereIn('date_id', $dates)
            ->whereIn('thead_id', $theads_id)
            ->groupBy('thead_id')
            ->having('total', '!=', 0)
            ->get();



        $income = [];

        foreach ($balance as $incomeType => $theads) {
            foreach ($theads as $thead){
                $income[$thead->thead_id][$incomeType] = $thead->total;
            }
        }

        foreach ($income as $theadId => $balance){
            $income[$theadId]['monthly'] = $balance['monthly'] ?? 0;
        }

        return $income;
    }



    public function getIncomeAccounts($ac_heads, $theads_id)
    {
        $query = AccountHead::query();
        $query->whereIn('id', $ac_heads);

        $query->with([
            'theads' => function($q) use ($theads_id) {
                $q->whereIn('id', $theads_id);
            },
            'theads.transactionable' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    AccountHeadChild_I::class => ['parent'],
                    AccountHeadChild_II::class => ['parent.parent'],
                    AccountHeadChild_III::class => ['parent.parent.parent']
                ]);
            }]);


        return $query->get();
    }


    public function getTransactionHeadInfo($thead, $balance)
    {
        if ($thead->ac_head_id == 3){
            $balance['monthly'] = -1 * $balance['monthly'];
            $balance['cumulative'] = -1 * $balance['cumulative'];
        }

        return [
            'name' => $thead->name,
            'monthly' => $balance['monthly'],
            'cumulative' => $balance['cumulative']
        ];
    }


    public function getTotal($prev, $add)
    {
        $monthly = $prev['balance']['monthly'] ?? 0;
        $cumulative = $prev['balance']['cumulative'] ?? 0;

        return [
            'monthly' => $add['monthly'] + $monthly,
            'cumulative' => $add['cumulative'] + $cumulative,
        ];

    }


    public function getAccountHeadInfo($prev, $add, $acHead)
    {
        $monthly = $prev['monthly'] ?? 0;
        $cumulative = $prev['cumulative'] ?? 0;

        return [
            'name' => $acHead->name,
            'monthly' => $add['monthly'] + $monthly,
            'cumulative' => $add['cumulative'] + $cumulative,
        ];

    }


}
