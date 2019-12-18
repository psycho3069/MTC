<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'r9_sales';

    protected $fillable = [ 'guest_id', 'menu_id', 'menu_type', 'quantity', 'booking_status', 'mis_voucher_id' ];

    public function voucher()
    {
        return $this->belongsTo('App\MisVoucher', 'mis_voucher_id');
    }
}
