<?php

namespace App\Http\Traits;

use App\Booking;
use App\Configuration;
use App\Date;
use App\MisAccountHead;
use App\MisVoucher;
use App\Process;
use App\Room;
use App\Venue;

trait CustomTrait{


    public function checkBooking( $input)
    {
        $date = Configuration::find( 1)->software_start_date;
        $booked = Booking::where('end_date','>=', date('Y-m-d', strtotime( $date)))->get();

        $room_id = collect( $input)->pluck('room_id');
        return count( $booked->whereIn('room_id', $room_id));
    }


    public function getBillDetails( $bill)
    {
        $charge['room']['total'] = $bill->booking->where('room_id', '<', 50)->sum('bill');
        $charge['room']['total'] += $bill->booking->where('room_id', '>', 499)->sum('bill');
        $charge['venue']['total'] = $bill->booking->whereBetween('room_id', [50, 499])->sum('bill');
        $charge['food']['total'] = $bill->restaurant->sum('bill');

        $charge['room']['total'] += $charge['room']['total'] * $bill->booking[0]->vat / 100;
        $charge['venue']['total'] += $charge['venue']['total'] * $bill->booking[0]->vat / 100;
        if ( $bill->restaurant->isNotEmpty())
            $charge['food']['total'] += $charge['food']['total'] * ( $bill->restaurant[0]->vat + $bill->restaurant[0]->service_charge ) / 100;

        $charge['room']['paid'] = $bill->payments->where('payment_type', 'room')->sum('amount');
        $charge['venue']['paid'] = $bill->payments->where('payment_type', 'venue')->sum('amount');
        $charge['food']['paid'] = $bill->payments->where('payment_type', 'food')->sum('amount');

        $max = collect($charge)->sortByDesc('total')->keys()->first();


        $charge['all']['total'] = $charge['room']['total'] + $charge['venue']['total'] + $charge['food']['total'];
        $charge['all']['max'] = $max;

        return $charge;
    }

















    public function getRoomInfo( $room)
    {
//        return $room;

        $room['start_date'] = date('Y-m-d', strtotime($room['start_date']));
        $room['end_date'] = date('Y-m-d', strtotime($room['end_date']));

        $days = (strtotime( $room['end_date']) - strtotime( $room['start_date']) ) / (60 * 60 * 24);
        $days = $room['room_id'] < 50 || $room['room_id'] > 499 ? ( $days == 0 ? 1 : $days) : $days + 1;

        $room_price = $room['room_id'] < 50 || $room['room_id'] > 499 ? Room::find($room['room_id'])->price : Venue::find( $room['room_id'])->price;
        $room['discount'] = $room['discount'] * $days;
        $room['bill'] = $room_price * $days - $room['discount'];
        $room['days'] = $days;

        return $room;
    }


    public function getDate()
    {
        $conf_date = Configuration::find(1)->software_start_date;
        $date = Date::where('date', $conf_date)->first();
        if ( !$date)
            $date = $date->create([ 'date' => $conf_date]);

        return $date;
    }



    public function neutreCrBl( $voucher, $new_amount)
    {
        $credit_ac = Process::where( 'date_id', $voucher->date_id)->Where( 'thead_id', $voucher->credit_head_id )->first();
        $debit_ac = Process::where( 'date_id', $voucher->date_id)->Where( 'thead_id', $voucher->debit_head_id )->first();

        $credit_ac->update([ 'credit' => $credit_ac->credit - $voucher->amount + $new_amount ]);
        $debit_ac->update([ 'debit' => $debit_ac->debit - $voucher->amount + $new_amount ]);
    }


    public function voucherHistory( $voucher, $note)
    {
        $date = $this->getDate();
        $data['amount'] = $voucher->amount;
        $data['note'] = $note;
        $data['date_id'] = $date->id;
        $data['user_id'] = auth()->user()->id;

        $voucher->voucherHistory()->create( $data);

    }








    public function computeAIS($ledger, $amount)
    {
//        return $ledger;

        $date = $this->getDate();

        $v_type = $ledger->misHead->voucherType;
        $v_group = $date->vGroup->firstWhere( 'type_id', $v_type->id );
        if ( !$v_group){
            $input['v_group']['type_id'] = $v_type->id;
            $input['v_group']['note'] = $v_type->name. 'voucher';
            $input['v_group']['code'] = $this->voucherCode($date, $v_type->short_name);
            $input['v_group']['user_id'] = auth()->user()->id;

            $v_group = $date->vGroup()->create( $input['v_group']);
        }

        $input['voucher']['date_id'] = $date->id;
        $input['voucher']['debit_head_id'] = $ledger->debit_head_id;
        $input['voucher']['credit_head_id'] = $ledger->credit_head_id;
        $input['voucher']['amount'] = $amount;

        $voucher = $v_group->vouchers()->create( $input['voucher']);


        $all_bl = Process::all();
        $credit_ac = $all_bl->where('thead_id', $voucher->credit_head_id)->where('date_id', $date->id)->first();
        $debit_ac = $all_bl->where('thead_id', $voucher->debit_head_id)->where('date_id', $date->id)->first();

        if ( $credit_ac)
            $credit_ac->update([ 'credit' => $credit_ac->credit + $amount, ]);
        else
            $date->currentBalance()->create([ 'thead_id' => $voucher->credit_head_id, 'credit' => $amount, ]);
        if ( $debit_ac)
            $debit_ac->update([ 'debit' => $debit_ac->debit + $amount, ]);
        else
            $date->currentBalance()->create([ 'thead_id' => $voucher->debit_head_id, 'debit' => $amount, ]);


        $mis_voucher = $this->getMISVoucher($ledger, $voucher);

        return $mis_voucher->id;
    }



