<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MisCurrentStock extends Model
{
    protected $fillable = [ 'stock_id', 'date_id', 'quantity', 'unit', 'amount', ];


    public function date()
    {
        return $this->belongsTo('App\Date');
    }

    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }
}
