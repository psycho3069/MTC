<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VenueBilling extends Model
{
    protected $table = 'v4_venue_billings';

    protected $fillable = [ 'venue_booking_id', 'advanced_pay', 'total_pay', 'total_day', ];

    public function booking()
    {
        return $this->belongsTo('App\VenueBooking', 'venue_booking_id');
    }



}
