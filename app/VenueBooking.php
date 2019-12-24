<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VenueBooking extends Model
{
    protected $table = 'v3_venue_bookings';

    protected $fillable = [
        'name', 'contact_no', 'start_date', 'end_date', 'venue_id',
        'no_of_attendee', 'amount', 'status', 'room_booking_id', 'mis_voucher_id',
        'designation', 'org_name',
    ];

    public function voucher()
    {
        return $this->belongsTo('App\MisVoucher', 'mis_voucher_id');
    }

}
