<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $table = 's2_units';
    protected $fillable = [ 'name', 'short_name', 'description', 'unit_type_id', 'multiply_by', ];


    public function inPurchase()
    {
        return $this->hasMany('App\Purchase');
    }

    public function inDelivery()
    {
        return $this->hasMany('App\Delivery');
    }





}
