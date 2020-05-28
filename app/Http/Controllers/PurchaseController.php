<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Date;
use App\Employee;
use App\Http\Traits\CustomTrait;
use App\MisCurrentStock;
use App\MISHead;
use App\MISHeadChild_I;
use App\MISLedgerHead;
use App\Process;
use App\Purchase;
use App\PurchaseGroup;
use App\StockHead;
use App\Supplier;
use App\Unit;
use App\VoucherGroup;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    use CustomTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
//        return $request->all();
//        $type_id = $request->mis_head_id != 5 ? 4 : 5;
//        $mis_ledger_heads = MISLedgerHead::where('mis_head_id',$request->mis_head_id)->get();
//        if (!$request->start_date && !$request->end_date && $request->type_id == 0){
//            $p_groups = PurchaseGroup::where( 'mis_head_id', $type_id)
//                ->orderBy('id', 'desc')
//                ->get();
//            return view('admin.mis.purchase.index', compact('p_groups', 'type_id','mis_ledger_heads'));
//        } else if ($request->category_id != 0){
//            $data['type_id'] = $request->type_id;
//            $data['category_id'] = $request->category_id;
//            $data['mis_ledger_heads'] = MISLedgerHead::all();
//            return $mis_ledger_head = MISLedgerHead::find($request->category_id);
//            $data['purchaseGroup'] = [];
//
//            $i = 0;
//            return $purchases = $mis_ledger_head->purchases;
//            foreach ($purchases as $purchase){
//                $data['purchaseGroup'][$i++] = $purchase->purchaseGroup;
//            }
//
//
//            return $data['purchaseGroup'];
////            $data['p_groups'] = PurchaseGroup::where( 'mis_head_id', $type_id)
////                ->orderBy('id', 'desc')
////                ->get();
////            return view('admin.mis.purchase.index', $data);
//        } else if ($request->category_id == 0){
//            $p_groups = PurchaseGroup::where( 'mis_head_id', $type_id)
//                ->orderBy('id', 'desc')
//                ->get();
//            return view('admin.mis.purchase.index', compact('p_groups', 'type_id','mis_ledger_heads'));
//        } else {
//            $p_groups = PurchaseGroup::where( 'mis_head_id', $type_id)
//                ->orderBy('id', 'desc')
//                ->get();
//            return view('admin.mis.purchase.index', compact('p_groups', 'type_id','mis_ledger_heads'));
//        }

        $type_id = $request->mis_head_id != 5 ? 4 : 5;
        $p_groups = PurchaseGroup::where( 'mis_head_id', $type_id)->orderBy('id', 'desc')->get();
        return view('admin.mis.purchase.index', compact('p_groups', 'type_id'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cat_id = $request->mis_head_id != 5 ? 4 : 5;
        $data['supplier'] = Supplier::all();
        $data['receiver'] = Employee::all();
        $mis_heads = MISHeadChild_I::where( 'mis_head_id', $cat_id)->has('ledger')->get();
        $data['units'] = Unit::get(['id', 'name', 'unit_type_id']);

        return view('admin.mis.purchase.create', compact('mis_heads', 'data', 'cat_id'));
    }


    public function item(Request $request)
    {
//        return $request->all();
        $result = MISHeadChild_I::find( $request->id);
        foreach ($result->ledger as $item) {
            $data['item'][$item->id]['stock'] = $item->currentStock->sum('quantity_dr') - $item->currentStock->sum('quantity_cr');
            $data['item'][$item->id]['name'] = $item->name;
            $data['item'][$item->id]['unit'] = $item->unitType->name;
            $data['item'][$item->id]['unit_type_id'] = $item->unit_type_id;
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */




    public function store(Request $request)
    {
//        return $request->all();
        $request->validate([
            'mis_head_id' => 'required',
            'input.*.*' => 'required',
            'input.*.quantity_dr' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
            'input.*.amount' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
        ],[
            'mis_head_id.required' => 'Your request can\'t be completed. Please try again',
            'input.*.*.required' => 'Please Enter Valid Info',
            'input.*.quantity_dr.required' => 'Please Enter Quantity',
            'input.*.quantity_dr.regex' => 'Invalid Quantity. Only decimal values are allowed',
            'input.*.amount.required' => 'Please Enter Amount',
            'input.*.amount.regex' => 'Invalid Amount. Only decimal values are allowed',
        ]);


        $input = collect( $request->input);
        $date = $this->getDate();

        $data = $request->except('input', '_token');
        $data['date_id'] = $date->id;
        $data['user_id'] = auth()->user()->id;

        $p_group = PurchaseGroup::create( $data);

        foreach ($input as $item) {
            $ledger = MISLedgerHead::find( $item['stock_id']);
            $item['mis_voucher_id'] = $this->computeAIS( $ledger, $item['amount']);

            $item['date_id'] = $date->id;
            $unit = $ledger->unitType->units->find( $item['unit_id']);
            $item['quantity_dr'] = $item['quantity_dr'] / $unit->multiply_by;

            $cr_stock = $ledger->currentStock()->create($item);
            $item['current_stock_id'] = $cr_stock->id;
            $p_group->purchases()->create( $item);
        }


        $request->session()->flash('create', '<b>All Items has been purchased.</b>');

        return redirect('purchase?mis_head_id='.$ledger->mis_head_id);

    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $p_group = PurchaseGroup::find($id);
        return view('admin.mis.purchase.show', compact('p_group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $p_group = PurchaseGroup::find($id);
        $data['supplier'] = Supplier::all();
        $data['receiver'] = Employee::all();
        $data['units'] = Unit::all();

        return view('admin.mis.purchase.edit', compact('p_group', 'data'));
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
//        return $request->all();
        $request->validate([
            'input.*.*' => 'required',
            'input.*.quantity_dr' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
            'input.*.amount' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
        ],[
            'input.*.*.required' => 'Please Enter Valid Info',
            'input.*.quantity_dr.required' => 'Please Enter Quantity',
            'input.*.quantity_dr.regex' => 'Invalid Quantity. Only decimal values are allowed',
            'input.*.amount.required' => 'Please Enter Amount',
            'input.*.amount.regex' => 'Invalid Amount. Only decimal values are allowed',
        ]);

        $input = collect($request->input);
        $p_group = PurchaseGroup::find($id);
        $data['note'] = 'Updated From Grocery Purchase- [id: '.$p_group->id .']';

        foreach ($input as $key => $item) {
            $purchase = $p_group->purchases->find($key);
            $voucher = $purchase->misVoucher->voucher;
            $data['new_amount'] = $item['amount'];

            if ( $voucher->amount != $item['amount'])
                $this->updateAIS( $voucher, $data);

            $purchase->update( $item);
            $unit = $purchase->ledger->unitType->units->find( $item['unit_id']);
            $purchase->currentStock->update([ 'quantity_dr' => $item['quantity_dr'] / $unit->multiply_by ]);

        }

        $request->session()->flash('update', '<b>Purchase has been updated successfully</b>');
        return redirect('purchase?mis_head_id='.$p_group->mis_head_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */




    public function destroy($id)
    {
        $p_group = PurchaseGroup::find( $id);

        foreach ($p_group->purchases as $purchase) {
            $voucher = $purchase->misVoucher->voucher;
            $data['new_amount'] = 0; $data['note'] = 'Deleted From Grocery Purchase - [id: '.$purchase->id. ']';
            $this->deleteVoucher( $voucher, $data);
            $purchase->misVoucher->delete();
            $purchase->currentStock->delete();
            $purchase->delete();
        }
        $p_group->delete();

        session()->flash('success', '<b>Purchase Has Been Deleted Successfully.</b>');

        return $p_group->mis_head_id;
    }
}
