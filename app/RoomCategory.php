<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    protected $table = 'h5_room_categories';

    protected $fillable = [ 'name', 'price', 'vat', 'description', 'image' ];
}
