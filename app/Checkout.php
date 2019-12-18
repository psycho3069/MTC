<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $table = 'checkout';

    protected $fillable = ['h_start_date', 'h_end_date', 'name', 'contact', 'room_no', 'room_unit_price', 'h_total_day', 'h_total_bill', 'v_start_date', 'v_end_date', 'venue_no', 'v_unit_price', 'v_total_day', 'v_total_bill', 'r_total_bill', 'venue_booking_id', 'room_booking_id', 'all_total', 'discount', 'grand_total'];
}
