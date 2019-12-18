<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountHead extends Model
{
    protected  $fillable = ['name', 'code'];


    public function child()
    {
        return $this->hasMany('App\AccountHeadChild_I', 'ac_head_id');
    }


    public function transaction()
    {
        return $this->morphMany('App\TransactionHead', 'transactionable');
    }


    public function theads()
    {
        return $this->hasMany('App\TransactionHead','ac_head_id');
    }

}
