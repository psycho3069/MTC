<?php

namespace App\Http\Controllers;

use App\Date;
use App\Http\Requests\VoucherRequest;
use App\Http\Traits\SoftwareConfigurationTrait;
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

    use SoftwareConfigurationTrait, VoucherTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data['types'] = VoucherType::whereNotIn('id', [5,6,7,8,9])->get();
        $data['v_group'] = VoucherGroup::orderBy('id', 'desc')->get();
        $softwareDate = $this->getSoftwareDate();

        return view('admin.ais.voucher.index', compact('data', 'softwareDate'));
    }



    public function list(Request $request)
    {
        $input = $request->all();
        $input['start_date'] = $request->start_date;
        $input['end_date'] = $request->end_date;

        $voucherTypes = VoucherType::whereNotIn('id', [5,6,7,8,9])->get();
        $dates = Date::whereBetween('date', [$input['start_date'], $input['end_date']])
            ->orderBy('id')
            ->get();

        $query = VoucherGroup::query();
        $query->whereIn('voucher_groups.date_id', $dates->pluck('id'));

        if ($request->category == 1)
            $query->where('type_id', '>', 4);
        if ($request->category == 2)
            $query->where('type_id', '<', 5);
        if ($request->type_id)
            $query->where('type_id', $request->type_id);

        $query->with([
        'type' => function($query){
            $query->selectRaw('id, name');
            }, 'vouchers' => function($query){
                $query->selectRaw('v_group_id, amount');
            }, 'user' => function($query){
                $query->selectRaw('id, name');
            }]);

        $query->orderBy('date_id', 'desc');
        $voucherGroups = $query->get();

        return view('admin.ais.voucher.list', compact(
            'voucherGroups', 'voucherTypes', 'input'
        ));
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
     * Create voucher group
     * Create vouchers
     * Update Current Balance
     */

    public function store(VoucherRequest $request)
    {
        DB::beginTransaction();
        try {
            $voucherData = $request->input;
            $softwareDate = $this->getSoftwareDate();
            $voucherType = VoucherType::find($request->type_id);

            $voucherGroup = $this->createAISVoucherGroup($softwareDate, $voucherType, $request->global_note);

            /*
             * Create Voucher and for each voucher update current balance
             * of Debit and Credit account
             * */
            foreach ($voucherData as $data) {
                $voucher = $this->createAISVoucher($voucherGroup, $data);
                $this->saveCurrentBalance($voucher, $voucher->amount, 0);
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
        $voucherGroup = VoucherGroup::find($id);
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

            foreach ($voucherData as $voucher_id => $newVoucher) {
                $voucher = Voucher::find($voucher_id);

                if ($newVoucher['amount'] != $voucher->amount){
                    $this->updateVoucherAmount($voucher, $newVoucher['amount'], $voucher->amount, $newVoucher['note']);
                }
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
            $voucherGroup = VoucherGroup::find($id);

            foreach ( $voucherGroup->vouchers as $voucher ) {
                $deleteNote = 'Deleted Voucher - [id: '.$voucher->id. ']';
                $this->deleteAISVoucher($voucher, $deleteNote);
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
