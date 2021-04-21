<?php

namespace App\Http\Controllers;

use App\Date;
use App\Http\Requests\VoucherRequest;
use App\Http\Traits\SystemConfigurationTrait;
use App\Http\Traits\VoucherTrait;
use App\Voucher;
use App\VoucherGroup;
use App\VoucherType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use NumberFormatter;
use function GuzzleHttp\Promise\all;

class VoucherController extends Controller
{

    use SystemConfigurationTrait, VoucherTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data['types'] = VoucherType::whereNotIn('id', [5,6,7,8,9])->get();
        $data['v_group'] = VoucherGroup::orderBy('id', 'desc')->get();

        return view('admin.ais.voucher.index', compact('data' ));
//        return view('admin.ais.voucher.test', compact('data' ));
    }



    public function list(Request $request)
    {
        $input = $request->all();

        $input['start_date'] = date('Y-m-d', strtotime( $request->start_date));
        $input['end_date'] = date('Y-m-d', strtotime( $request->end_date));

        $data['types'] = VoucherType::whereNotIn('id', [5,6,7,8,9])->get();
        $dates = Date::whereBetween('date', [$input['start_date'], $input['end_date']])->orderBy('id')->get();

        $data['v_group'] = VoucherGroup::whereIn('date_id', $dates->pluck('id'))->orderBy('date_id', 'desc')->get();
        if ($request->category == 1)
            $data['v_group'] = $data['v_group']->where('type_id', '>', 4);
        if ($request->category == 2)
            $data['v_group'] = $data['v_group']->where('type_id', '<', 5);
        if ($request->type_id)
            $data['v_group'] = $data['v_group']->where('type_id', $request->type_id);

//        return $input;

        return view('admin.ais.voucher.list', compact('data', 'input'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create(Request $request)
    {
        $type = VoucherType::find($request->type_id);
        $softwareDate = $this->getSoftwareDate();
        $account = $this->getVoucherAccounts($request->type_id);

        return view('admin.ais.voucher.create', compact('softwareDate','type', 'account' ));
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(VoucherRequest $request)
    {
        DB::beginTransaction();
        try {
            $voucherData = $request->input;
            $softwareDate = $this->getSoftwareDate();
            $voucherType = VoucherType::findOrFail($request->type_id);

            $voucherGroup = new VoucherGroup();
            $voucherGroup->date_id = $softwareDate->id;
            $voucherGroup->user_id = auth()->id();
            $voucherGroup->type_id = $voucherType->id;
            $voucherGroup->note = $request->global_note;
            $voucherGroup->code = $this->generateVoucherCode($softwareDate, $voucherType);
            $voucherGroup->save();

            foreach ($voucherData as $input) {
                $voucher = new Voucher();
                $voucher->v_group_id = $voucherGroup->id;
                $voucher->date_id = $softwareDate->id;
                $voucher->credit_head_id = $input['credit_head_id'];
                $voucher->debit_head_id = $input['debit_head_id'];
                $voucher->amount = $input['amount'];
                $voucher->note = $input['note'];
                $voucher->save();

                /*
                 * Update current balance for Debit and Credit account
                 * */
                $this->saveCurrentBalance($voucher, $softwareDate);
            }

            session()->flash('success', 'Operation successful');
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('voucher.error', ['error' => $exception->getMessage()]);
        }


        return redirect()->route('vouchers.index');
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $voucherGroup = VoucherGroup::findOrFail($id);
        $vouchers = $voucherGroup->vouchers;
        $data = [];
        foreach ( $vouchers as $item) {
            if ( !isset( $data[$item->debit_head_id] ['debit']) ){
                $data[$item->debit_head_id] ['debit'] = 0;
            }
            if ( !isset( $data[$item->credit_head_id] ['credit']) ){
                $data[$item->credit_head_id] ['credit'] = 0;
            }

            $data[$item->debit_head_id] ['name'] = $item->debitAccount->name;
            $data[$item->debit_head_id] ['code'] = $item->debitAccount->code;
            $data[$item->credit_head_id] ['name'] = $item->creditAccount->name;
            $data[$item->credit_head_id] ['code'] = $item->creditAccount->code;

            $data[$item->debit_head_id] ['debit'] += $item->amount;
            $data[$item->credit_head_id] ['credit'] += $item->amount;

        }

        $x =  new NumberFormatter( 'en', NumberFormatter::SPELLOUT);
        $info['total']['amount'] = $vouchers->sum('amount');
        $info['total']['words'] = $x->format($vouchers->sum('amount'));
        $info['v_date'] = $voucherGroup->date->date;
        $info['v_type'] = $voucherGroup->type->name;
        $info['v_code'] = $voucherGroup->code;

        return view('admin.ais.voucher.show', compact( 'data', 'info'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $v_group = VoucherGroup::find($id);
        return view('admin.ais.voucher.edit', compact('v_group'));

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VoucherRequest $request, $id)
    {
        /*
         * Update current balance
         * Create update history
         * update Voucher
         * */
        DB::beginTransaction();
        try {
            $voucherData = $request->voucher;

            foreach ($voucherData as $voucher_id => $input) {
                $voucher = Voucher::findOrFail($voucher_id);

                $this->updateCurrentBalance($voucher, $voucher->amount, $input['amount']);
                $this->createVoucherHistory($voucher, $voucher->amount, $input['amount']);

                $voucher->amount = $input['amount'];
                $voucher->note = $input['note'];
                $voucher->save();
            }

            session()->flash('success', 'Operation successful');
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('voucher.error', ['error' => $exception->getMessage()]);
        }

        return redirect()->route('vouchers.index');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*
        * Update current balance
        * Create Delete history
        * delete Voucher
        * */

        DB::beginTransaction();
        try {
            $voucherGroup = VoucherGroup::findOrFail($id);

            foreach ( $voucherGroup->vouchers as $voucher ) {
                $this->updateCurrentBalance($voucher, $voucher->amount, 0);
                $this->createVoucherHistory($voucher, $voucher->amount, 0, true);
                $voucher->delete();
            }

            $voucherGroup->delete();

            session()->flash('success', 'Operation successful');
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('voucher.error', ['error' => $exception->getMessage()]);
        }

        return response()->json('voucher deleted', 200);

    }




}
