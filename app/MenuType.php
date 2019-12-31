<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuType extends Model
{
    protected $table = 'r7_menu_types';


    public function menu()
    {
        return $this->hasMany('App\Menu', 'menu_type_id');
    }


}
