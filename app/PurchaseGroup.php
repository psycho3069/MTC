<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseGroup extends Model
{
    protected $fillable = [ 'type_id', 'mis_voucher_id', 'date_id', 'user_id' ];


    public function purchases()
    {
        return $this->hasMany('App\Purchase', 'purchase_group_id');
    }

    public function date()
    {
        return $this->belongsTo('App\Date');
    }



}
