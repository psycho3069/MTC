<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'billing_id', 'amount', 'note', 'mis_voucher_id', 'payment_type', ];



    public static $paymentType = [
        'room' => 'room',
        'venue' => 'venue',
        'food' => 'food',
        'discount' => 'discount',
    ];


    public function misVoucher()
    {
        return $this->belongsTo('App\MISVoucher_I', 'mis_voucher_id');
    }


    public function bill()
    {
        return $this->belongsTo('App\Billing', 'billing_id');
    }



}