    public function updateAIS( $voucher, $data)    /* data[note], data[new_amount] */
    {
        $this->neutreCrBl( $voucher, $data['new_amount']);
        $this->voucherHistory( $voucher, $data['note']);
        $voucher->update([ 'amount' => $data['new_amount']]);
    }


    public function deleteVoucher( $voucher, $data) /* data[note], data[new_amount] */
    {
        $this->neutreCrBl( $voucher, $data['new_amount']);
        $this->voucherHistory( $voucher, $data['note']);
        $voucher->delete();
    }



    public function getMISVoucher($ledger, $voucher)
    {
        $data['mis_head_id'] = $ledger->mis_head_id;
        $data['date_id'] = $voucher->date_id;
        $data['voucher_id'] = $voucher->id;

        $mis_voucher = $ledger->misVouchers()->create($data);
        return $mis_voucher;

    }



    public function voucherCode($date, $short_name)
    {
        $slice_num = 0;
        $slice_date = date('-y-m-', strtotime($date->date));
        if ( $date->vGroup->isNotEmpty())
            $slice_num = substr($date->vGroup->last()->code,-2);
        $slice_num = $slice_num +1;
        $code =  str_pad($slice_num,2, '0', STR_PAD_LEFT);
        $code = $short_name.$slice_date.$code;

        return $code;
    }











































    public function computeAISOld( $input, $input_date)
    {
//        return $input;
        $date = Date::Where( 'date', $input_date )->get()->first();
        if ( empty($date) )
            $date = Date::create([ 'date' => $input_date ]);

//        return $date->vGroup;

        $mis_head = MisAccountHead::find( $input['mis_ac_head_id'] );
        $voucher = $mis_head->voucher->Where( 'date_id', $date->id )->where( 'credit_head_id', $mis_head->credit_head_id)->where( 'debit_head_id', $mis_head->debit_head_id)->first();

        //Creating only one Receipt or Payment voucher each day by ais_vgroup_id
        $type_id = ( $mis_head->id == 3) || ( $mis_head->id == 5 ) ? [3,5] : [1,2,4];
        $ais_vgroup = MisVoucher::where('date_id', $date->id)->whereIn('mis_ac_head_id', $type_id)->get()->first();

//        return $ais_vgroup ?  $ais_vgroup->ais_vgroup_id :  0;

        if ( $voucher)
            $voucher->update([ 'amount' => $voucher->amount + $input['amount']]);
        else
            $voucher = $mis_head->voucher()->create([
                'mis_ac_head_id' => $mis_head->id,
                'date_id' => $date->id,
                'credit_head_id' => $mis_head->credit_head_id,
                'debit_head_id' => $mis_head->debit_head_id,
                'amount' => $input['amount'],
                'ais_vgroup_id' => $ais_vgroup ? $ais_vgroup->ais_vgroup_id : 0,
            ]);

        $content = $this->getContent($input['type']);

        //creating Voucher in AIS section
        $this->aisVoucher($voucher, $content, $date);

        $all_bl = Process::all();
        $credit_ac = $all_bl->where('thead_id', $voucher->credit_head_id)->where('date_id', $date->id)->first();
        $debit_ac = $all_bl->where('thead_id', $voucher->debit_head_id)->where('date_id', $date->id)->first();

        if ( $credit_ac)
            $credit_ac->update([ 'credit' => $credit_ac->credit + $input['amount'], ]);
        else
            $date->currentBalance()->create([ 'thead_id' => $voucher->credit_head_id, 'credit' => $input['amount'], ]);
        if ( $debit_ac)
            $debit_ac->update([ 'debit' => $debit_ac->debit + $input['amount'], ]);
        else
            $date->currentBalance()->create([ 'thead_id' => $voucher->debit_head_id, 'debit' => $input['amount'], ]);

        return $voucher;

    }


