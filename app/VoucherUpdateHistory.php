<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherUpdateHistory extends Model
{
    protected $fillable = [ 'voucher_id', 'amount', 'note', ];


    public function voucher()
    {
        return $this->belongsTo('App\Voucher');
    }
}
