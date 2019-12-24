<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [ 'guest_id', 'checking_status', 'total_bill',
        'advance_paid', 'total_paid', 'vat', 'discount', 'dis_type',
        ];


    public function booking()
    {
        return $this->hasMany('App\Booking');
    }

    public function guest()
    {
        return $this->belongsTo('App\Guest');
    }

}
