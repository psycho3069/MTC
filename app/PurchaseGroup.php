<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseGroup extends Model
{
    use SoftDeletes;


    protected $fillable = [ 'mis_head_id', 'date_id', 'user_id', 'note', ];


    public function purchases()
    {
        return $this->hasMany('App\Purchase', 'purchase_group_id');
    }



    public function date()
    {
        return $this->belongsTo('App\Date');
    }


    public function mis_voucher()
    {
        return $this->belongsTo('App\MisVoucher', 'mis_voucher_id');
    }



}
