<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'stock_id', 'date_id', 'quantity', 'unit_id', 'current_stock_id', ];


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


    public function currentStock()
    {
        return $this->belongsTo('App\MisCurrentStock', 'current_stock_id');
    }




}
