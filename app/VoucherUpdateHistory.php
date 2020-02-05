<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherUpdateHistory extends Model
{
    protected $fillable = [ 'voucher_id', 'amount', 'note', 'date_id', 'user_id', ];


    public function voucher()
    {
        return $this->belongsTo('App\Voucher');
    }
}
