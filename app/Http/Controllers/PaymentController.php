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
        $charge = $this->getBillDetails($bill);

        if ( $request->co)
            return view('admin.mis.hotel.billing.payment.checkout', compact('bill'));
//            return view('admin.mis.hotel.billing.payment.test', compact('bill'));

        return view('admin.mis.hotel.billing.payment.create', compact('bill', 'charge'));


    }





    public function checkout(Request $request, $bill_id)
    {
        $discount = $request->discount;
        $bill = Billing::find( $bill_id);

        if ( $bill->checkout_status != true){

            $room['amount'] = $bill->booking->where('room_id', '<', 50)->Where('room_id', '>', 499)->sum('bill');
            $venue['amount'] = $bill->booking->where('room_id', '>', 49)->where('room_id', '<', 500)->sum('bill');
            $food['amount'] = $bill->restaurant->sum('bill');

            if ( $room['amount'] != 0){
                $room['amount'] += $room['amount'] * 5 / 100;
                $room['mis_ac_head_id'] = 1;
                $room['type'] = 'hotel_rv';
                $note = 'Hotel Room Payment';
                $this->ais( $room, $bill, $note);
            }

            if ( $venue['amount'] != 0){
                $venue['amount'] += $venue['amount'] * 5 / 100;
                $venue['mis_ac_head_id'] = 2;
                $venue['type'] = 'venue_rv';
                $note = 'Venue Payment';
                $this->ais( $venue, $bill, $note);
            }

            if ( $food['amount'] != 0){
                $food['amount'] += $food['amount'] * 10 / 100;
                $food['mis_ac_head_id'] = 4;
                $food['type'] = 'restaurant_rv';
                $note = 'Restaurant Payment';
                $this->ais( $food, $bill, $note);
            }





            $bill->booking()->update(['booking_status' => 2]);
            $bill->total_paid = $bill->total_bill;
            $bill->reserved = 0;
            $bill->checkout_status = 1;
            $bill->save();
            return redirect('billing/'.$bill->id)->with('success', '<b>'.$bill->guest->name.'</b> has been successfully Checked-Out');
        }
        else
            return redirect('billing/'.$bill->id)->with('danger', '<b>'.$bill->guest->name.'</b> has been already Checked-Out');

    }







    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function bill(Request $request, $bill_id)
    {
//        return $request->all();

        $input = $request->except('_token');
        $input['co'] = $request->co ? $request->co : 0;

        $bill = Billing::find( $bill_id);

        if ( $bill->checkout_status != true){

            $total_paid = $this->getPayment($input, $bill);

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


//        return $input['co'] ? 55 : 44;

        $total_paid = 0;


        if ( $input['co']){
            $charge = $this->getBillDetails($bill);
            $key = $charge['all']['max'];

            $room['amount'] = $charge['room']['total'] - $charge['room']['paid'];
            $venue['amount'] = $charge['venue']['total'] - $charge['venue']['paid'];
            $food['amount'] = $charge['food']['total'] - $charge['food']['paid'];

            $$key['amount'] = $charge[$key]['total'] - $charge[$key]['paid'] - $input['discount'];        /*If u ever see this pls don't get mad at me. I had to do it :(*/

        } else{

            if ( $input['payment_type'] == 'room')
                $room['amount'] = $input['amount'];

            if ( $input['payment_type'] == 'venue')
                $venue['amount'] = $input['amount'];

            if ( $input['payment_type'] == 'food')
                $food['amount'] = $input['amount'];
        }



        if ( isset( $room['amount']) && $room['amount'] != 0  ){
            $room['mis_ac_head_id'] = 1;
            $room['type'] = 'hotel_rv';
            $input['type'] = 'room';
            $total_paid += $this->ais( $room, $bill, $input);
        }

        if ( isset( $venue['amount']) && $venue['amount'] != 0  ){
            $venue['mis_ac_head_id'] = 2;
            $venue['type'] = 'venue_rv';
            $input['type'] = 'venue';
            $total_paid += $this->ais( $venue, $bill, $input);
        }

        if ( isset( $food['amount']) && $food['amount'] != 0 ){
            $food['mis_ac_head_id'] = 4;
            $food['type'] = 'restaurant_rv';
            $input['type'] = 'food';
            $total_paid += $this->ais( $food, $bill, $input);
        }

        return $total_paid;
    }



    public function ais($data, $bill, $input)
    {
//        return $input;
        $date = Configuration::find(1)->software_start_date;
        $mis_voucher = $this->computeAIS( $data, $date);

        $input['mis_voucher_id'] = $mis_voucher->id;
        $input['amount'] = $data['amount'];
        $bill->payments()->create( $input);
        return $data['amount'];
    }








    public function store(Request $request, $bill_id)
    {
//        return $request->all();
        $input = $request->all();
        $input['checkout_status'] = $request->checkout_status ? $request->checkout_status : 0;

        $bill = Billing::find($bill_id);
        if ( $request->co ){
            $input['amount'] = $bill->total_bill - $bill->total_paid + $bill->discount - $input['discount'];
            $bill->total_bill += $bill->discount - $input['discount'];
            $bill->discount = $input['discount'];
            $bill->checkout_status = 1;
        }

        $bill->booking()->update(['booking_status' => 2]);
        if ( $request->checkout_status)
            $bill->checkout_status = 1;

        $bill->reserved = 0;
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

        //updating AIS
        $data['note'] = 'Updated From MIS Partial Payment';
        $amount['old'] = $payment->amount;
        $amount['new'] = $input['amount'];
        $this->updateAIS( $payment, $amount, $data);

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
