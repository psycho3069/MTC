<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'r8_menus';


    public function menuType()
    {
        return $this->belongsTo('App\MenuType', 'menu_type_id');
    }



}
