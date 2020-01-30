<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'billing_id', 'amount', 'note', 'mis_voucher_id', 'payment_type', ];


    public function mis_voucher()
    {
        return $this->belongsTo('App\MisVoucher', 'mis_voucher_id');
    }


    public function bill()
    {
        return $this->belongsTo('App\Billing', 'billing_id');
    }



}
