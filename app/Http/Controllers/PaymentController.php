<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Configuration;
use App\Http\Traits\CustomTrait;
use App\MISHead;
use App\MISLedgerHead;
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
        $charge = $this->getBillDetails($bill);

        if ( $request->co)
            return view('admin.mis.hotel.billing.payment.checkout', compact('bill'));
//            return view('admin.mis.hotel.billing.payment.test', compact('bill'));

        return view('admin.mis.hotel.billing.payment.create', compact('bill', 'charge'));


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
        $input = $request->except('_token');
        $input['co'] = $request->co ? $request->co : 0;

        $bill = Billing::find( $bill_id);

        if ( $input['co'] != true || $bill->checkout_status != true ){
            $total_paid = $this->getPayment( $input, $bill);

            if ( $input['co'] || $request->checkout_status)
                $bill->checkout_status = 1;

            if ( $input['co'])
                $bill->discount = $input['discount'];

            $bill->reserved = 0;
            $bill->total_paid += $total_paid;
            $bill->save();
            $bill->booking()->update(['booking_status' => 2]);


            if ( $input['co'])
                return redirect('billing/'.$bill->id)->with('success', '<b>'.$bill->guest->name.'</b> has been successfully Checked-Out');

            return  redirect('billing/'.$bill->id)->with('success', '<b>Payment Is Successful<b/>');
        }

        return redirect('billing/'.$bill->id)->with('danger', '<b>'.$bill->guest->name.'</b> has been already Checked-Out');

    }


    public function getPayment($input, $bill)
    {
//        return $input;

        $total_paid = 0;

        $mis_heads = MISHead::all();

        if ( $input['co']){
            $charge = $this->getBillDetails($bill);

            $room['amount'] = $charge['room']['total'] - $charge['room']['paid'];
            $venue['amount'] = $charge['venue']['total'] - $charge['venue']['paid'];
            $food['amount'] = $charge['food']['total'] - $charge['food']['paid'];

            $discount['amount'] = $input['discount'];
            $discount['ledger'] = $mis_heads->find(6)->ledger->first();
            $discount['payment_type'] = 'discount';
            $discount['note'] = 'Gross Discount';

//            $key = $charge['all']['max'];
//            $$key['amount'] = $charge[$key]['total'] - $charge[$key]['paid'] - $input['discount'];        /*If u ever see this pls don't get mad at me. I had to do it :(*/

        } else{

            if ( $input['payment_type'] == 'room')
                $room['amount'] = $input['amount'];

            if ( $input['payment_type'] == 'venue')
                $venue['amount'] = $input['amount'];

            if ( $input['payment_type'] == 'food')
                $food['amount'] = $input['amount'];
        }


        if ( isset( $discount['amount']) && $discount['amount'] != 0  )
            $this->ais( $discount, $bill);
//            $this->computeAIS( $discount['ledger'], $discount['amount']);

        if ( isset( $room['amount']) && $room['amount'] != 0  ){
            $room['ledger'] = $mis_heads->find(1)->ledger->first();
            $room['payment_type'] = 'room';
            $total_paid += $this->ais( $room, $bill);
        }

        if ( isset( $venue['amount']) && $venue['amount'] != 0  ){
            $venue['ledger'] = $mis_heads->find(2)->ledger->first();
            $venue['payment_type'] = 'venue';
            $total_paid += $this->ais( $venue, $bill);
        }

        if ( isset( $food['amount']) && $food['amount'] != 0 ){
            $food['ledger'] = $mis_heads->find(3)->ledger->first();
            $food['payment_type'] = 'food';
            $total_paid += $this->ais( $food, $bill);
        }

        return $total_paid;
    }



    public function ais( $data, $bill) /*data[ledger], data[amount], data[payment_type]*/
    {
        $data['mis_voucher_id'] = $this->computeAIS( $data['ledger'], $data['amount']);
        $bill->payments()->create( $data);
        return $data['amount'];
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
        $bill = Billing::find( $bill_id);
        $payment = $bill->payments->find($id);
        $adv_payment = $bill->payments->sortBy('id')[0];


        //updating AIS
        $data['note'] = 'Updated From MIS Partial Payment- [id: '. $payment->id. ']';
        $data['new_amount'] = $request->amount;
        $voucher = $payment->misVoucher->voucher;

        if ( $payment->amount != $data['new_amount'])
            $this->updateAIS( $voucher, $data);

        if ( $adv_payment->id == $payment->id )
            $bill->advance_paid = $data['new_amount'];

        $bill->total_paid = $bill->total_paid - $payment->amount + $data['new_amount'];
        $bill->save();
        $payment->update( $input);
        return redirect($bill_id.'/payment')->with('update', '<b>Payment Updated Successfully.</b>');
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
