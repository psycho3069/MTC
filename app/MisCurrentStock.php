<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MisCurrentStock extends Model
{
    protected $table = 'mis_current_stocks';
    protected $fillable = [ 'stock_id', 'date_id', 'quantity_cr', 'quantity_dr', 'unit', ];


    public function date()
    {
        return $this->belongsTo('App\Date');
    }

    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }




}
