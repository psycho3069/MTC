<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\Purchase\StoreRequest;
use App\Http\Requests\Purchase\UpdateRequest;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\Http\Traits\StockTrait;
use App\Http\Traits\VoucherTrait;
use App\MISHeadChild_I;
use App\PurchaseGroup;
use App\Supplier;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    use StockTrait, SoftwareConfigurationTrait, VoucherTrait;
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
        $result = MISHeadChild_I::find( $request->id);
        foreach ($result->ledger as $item) {
            $data['item'][$item->id]['stock'] = $item->currentStock->sum('quantity_dr')
                - $item->currentStock->sum('quantity_cr');
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
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $softwareDate = $this->getSoftwareDate();
            $this->storeMISPurchase($request, $softwareDate);
            DB::commit();
            session()->flash('create', '<b>All Items has been purchased.</b>');
            return redirect()->route('purchase.index', ['mis_head_id' => $request->mis_head_id]);
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')->error('purchase.error', ['error' => $exception->getMessage()]);
            return redirect()->route('purchase.index', ['mis_head_id' => $request->mis_head_id]);
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
        $p_group = PurchaseGroup::findOrFail($id);
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
        $p_group = PurchaseGroup::findOrFail($id);
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


    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $purchaseGroup = PurchaseGroup::findOrFail($id);
            $this->updateMISPurchase($request, $purchaseGroup);
            DB::commit();
            session()->flash('update', '<b>Purchase has been updated successfully</b>');
            return redirect()->route('purchase.index', ['mis_head_id' => $purchaseGroup->mis_head_id]);
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('purchase.error', ['error' => $exception->getMessage()]);

            return redirect()->back();
        }




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */




    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $purchaseGroup = PurchaseGroup::findOrFail( $id);
            $this->deleteMISPurchase($purchaseGroup);
            session()->flash('success', '<b>Purchase Has Been Deleted Successfully.</b>');
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('purchase.error', ['error' => $exception->getMessage()]);
        }


        return $purchaseGroup->mis_head_id;
    }
}
