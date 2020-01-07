<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'purchase_group_id', 'stock_id', 'quantity_cr', 'quantity_dr',
        'amount', 'supplier_id', 'receiver_id',
        ];


    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }


    public function supplier()
    {
        return $this->belongsTo('App\Staff', 'supplier_id');
    }


    public function receiver()
    {
        return $this->belongsTo('App\Employee', 'receiver_id');
    }






}
