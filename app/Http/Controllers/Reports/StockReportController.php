<?php

namespace App\Http\Controllers\Reports;

use App\Date;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\MISHead;
use App\MISHeadChild_I;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockReportController extends Controller
{
    use SoftwareConfigurationTrait;


    public function stock($mis_head_id)
    {
        $input['start_date'] = $this->getSoftwareStartDate()->date;
        $input['software_date'] = $this->getSoftwareDate()->date;

        $id = $mis_head_id != 4 ? 5 : 4;
        $mis_head = MISHead::with('child')->find($id);
        $dates = Date::get();
        $data = $this->getAllStock($mis_head, $dates);
        return view('admin.mis.report.stock', compact('mis_head', 'data', 'input'));
    }


    public function showStock(Request $request)
    {
        $mis_head = MISHead::find( $request->mis_head_id);
        $from = date( 'Y-m-d', strtotime($request->from));
        $to = date( 'Y-m-d', strtotime($request->to));
        $dates = Date::orderBy('id', 'asc')
            ->whereDate('date', '>=', $from)
            ->whereDate('date', '<=', $to)
            ->get();

        if (!count($dates)){
            return 220;
        }

        if ( $request->kate_id == 'all')
            return $data = $this->getAllStock($mis_head, $dates);

        $category = MISHeadChild_I::with('ledger.currentStock')
             ->find($request->kate_id);
        $data = $this->getReport( $category, $dates);

        return $data;
    }


    public function getAllStock( $mis_head, $dates)
    {
        $results = [];
        foreach ($mis_head->child as $category) {
            if ( $category->ledger->isNotEmpty())
                $results[] = $this->getReport($category, $dates);
        }

        foreach ( $results as $item) {
            foreach ( $item['stock'] as $key => $stock) {
                $data['stock'][$key] = $stock;
            }
        }

        return $data;
    }


    /*
     * current date opening opening balance will previous dates stock
     * */
    public function getReport( $category, $dates)
    {
        $softwareStartDate = $this->getSoftwareStartDate();
        $opDateId = $dates[0]->id;

        if ($opDateId == $softwareStartDate->id)
            $opDateId += 1;

        foreach ($category->ledger as $ledger) {

            $data['stock'][$ledger->id]['purchase'] = 0;
            $data['stock'][$ledger->id]['delivery'] = 0;
            $data['stock'][$ledger->id]['cost'] = 0;

            $data['stock'][$ledger->id]['name'] = $ledger->name;
            $data['stock'][$ledger->id]['category'] = $ledger->ledgerable->name;
            $data['stock'][$ledger->id]['unit'] = $ledger->unitType->name;

            $cr_stock = $ledger->currentStock->where('date_id', '<', $opDateId);
            $purchases = $ledger->purchases->whereIn('date_id', $dates->pluck('id'));
            $deliveries = $ledger->deliveries->whereIn('date_id', $dates->pluck('id'));

            $data['stock'][$ledger->id]['op_bl'] = $cr_stock->sum('quantity_dr') - $cr_stock->sum('quantity_cr');

            foreach ( $purchases as $purchase) {
                $data['stock'][$ledger->id]['purchase'] += $purchase->currentStock->quantity_dr;
                $data['stock'][$ledger->id]['cost'] += $purchase->amount;
            }

            foreach ( $deliveries as $delivery) {
                $data['stock'][$ledger->id]['delivery'] += $delivery->currentStock->quantity_cr;
            }

            $data['stock'][$ledger->id]['cl_bl'] = $data['stock'][$ledger->id]['op_bl'] + $data['stock'][$ledger->id]['purchase'] - $data['stock'][$ledger->id]['delivery'];
        }

        return $data;
    }




}
