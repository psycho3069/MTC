<?php

namespace App\Http\Traits;

use App\Date;
use App\MisAccountHead;
use App\MisVoucher;
use App\Process;

trait CustomTrait{

    public function computeAIS( $input, $input_date)
    {
        $date = Date::Where( 'date', $input_date )->get()->first();
        if ( empty($date) )
            $date = Date::create([ 'date' => $input_date ]);

//        return $date->vGroup;

        $mis_head = MisAccountHead::find( $input['mis_ac_head_id'] );
        $voucher = $mis_head->voucher->Where( 'date_id', $date->id )->where( 'credit_head_id', $mis_head->credit_head_id)->where( 'debit_head_id', $mis_head->debit_head_id)->first();

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
//        return $date->vGroup;
        if ( $date->vGroup->isNotEmpty())
            $slice_num = substr($date->vGroup->last()->code,-2);
        $slice_num = $slice_num +1;
//        return $slice_num;
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
