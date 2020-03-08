<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'h6_rooms';

    protected $fillable = [ 'room_no', 'price', 'floor_id', 'persons_capacity',
        'category_id', 'description', 'image',
        ];


    public function roomCat()
    {
        return $this->belongsTo('App\RoomCategory', 'category_id');
    }

}
