<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitType extends Model
{
    use SoftDeletes;

    protected $table = 's1_unit_types';
    protected $fillable = [ 'name', 'short_name', 'description', ];


    public function units()
    {
        return $this->hasMany('App\Unit', 'unit_type_id');
    }


    public function inLedger()
    {
        return $this->hasMany('App\MISLedgerHead', 'unit_type_id');
    }




}
