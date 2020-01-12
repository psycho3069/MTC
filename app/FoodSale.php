<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodSale extends Model
{
    protected $fillable = [ 'billing_id', 'booking_id', 'quantity', 'bill', 'discount', 'menu_id', 'vat', ];


    public function billing()
    {
        return $this->belongsTo('App\Billing', 'billing_id');
    }


    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }




}
