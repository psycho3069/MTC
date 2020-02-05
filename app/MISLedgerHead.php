<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MISLedgerHead extends Model
{
    use SoftDeletes;

    protected $table = 'm3_mis_ledger_heads';

    protected $fillable = [ 'mis_head_id', 'name', 'credit_head_id', 'debit_head_id', 'code',
                            'amount', 'description', 'unit_type_id', 'ledgerable_id', 'ledgerable_type', ];


    public function ledgerable()
    {
        return $this->morphTo();
    }


    public function currentStock()
    {
        return $this->hasMany('App\MisCurrentStock', 'stock_id');
    }

    public function purchases()
    {
        return $this->hasMany('App\Purchase', 'stock_id');
    }

    public function deliveries()
    {
        return $this->hasMany('App\Delivery', 'stock_id');
    }


    public function unitType()
    {
        return $this->belongsTo('App\UnitType', 'unit_type_id');
    }


    public function misHead()
    {
        return $this->belongsTo('App\MISHead', 'mis_head_id');
    }


    public function misVouchers()
    {
        return $this->hasMany('App\MISVoucher_I', 'ledger_head_id');
    }














}
