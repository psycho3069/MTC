<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MisAccountHead extends Model
{
    protected $fillable = [ 'name', 'credit_head_id', 'debit_head_id', 'type', 'default', ];


    public function creditAccount()
    {
        return $this->belongsTo('App\TransactionHead', 'credit_head_id');
    }

    public function debitAccount()
    {
        return $this->belongsTo('App\TransactionHead', 'debit_head_id');
    }

    public function voucher()
    {
        return $this->hasMany('App\MisVoucher', 'mis_ac_head_id');
    }
}
