<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountHeadChild_II extends Model
{
    protected  $table = 'account_head_child_ii';

    protected $fillable = ['ac_head_child_i_id', 'name', 'code', 'amount' ];



    public function parent()
    {
        return $this->belongsTo('App\AccountHeadChild_I', 'ac_head_child_i_id');
    }


    public function child()
    {
        return $this->hasMany('App\AccountHeadChild_III', 'ac_head_child_ii_id');
    }

    public function transaction()
    {
        return $this->morphMany('App\TransactionHead', 'transactionable');
    }


}
