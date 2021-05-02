<?php

namespace App\Http\Controllers;

use App\Http\Requests\Stock\OpeningBalanceRequest;
use App\Http\Requests\Stock\StoreRequest;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\Http\Traits\StockTrait;
use App\MisCurrentStock;
use App\MISHead;
use App\MISHeadChild_I;
use App\MISLedgerHead;
use App\Stock;
use App\StockHead;
use App\UnitType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    use SoftwareConfigurationTrait, StockTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $misHeadId = $request->mis_head_id != 5 ? 4 : 5;
        return view('admin.mis.stock.index', compact( 'misHeadId'));
    }




    public function getIndexTable($misHeadId)
    {
        $name = request('name');
        $perPage = request('per_page') ?: 5;
        $query = MISHeadChild_I::query();

        $query->where( 'mis_head_id', $misHeadId);
        $query->when($name, function ($query, $name) use ($misHeadId){
            $query->with(['ledger' => function($query) use ($name){
                $query->where('name', 'LIKE', "%$name%");
            }]);
            $query->where('name', 'LIKE', "%$name%")
                ->orWhereHas('ledger', function($query) use($name, $misHeadId){
                    $query->where('name', 'LIKE', "%$name%");
                    $query->where('mis_head_id',  $misHeadId);
                });
        });

        $categories = $query->paginate($perPage)
            ->withPath("stock")
            ->appends([
                'mis_head_id' => $misHeadId,
                'name' => $name,
                'per_page' => $perPage
            ]);

        return view('admin.mis.stock.index-table', compact('categories'))->render();
    }





    public function list($mis_head_id)
    {
        $mis_head_id = ($mis_head_id != 5) ? 4 : 5;
        $categories = MISHeadChild_I::where('mis_head_id', $mis_head_id)->get();
        return view('admin.mis.stock.list', compact('categories', 'mis_head_id'));
    }


    public function opening($misHeadId)
    {
        $misHeadId = $misHeadId != 5 ? 4 : 5;
        $total = MISLedgerHead::where('mis_head_id', $misHeadId)->count();
        return view('admin.mis.stock.opening-balance', compact('total',  'misHeadId'));
    }


    public function tableSearch($misHeadId)
    {
        $perPage = request('per_page') ?: 5;
        $name = request('name');
        $units = UnitType::all();
        $query = MISLedgerHead::query();
        $query->with('ledgerable:id,name', 'misHead:id,name');
        $query->where('mis_head_id', $misHeadId);
        $query->when($name, function($query, $name){
            $query->where('name', 'LIKE', "%$name%");
        });
        $query->orderBy('name', 'asc');
        $ledgerHeads = $query->paginate($perPage)
            ->withPath("{$misHeadId}")
            ->appends(['name' => $name, 'per_page' => $perPage]);

        return view('admin.mis.stock.balance-table', compact('ledgerHeads', 'units'));

    }


    public function balance(OpeningBalanceRequest $request)
    {
        DB::beginTransaction();
        try {
            $softwareStartDate = $this->getSoftwareStartDate();

            foreach ($request->input as $id => $input){
                $ledgerHead = MISLedgerHead::findOrFail($id);
                $currentStock = MisCurrentStock::firstOrNew([
                    'stock_id' => $ledgerHead->id,
                    'date_id' => $softwareStartDate->id
                ]);

                $currentStock->quantity_dr += $input['amount'] - $ledgerHead->amount;
                $currentStock->save();

                $ledgerHead->amount = $input['amount'];
                $ledgerHead->unit_type_id = $input['unit_type_id'];
                $ledgerHead->save();
            }

            DB::commit();
            session()->flash('update', 'Opening balance successfully updated');
            return redirect( )->back();
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('stock.errors', ['error' => $exception->getMessage()]);

            return redirect( )->back();
        }

    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $mis_head_id = $request->mis_head_id != 5 ? 4 : 5;
        $cat_id = $request->cat_id;
        $units = UnitType::all();

        if ( $cat_id)
            return view('admin.mis.stock.create', compact('cat_id', 'mis_head_id', 'units'));

        return view('admin.mis.stock.create', compact('mis_head_id'));
    }

    /**
     * Create Item or Category
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->cat_id){
                $ledgerHead = $this->createLedgerHead($request);
                $request->session()->flash('create', '<b>'.$ledgerHead->name.'</b> has been added to the <b>'.$ledgerHead->ledgerable->name.'</b> category list');
            }else{
                $misHeadI = $this->createLedgerHeadCategory($request);
                $request->session()->flash('create', '<b>'.$misHeadI->name.'</b> has been added to the category list');
            }

            DB::commit();
            return redirect()->route('stock.index', ['mis_head_id' => $request->mis_head_id]);
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')->error('stock.error', ['error' => $exception->getMessage()]);
            return redirect()->route('stock.index', ['mis_head_id' => $request->mis_head_id]);
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
//        return $stock_head->stock;
        $mis_head = MISHeadChild_I::find( $id);
        $units = UnitType::get();
        return view('admin.mis.stock.edit', compact('mis_head', 'units'));

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
        $request->validate([
            'name' => 'required',
            'input.*.name' => 'required',
//            'input.*.unit_type_id' => 'required',
        ],[
            'name.required' => 'Please Enter Category Name',
            'input.*.name.required' => 'Please Enter Item Name',
//            'input.*.unit_type_id.required' => 'Please Select A Unit',
        ]);
//        return $request->all();
        $input = $request->input ? $request->input : [];
        $mis_head = MISHeadChild_I::find( $id);

        foreach ( $input as $key => $item) {
                $mis_head->ledger->find( $key)->update( $item);
            }

        $mis_head->update( $request->except('_token', 'input'));
        return redirect('stock?mis_head_id='.$mis_head->mis_head_id)->with('update', '<b>'. $mis_head->name.'</b> has been Updated successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $response = $this->deleteLedgerHead($request, $id);
            DB::commit();
            return $response;
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('stock.error', ['error' => $exception->getMessage()]);
            return 403;
        }

    }



}
