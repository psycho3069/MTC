<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodMenuItem extends Model
{
    protected $table = 'r10_food_menu_items';

    protected $fillable = [ 'food_menu_id', 'meal_item_id', 'quantity', ];


    public function meal()
    {
        return $this->belongsTo('App\MealItem', 'meal_item_id');
    }
}
