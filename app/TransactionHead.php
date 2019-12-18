<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionHead extends Model
{
    protected $fillable = [ 'ac_head_id', 'name', 'debit', 'credit', 'amount', 'code', 'transactionable_id', 'transactionable_type' ];


    public function transactionable()
    {
        return $this->morphTo();
    }


    public function currentBalance()
    {
        return $this->hasMany('App\Process', 'thead_id');
    }


    public function accountHead()
    {
        return $this->belongsTo('App\AccountHead', 'ac_head_id');
    }

    public function tHistories()
    {
        return $this->hasMany('App\TransactionHistory', 'thead_id');
    }
}
