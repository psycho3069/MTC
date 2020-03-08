<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public $fillable = ['name','description','parent_id'];

    /**
     * Get the index name for the model.
     *
     * @return string
    */
    public function childs() {
        return $this->hasMany('App\Role','parent_id','id') ;
    }
}