<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountHeadChild_IV extends Model
{
    protected  $table = 'account_head_child_iv';

    protected $fillable = ['ac_head_child_iii_id', 'name', 'code', 'amount' ];


    public function parent()
    {
        return $this->belongsTo('App\AccountHeadChild_III', 'ac_head_child_iii_id');
    }


    public function transaction()
    {
        return $this->morphMany('App\TransactionHead', 'transactionable');
    }








}
