<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [ 'name', 'date', 'value', 'text', 'software_start_date', ];


}
