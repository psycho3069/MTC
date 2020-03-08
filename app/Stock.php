<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [ 'stock_head_id', 'name', 'description', 'quantity', 'unit', 'amount', ];


    public function currentStock()
    {
        return $this->hasMany('App\MisCurrentStock','stock_id');
    }


    public function stockHead()
    {
        return $this->belongsTo('App\StockHead','stock_head_id');
    }


    public function deliver()
    {
        return $this->hasMany('App\Delivery');
    }



    public function purchase()
    {
        return $this->hasMany('App\Purchase');
    }






}
