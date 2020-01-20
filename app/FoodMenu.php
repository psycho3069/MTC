<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodMenu extends Model
{
    protected $table = 'r9_food_menu';

    protected $fillable = [ 'menu_type_id', 'name', 'price' ];

    public function items()
    {
        return $this->hasMany('App\FoodMenuItem', 'food_menu_id');
    }
}
