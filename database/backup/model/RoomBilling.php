<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomBilling extends Model
{
	protected $table = 'h9_room_billings';
    protected $fillable = [ 'booking_id', 'advance_pay', 'total_pay', 'total_day' ];

    public function booking()
    {
        return $this->belongsTo('App\RoomBooking', 'booking_id');
    }
}
