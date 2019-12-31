<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'guest_id', 'billing_id', 'room_id', 'booking_status', 'start_date',
        'end_date', 'discount', 'no_of_visitors', 'bill', 'vat', ];


    public function room()
    {
        return $this->belongsTo('App\Room');
    }



    public function venue()
    {
        return $this->belongsTo('App\Venue', 'room_id');
    }


    public function visitors()
    {
        return $this->hasMany('App\Visitor');
    }








}
