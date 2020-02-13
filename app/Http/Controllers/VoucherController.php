<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Date;
use App\Http\Traits\CustomTrait;
use App\MisVoucher;
use App\Process;
use App\TransactionHead;
use App\Voucher;
use App\VoucherGroup;
use App\VoucherType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use NumberFormatter;
use function GuzzleHttp\Promise\all;

class VoucherController extends Controller
{

    use CustomTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data['types'] = VoucherType::all()->except([5,6,7,8,9]);
        $data['v_group'] = VoucherGroup::orderBy('id', 'desc')->get();

        return view('admin.ais.voucher.index', compact('data' ));
//        return view('admin.ais.voucher.test', compact('data' ));
    }



    public function list(Request $request)
    {
        $input = $request->all();

        $input['start_date'] = date('Y-m-d', strtotime( $request->start_date));
        $input['end_date'] = date('Y-m-d', strtotime( $request->end_date));

        $data['types'] = VoucherType::all()->except([5,6,7,8,9]);
        $dates =Date::whereBetween('date', [$input['start_date'], $input['end_date']])->orderBy('id')->get();

        $data['v_group'] = VoucherGroup::whereIn('date_id', $dates->pluck('id'))->orderBy('date_id', 'desc')->get();
        if ($request->category == 1)
            $data['v_group'] = $data['v_group']->where('type_id', '>', 4);
        if ( $request->category == 2)
            $data['v_group'] = $data['v_group']->where('type_id', '<', 4);
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
        $data['date'] = Configuration::find(1)->software_start_date;
        $data['type'] = VoucherType::find( $request->type_id);
        $account = $this->getAccounts( $request->type_id);
        return view('admin.ais.voucher.create', compact('data', 'account' ));
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
            'input.*.amount' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
        ], [
            'input.*.amount.required' => 'Please Enter Amount',
            'input.*.amount.regex' => 'Invalid Amount. Only decimal values are allowed',
        ]);


        $vouchers = $request->input;
        $content['user_id'] = auth()->user()->id;
        $content['note'] = $request->global_note;
        $content['type_id'] = $request->type_id;
        $type = VoucherType::find($request->type_id)->short_name;
        $date = Date::where( 'date', $request->date )->get()->first();

        if ( empty($date) )
            $date = Date::create([ 'date' => $request->date ]);

        $slice_num = 0;
        $slice_date = date('-y-m-', strtotime($date->date));
        if ( $date->vGroup->isNotEmpty())
            $slice_num = substr($date->vGroup->last()->code,-2);

        $slice_num = $slice_num +1;
        $code =  str_pad($slice_num,2, '0', STR_PAD_LEFT);

        $content['code'] = strtoupper($type).$slice_date.$code;;

        $v_group = $date->vGroup()->create( $content);

        foreach ($vouchers as $voucher) {
//            $slice_num = $slice_num +1;
//            $code =  str_pad($slice_num,2, '0', STR_PAD_LEFT);

            $voucher['date_id'] = $date->id;
//            $voucher['code'] = strtoupper($v_group->type->short_name).$slice_date.$code;
            $v_group->vouchers()->create( $voucher );
            $all_bl = Process::all();

            $credit_ac = $all_bl->where('thead_id', $voucher['credit_head_id'] )->where('date_id', $date->id)->first();
            $debit_ac = $all_bl->where('thead_id', $voucher['debit_head_id'] )->where('date_id', $date->id)->first();

            if ( $credit_ac)
                $credit_ac->update([ 'credit' => $credit_ac->credit + $voucher['amount'], ]);
            else
                $date->currentBalance()->create([ 'thead_id' => $voucher['credit_head_id'], 'credit' => $voucher['amount'] ]);
            if ( $debit_ac)
                $debit_ac->update([ 'debit' => $debit_ac->debit + $voucher['amount'], ]);
            else
                $date->currentBalance()->create([ 'thead_id' => $voucher['debit_head_id'], 'debit' => $voucher['amount'] ]);
        }

        return redirect('vouchers');

    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $v_group = VoucherGroup::find($id);
        $vouchers = $v_group->vouchers;

        foreach ( $vouchers as $item) {

            if ( !isset( $data[$item->debit_head_id] ['debit']) )
                $data[$item->debit_head_id] ['debit'] = 0;

            if ( !isset( $data[$item->credit_head_id] ['credit']) )
                $data[$item->credit_head_id] ['credit'] = 0;

            $data[$item->debit_head_id] ['name'] = $item->debitAccount->name;
            $data[$item->debit_head_id] ['code'] = $item->debitAccount->code;
            $data[$item->credit_head_id] ['name'] = $item->creditAccount->name;
            $data[$item->credit_head_id] ['code'] = $item->creditAccount->code;

            $data[$item->debit_head_id] ['debit'] += $item->amount;
            $data[$item->credit_head_id] ['credit'] += $item->amount;

        }

