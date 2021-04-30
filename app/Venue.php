<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $table = 'v1_venues';

    protected $fillable = [ 'name', 'location', 'price', 'feature', ];



    public function getName($prefix = false)
    {
        return $this->name;
    }

}
