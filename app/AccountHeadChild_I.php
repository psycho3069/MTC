<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountHeadChild_I extends Model
{
    protected  $table = 'account_head_child_i';

    protected $fillable = ['ac_head_id', 'name', 'code', 'amount' ];



    public function parent()
    {
        return $this->belongsTo('App\AccountHead', 'ac_head_id');
    }


    public function child()
    {
        return $this->hasMany('App\AccountHeadChild_II', 'ac_head_child_i_id');
    }


    public function transaction()
    {
        return $this->morphMany('App\TransactionHead', 'transactionable');
    }




}