//        return $data;
        $x =  new NumberFormatter( 'en', NumberFormatter::SPELLOUT);
        $info['total']['amount'] = $vouchers->sum('amount');
        $info['total']['words'] = $x->format($vouchers->sum('amount'));
        $info['v_date'] = $v_group->date->date;
        $info['v_type'] = $v_group->type->name;
        $info['v_code'] = $v_group->code;

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
        $v_group = VoucherGroup::find( $id);
        return view('admin.ais.voucher.edit', compact('v_group'));

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
            'voucher.*.amount' => 'required|regex:/^[0-9]*\.?[0-9]+$/',
        ], [
            'voucher.*.amount.required' => 'Please Enter Amount',
            'voucher.*.amount.regex' => 'Invalid Amount. Only decimal values are allowed',
        ]);


        $date = $this->getDate();

        $input = $request->voucher;

        foreach ($input as $key => $item ) {
            $voucher = Voucher::find($key);
            $amount = $item['amount'] - $voucher->amount;
            $credit_ac = Process::Where( 'thead_id', $voucher->credit_head_id )->where('date_id', $voucher->date_id)->first();
            $debit_ac = Process::Where( 'thead_id', $voucher->debit_head_id )->where('date_id', $voucher->date_id)->first();

            $credit_ac->update([ 'credit' => $credit_ac->credit + $amount ]);
            $debit_ac->update([ 'debit' => $debit_ac->debit + $amount ]);

            $voucher->voucherHistory()->create([
                'amount' => $voucher->amount,
                'note' => $voucher->note,
                'date_id' => $date->id,
                'user_id' => auth()->user()->id,
            ]);


            $voucher->update( $item );
        }

        return redirect('vouchers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $v_group = VoucherGroup::find( $id);

        foreach ( $v_group->vouchers as $voucher ) {
            $data['new_amount'] = 0; $data['note'] = 'Deleted Voucher - [id: '.$voucher->id. ']';
            $this->deleteVoucher( $voucher, $data);
        }

        $v_group->delete();
        session()->flash('success', '<b>Voucher Has Been Deleted Successfully.</b>');
    }


    public function getAccounts($type_id)
    {
        $code = [1751,1802,1803,1804,1805,1806,1807,1808,1872,1873,1874,1880,1899];

        if ( $type_id == 1 ){
            $account['credit'] = TransactionHead::whereIn( 'code', $code )->get();
            $account['debit'] = TransactionHead::whereNotIn( 'code', $code )->get();
        }elseif ( $type_id == 2 ){
            $account['credit'] = TransactionHead::whereNotIn( 'code', $code )->get();
            $account['debit'] = TransactionHead::whereIn( 'code', $code )->get();
        }elseif ( $type_id == 3){
            $account['credit'] = TransactionHead::whereNotIn( 'code', $code )->get();
            $account['debit'] = $account['credit'];
        }elseif ( $type_id == 4){
            $account['credit'] = TransactionHead::whereIn( 'code', $code )->get();
            $account['debit'] = $account['credit'];
        }

        return $account;
    }
}
