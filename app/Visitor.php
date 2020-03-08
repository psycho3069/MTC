<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [ 'guest_id', 'booking_id', 'name', 'contact_no', 'address', 'appearance', ];


    public function booking()
    {
        return $this->belongsTo('App\Booking');
    }




}
