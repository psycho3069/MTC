<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [ 'name', 'date', 'value', 'text', 'software_start_date', ];

    public static $property = [
        'software_date' => 'software_date',
        'vat_food' => 'vat_food',
        'vat_service' => 'vat_service',
        'vat_others' => 'vat_others',
    ];


}
