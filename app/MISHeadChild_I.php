<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MISHeadChild_I extends Model
{
    use SoftDeletes;

    protected $table = 'm2_mis_head_child_i';
    protected $fillable = [ 'mis_head_id', 'name', 'description', ];


    public function ledger()
    {
        return $this->morphMany('App\MISLedgerHead', 'ledgerable');
    }







}
