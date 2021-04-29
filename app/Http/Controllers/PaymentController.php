<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Booking;
use App\Http\Traits\BillingTrait;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\Http\Traits\VoucherTrait;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    use SoftwareConfigurationTrait, BillingTrait, VoucherTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bill_id)
    {
        $bill = Billing::find($bill_id);
        return view('admin.mis.hotel.billing.payment.index', compact('bill'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($bill_id, Request $request)
    {
        $bill = Billing::find($bill_id);
        $charge = $this->getBillingDetails($bill);

        if ( $request->co){
            return view('admin.mis.hotel.billing.payment.checkout', compact('bill'));
//            return view('admin.mis.hotel.billing.payment.test', compact('bill'));
        }

        return view('admin.mis.hotel.billing.payment.create', compact('bill', 'charge'));
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */


    public function store(Request $request, $bill_id)
    {
        DB::beginTransaction();
        try {

            $response = $this->storePayment($request, $bill_id);
            DB::commit();
            return redirect()->route('billing.show', $bill_id);
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('error.log', ['error' => $exception->getMessage()]);

            return redirect()->back();
        }

    }


    public function storePayment($request, $bill_id)
    {
        $input = $request->all();
        $bill = Billing::find( $bill_id);
        $checkoutStatus = $request->checkout_status ? $request->checkout_status : 0;

        if ( !$checkoutStatus || !$bill->checkout_status ){
            $total_paid = $this->initiatePaymentProcess($input, $bill, $checkoutStatus);

            if ($checkoutStatus){
                $bill->discount = $input['discount'];
                $bill->checkout_status = 1;
            }

            $bill->reserved = 0;
            $bill->total_paid += $total_paid;
            $bill->save();

            //if mis_voucher_id not null
            if ($bill->mis_voucher_id){
                $status['booking_status'] = $bill->checkout_status == 1 ? Booking::$bookingStatus['open'] : Booking::$bookingStatus['booked'];
                $bill->booking()->update($status);
            }

            if ($checkoutStatus){
                session()->flash('success', "<b>$bill->guest->name</b> has been successfully Checked-Out");
            }
            session()->flash('success', '<b>Payment Is Successful<b/>');

            return $total_paid;
        }


        session()->flash('danger', '<b>'.$bill->guest->name.'</b> has been already Checked-Out');
        return 0;
    }




    public function initiatePaymentProcess($input, $bill, $checkoutStatus)
    {
        $total_paid = 0;
        $softwareDate = $this->getSoftwareDate();

        if ( $checkoutStatus){
            $charge = $this->getBillingDetails($bill);
            $room['amount'] = $charge['room']['total'] - $charge['room']['paid'];
            $venue['amount'] = $charge['venue']['total'] - $charge['venue']['paid'];
            $food['amount'] = $charge['food']['total'] - $charge['food']['paid'];
        }else{

            if ($input['payment_type'] == 'room'){
                $room['amount'] = $input['amount'];
            }
            if ($input['payment_type'] == 'venue'){
                $venue['amount'] = $input['amount'];
            }
            if ($input['payment_type'] == 'food'){
                $food['amount'] = $input['amount'];
            }
        }


        if ( isset( $input['discount']) && $input['discount'] != 0  ){
            $paymentData['amount'] = $input['discount'];
            $paymentData['payment_type'] = Payment::$paymentType['discount'];
            $paymentData['ledgerHead'] = $this->getDiscountAccount();

            $paymentData['billing_id'] = $bill->id;
            $paymentData['note'] = 'Gross Discount';

            $payment = $this->createPayment($paymentData, $softwareDate);
        }


        if ( isset($room['amount']) && $room['amount'] != 0  ){
            $paymentData['amount'] = $room['amount'];
            $paymentData['payment_type'] = Payment::$paymentType['room'];
            $paymentData['ledgerHead'] = $this->getRoomBookingAccount();

            $paymentData['billing_id'] = $bill->id;
            $paymentData['note'] = '';

            $payment = $this->createPayment($paymentData, $softwareDate);
            $total_paid += $payment->amount;
        }

        if ( isset($venue['amount']) && $venue['amount'] != 0 ){
            $paymentData['amount'] = $venue['amount'];
            $paymentData['payment_type'] = Payment::$paymentType['venue'];
            $paymentData['ledgerHead'] = $this->getVenueBookingAccount();

            $paymentData['billing_id'] = $bill->id;
            $paymentData['note'] = '';

            $payment = $this->createPayment($paymentData, $softwareDate);
            $total_paid += $payment->amount;
        }

        if ( isset($food['amount']) && $food['amount'] != 0 ){
            $paymentData['amount'] = $food['amount'];
            $paymentData['payment_type'] = Payment::$paymentType['food'];
            $paymentData['billing_id'] = $bill->id;
            $paymentData['note'] = '';

            $paymentData['ledgerHead'] = $this->getHotelFoodSaleAccount();
            if (!$bill->mis_voucher_id){
                $paymentData['ledgerHead'] = $this->getPersonalFoodSaleAccount();
            }

            $payment = $this->createPayment($paymentData, $softwareDate);
            $total_paid += $payment->amount;
        }

        return $total_paid;
    }




    public function createPayment($paymentData, $softwareDate)
    {
        $misVoucher = $this->createMISVoucher($paymentData['ledgerHead'], $softwareDate, $paymentData['amount']);

        $payment = new Payment();
        $payment->billing_id = $paymentData['billing_id'];
        $payment->payment_type = $paymentData['payment_type'];
        $payment->amount = $paymentData['amount'];
        $payment->note = $paymentData['note'];
        $payment->mis_voucher_id = $misVoucher->id;
        $payment->save();

        return $payment;
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
        return view('admin.mis.hotel.billing.payment.edit', compact('payment'));
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

        DB::beginTransaction();
        try {
            $payment = Payment::where('id', $id)
                ->where('billing_id', $bill_id)
                ->firstOrfail();
            if ($payment->amount != $request->amount){
                $this->updatePayment($payment, $request->amount);
                session()->flash('update', '<b>Payment Updated Successfully.</b>');
            }else{
                session()->flash('warning', '<b>Please select a different amount</b>');
            }

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'Operation unsuccessful');
            Log::channel('single')
                ->error('error.log', ['error' => $exception->getMessage()]);
        }

        return redirect($bill_id.'/payment');
    }


    public function updatePayment($payment, $newAmount)
    {
        $voucher = $payment->misVoucher->voucher;
        $note = 'Updated From MIS Partial Payment- [id: '. $payment->id. ']';
        $this->updateVoucherAmount($voucher, $newAmount, $payment->amount, $note);


        $billing = $payment->bill;
        if ($billing->mis_voucher_id == $payment->mis_voucher_id ){
            $billing->advance_paid = $newAmount;
        }
        $billing->total_paid = $billing->total_paid - $payment->amount + $newAmount;
        $billing->save();

        $payment->amount = $newAmount;
        $payment->note = request('note');
        $payment->save();

        return $payment;
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
