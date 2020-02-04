<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'purchase_group_id', 'stock_id', 'quantity_cr', 'quantity_dr',
        'amount', 'unit_id', 'supplier_id', 'receiver_id',
        ];


    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }


    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_id');
    }


    public function receiver()
    {
        return $this->belongsTo('App\Employee', 'receiver_id');
    }


    public function unit()
    {
        return $this->belongsTo('App\Unit', 'unit_id');
    }






}
