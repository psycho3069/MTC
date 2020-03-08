<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [ 'name', 'org_name', 'designation', 'contact_no', 'appearance', 'address', ];



}
