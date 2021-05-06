<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Date;
use App\Delivery;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\Http\Traits\StockTrait;
use App\MISHeadChild_I;
use App\MISLedgerHead;
use App\Stock;
use App\StockHead;
use App\Unit;
use App\UnitType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockDeliverController extends Controller
{
    use SoftwareConfigurationTrait, StockTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::orderBy('id', 'desc')->get();
//        return $deliveries;
        return view('admin.mis.stock.deliver.index', compact('deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stock_head = MISHeadChild_I::where( 'mis_head_id', 4)->has('ledger')->get();
        $data['units'] = Unit::get(['id', 'name', 'unit_type_id']);

        return view('admin.mis.stock.deliver.create', compact('stock_head', 'data'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $softwareDate = $this->getSoftwareDate();
            $this->deliverGroceries($request, $softwareDate);
            DB::commit();
            session()->flash('success', 'Delivery successfully');
            return redirect()->route('deliver.index');
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('delivery.error', ['error' => $exception->getMessage()]);

            return redirect()->back()->withInput($request->all());
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
        $delivery = Delivery::find($id);
        $data['units'] = Unit::all();

        return view('admin.mis.stock.deliver.edit', compact('delivery', 'data'));

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
        DB::beginTransaction();
        try {
            $delivery = Delivery::find($id);
            $this->updateDelivery($request, $delivery);
            DB::commit();
            session()->flash('success', 'Delivery updated');
            return redirect()->route('deliver.index');
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('delivery.error', ['error' => $exception->getMessage()]);

            return redirect()->back()->withInput($request->all());
        }




        return redirect('stocks/deliver')->with('update', '<b>Operation successful</b>');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery = Delivery::find($id);
        $delivery->currentStock->delete();
        $delivery->delete();

        session()->flash('success', '<b>Operation successful.</b> Delivery has been deleted');
        return 200;
    }
}
