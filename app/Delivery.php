<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [ 'stock_id', 'date_id', 'quantity',  ];


    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }




}
