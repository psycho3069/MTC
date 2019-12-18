<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table = 'current_balance';

    protected $fillable = [ 'thead_id', 'date_id', 'debit', 'credit', 'amount', 'status', 'date' ];


    public function thead()
    {
        return $this->belongsTo('App\TransactionHead', 'thead_id');
    }

    public function date()
    {
        return $this->belongsTo('App\Date');
    }



}
