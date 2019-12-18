<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountHeadChild_III extends Model
{
    protected  $table = 'account_head_child_iii';

    protected $fillable = ['ac_head_child_ii_id', 'name', 'code', 'amount' ];



    public function parent()
    {
        return $this->belongsTo('App\AccountHeadChild_II', 'ac_head_child_ii_id');
    }


    public function child()
    {
        return $this->hasMany('App\AccountHeadChild_IV', 'ac_head_child_iii_id');
    }


    public function transaction()
    {
        return $this->morphMany('App\TransactionHead', 'transactionable');
    }

}
