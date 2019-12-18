<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'v_group_id', 'type_id', 'date_id', 'code', 'debit_head_id', 'credit_head_id', 'amount', 'note'  ];


    public function debitAccount()
    {
        return $this->belongsTo('App\TransactionHead','debit_head_id');
    }

    public function creditAccount()
    {
        return $this->belongsTo('App\TransactionHead','credit_head_id');
    }


    public function date()
    {
        return $this->belongsTo('App\Date');
    }

    public function voucherGroup()
    {
        return $this->belongsTo('App\VoucherGroup', 'v_group_id');
    }

    public function voucherHistory()
    {
        return $this->hasMany('App\VoucherUpdateHistory' );
    }





}
