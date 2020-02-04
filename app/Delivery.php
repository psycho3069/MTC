<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [ 'stock_id', 'date_id', 'quantity', 'unit_id',  ];


    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }


    public function ledgerHead()
    {
        return $this->belongsTo('App\MISLedgerHead', 'stock_id');
    }


    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }


    public function date()
    {
        return $this->belongsTo('App\Date');
    }




}
