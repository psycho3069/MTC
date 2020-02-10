<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    protected $fillable = [ 'thead_id', 'date_id', 'voucher_id', 'debit', 'credit', 'amount', 'date' ];

    public function currentBalance()
    {
        return $this->hasOne('App\Process','tran_history_id');
    }


    public function voucher()
    {
        return $this->belongsTo('App\Voucher');
    }


}
