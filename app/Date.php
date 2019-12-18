<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $fillable = [ 'process_id', 'date', 'status' ];


    public function vGroup()
    {
        return $this->hasMany('App\VoucherGroup');
    }

    public function vouchers()
    {
        return $this->hasMany('App\Voucher');
    }

    public function currentBalance()
    {
        return $this->hasMany('App\Process');
    }


    public function misStock()
    {
        return $this->hasMany('App\MisCurrentStock');
    }




}
