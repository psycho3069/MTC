<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodSale extends Model
{
    use SoftDeletes;

    protected $table = 'r11_food_sales';

    protected $fillable = [ 'billing_id', 'date_id', 'booking_id', 'quantity', 'bill', 'discount', 'menu_id', 'vat', 'service_charge' ];


    public function billing()
    {
        return $this->belongsTo('App\Billing', 'billing_id');
    }


    public function menu()
    {
        return $this->belongsTo('App\FoodMenu', 'menu_id');
    }


    public function date()
    {
        return $this->belongsTo('App\Date');
    }




}
