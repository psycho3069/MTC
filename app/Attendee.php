<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $fillable = [ 'guest_id', 'booking_id', 'name',
        'contact_no', 'address', 'appearance', ];
}
