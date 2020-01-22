<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodSale extends Model
{
    protected $table = 'r11_food_sales';

    protected $fillable = [ 'billing_id', 'booking_id', 'quantity', 'bill', 'discount', 'menu_id', 'vat', 'service_charge' ];


    public function billing()
    {
        return $this->belongsTo('App\Billing', 'billing_id');
    }


    public function menu()
    {
        return $this->belongsTo('App\FoodMenu', 'menu_id');
    }




}
