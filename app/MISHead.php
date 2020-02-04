<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MISHead extends Model
{
    protected $table = 'm1_mis_heads';
    protected $fillable = [ 'voucher_type_id', 'name', 'description', ];



}
