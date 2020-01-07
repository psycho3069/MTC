<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [
        'guest_id', 'mis_voucher_id', 'checkout_status',
        'total_bill', 'advance_paid', 'total_paid', 'discount', 'note', 'reserved',
        ];


    public function booking()
    {
        return $this->hasMany('App\Booking');
    }

    public function guest()
    {
        return $this->belongsTo('App\Guest');
    }


    public function payments()
    {
        return $this->hasMany('App\Payment');
    }


    public function restaurant()
    {
        return $this->hasMany('App\FoodSale', 'billing_id');
    }


    public function mis_voucher()
    {
        return $this->belongsTo('App\MisVoucher', 'mis_voucher_id');
    }

}
