<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
	protected $table = 'h8_room_bookings';

    protected $fillable = [
        'guest_name', 'guest_contact', 'amount', 'start_date', 'end_date',
        'room_id', 'status','venue_booking_id', 'mis_voucher_id',
        'designation', 'org_name',
    ];


    public function voucher()
    {
        return $this->belongsTo('App\MisVoucher', 'mis_voucher_id');
    }

}
