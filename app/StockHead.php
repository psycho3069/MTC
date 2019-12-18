<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockHead extends Model
{
    protected $fillable = [ 'category', 'type_id', 'name', 'description', 'amount', ];


    public function stock()
    {
        return $this->hasMany('App\Stock', 'stock_head_id');
    }

    public function type()
    {
        return $this->belongsTo('App\MisAccountHead', 'type_id');
    }

}
