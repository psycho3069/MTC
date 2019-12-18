<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherGroup extends Model
{
    protected $fillable = [ 'date_id', 'type_id', 'user_id', 'note', 'code', 'amount', ];


    public function type()
    {
        return $this->belongsTo('App\VoucherType');
    }


    public function vouchers()
    {
        return $this->hasMany('App\Voucher', 'v_group_id');
    }


    public function date()
    {
        return $this->belongsTo('App\Date');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }






}
