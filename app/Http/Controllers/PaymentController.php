<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Configuration;
use App\Http\Traits\CustomTrait;
use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use CustomTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bill_id)
    {
        $bill = Billing::find( $bill_id);
        return view('admin.mis.hotel.billing.payment.index', compact('bill'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($bill_id, Request $request)
    {
//        return $request->all();
        $bill = Billing::find($bill_id);
        if ( $request->co)
            return view('admin.mis.hotel.billing.payment.checkout', compact('bill'));

        return view('admin.mis.hotel.billing.payment.create', compact('bill'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $bill_id)
    {
//        return $request->all();
        $input = $request->all();
        $bill = Billing::find($bill_id);
        if ( $request->co ){
            $input['amount'] = $bill->total_bill - $bill->total_paid + $bill->discount - $input['discount'];
            $bill->total_bill += $bill->discount - $input['discount'];
            $bill->discount = $input['discount'];
            $bill->checkout_status = 1;
        }
        $bill->total_paid += $input['amount'];
        $bill->save();

        $data['mis_ac_head_id'] = 1;
        $data['type'] = 'hotel_rv';
        $data['amount'] = $input['amount'];
        $date = Configuration::find(1)->software_start_date;

        $voucher = $this->computeAIS( $data, $date);
        $input['mis_voucher_id'] = $voucher->id;
        $bill->payments()->create( $input);

        return redirect('billing/'.$bill->id);

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
    public function edit($bill_id, $id)
    {
        $payment = Payment::find($id);
        $data['due'] = $payment->bill->total_bill - $payment->bill->total_paid;

        return view('admin.mis.hotel.billing.payment.edit', compact('payment', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bill_id, $id)
    {
        $input = $request->except('_token', '_method');
        $payment = Payment::find($id);

        $data['note'] = 'Updated From MIS Partial Payment';
        $this->updateAIS( $payment, $input['amount'], $data);
        $payment->bill->total_paid = $payment->bill->total_paid - $payment->amount + $input['amount'];
        $payment->bill->save();
        $payment->update( $input);
        return redirect($bill_id.'/payment');
//        return $payment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