    public function aisVoucher($mis_voucher, $content, $date)
    {
        $slice_num = 0;
        $slice_date = date('-y-m-', strtotime($date->date));
        if ( $date->vGroup->isNotEmpty())
            $slice_num = substr($date->vGroup->last()->code,-2);
        $slice_num = $slice_num +1;
        $code =  str_pad($slice_num,2, '0', STR_PAD_LEFT);
        $content['code'] = $content['short_note'].$slice_date.$code;
        $input = $mis_voucher->toArray();
//        $input['code'] = $content['code'];
        $input['date_id'] = $date->id;
        $input['note'] = $content['note'];
        $content['note'] = $mis_voucher->mis_ac_head_id == 3 || $mis_voucher->mis_ac_head_id == 5 ? 'Auto Payment Voucher' : 'Auto Receipt Voucher';

//        return $mis_voucher->voucher;
        $v_group = $mis_voucher->vGroup;
        if (!$mis_voucher->vGroup){
            $v_group = $date->vGroup()->create( $content);
            $x = $v_group->vouchers()->create( $input);
            $mis_voucher->update(['ais_vgroup_id' => $v_group->id, 'ais_voucher_id' => $x->id, ]);
        }elseif( !$mis_voucher->voucher){
            $x = $v_group->vouchers()->create( $input);
            $mis_voucher->update(['ais_voucher_id' => $x->id, ]);
        }elseif ( $mis_voucher->voucher)
            $mis_voucher->voucher->update(['amount' => $mis_voucher->amount, ]);
//            return $mis_voucher->vGroup;

    }


    public function getContent($type)
    {
        $data['user_id'] = auth()->user()->id;
        if ( $type == 'hotel_rv'){
            $data['short_note'] = 'RV';
            $data['type_id'] = 5;
            $data['note'] = 'Hotel Receipt Voucher';
        }

        if ( $type == 'venue_rv'){
            $data['short_note'] = 'RV';
            $data['type_id'] = 6;
            $data['note'] = 'Venue Receipt Voucher';
        }

        if ( $type == 'restaurant_rv'){
            $data['short_note'] = 'RV';
            $data['type_id'] = 7;
            $data['note'] = 'Restaurant Receipt Voucher';
        }

        if ( $type == 'restaurant_pv'){
            $data['short_note'] = 'PV';
            $data['type_id'] = 8;
            $data['note'] = 'Restaurant Payment Voucher';
        }

        if ( $type == 'inventory_pv'){
            $data['short_note'] = 'PV';
            $data['type_id'] = 9;
            $data['note'] = 'Inventory Payment Voucher';
        }

        return $data;
    }


    public function updateAISOld( $old_record, $amount, $data )
    {
        $credit_ac = Process::Where( 'thead_id', $old_record->mis_voucher->credit_head_id )->where('date_id', $old_record->mis_voucher->date_id)->first();
        $debit_ac = Process::Where( 'thead_id', $old_record->mis_voucher->debit_head_id )->where('date_id', $old_record->mis_voucher->date_id)->first();

        $credit_ac->update([ 'credit' => $credit_ac->credit - $amount['old'] + $amount['new'] ]);
        $debit_ac->update([ 'debit' => $debit_ac->debit - $amount['old'] + $amount['new'] ]);

        $ais_voucher = $old_record->mis_voucher->voucher;
        $data['amount'] = $ais_voucher->amount;
        $ais_voucher->voucherHistory()->create( $data);
        $ais_voucher->update([ 'amount' => $data['amount'] - $amount['old'] + $amount['new'] ]);

        $old_record->mis_voucher->update( ['amount' => $old_record->mis_voucher->amount - $amount['old'] + $amount['new'] ]);

    }


    public function updateAISBooking( $old_record, $new_amount )
    {
        $credit_ac = Process::Where( 'thead_id', $old_record->voucher->credit_head_id )->where('date_id', $old_record->voucher->date_id)->first();
        $debit_ac = Process::Where( 'thead_id', $old_record->voucher->debit_head_id )->where('date_id', $old_record->voucher->date_id)->first();

        $credit_ac->update([ 'credit' => $credit_ac->credit - $old_record->amount + $new_amount ]);
        $debit_ac->update([ 'debit' => $debit_ac->debit - $old_record->amount + $new_amount ]);
        $old_record->voucher->update( ['amount' => $old_record->voucher->amount  - $old_record->amount + $new_amount ]);

    }


    public function billingAIS( $voucher, $due_bl)
    {
        $voucher->update([ 'amount' => $voucher->amount + $due_bl]);
        $credit_ac = Process::Where( 'thead_id', $voucher->credit_head_id )->where('date_id', $voucher->date_id )->first();
        $debit_ac = Process::Where( 'thead_id', $voucher->debit_head_id )->where('date_id', $voucher->date_id)->first();

        $credit_ac->update([ 'credit' => $credit_ac->credit + $due_bl ]);
        $debit_ac->update([ 'debit' => $debit_ac->debit + $due_bl ]);

    }


    public function getBalance($thead_id, $date_id)
    {
        $balance = Process::where('date_id', '<=', $date_id)->where('thead_id', $thead_id)->get();
        $amount = $balance->first()->thead->ac_head_id == 1 || $balance->first()->thead->ac_head_id == 4 ? $balance->sum('debit') - $balance->sum('credit') : $balance->sum('credit') - $balance->sum('debit');
        return $amount;
    }










}
