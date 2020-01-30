<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'guest_id', 'billing_id', 'room_id', 'booking_status', 'start_date',
        'end_date', 'discount', 'no_of_visitors', 'bill', 'vat', 'service_charge',
        ];


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
