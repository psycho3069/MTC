<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'purchase_group_id', 'stock_id', 'amount', 'unit_id', 'supplier_id',
        'receiver_id', 'mis_voucher_id', 'current_stock_id', 'date_id',
        ];


    public function ledger()
    {
        return $this->belongsTo('App\MISLedgerHead', 'stock_id');
    }


    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_id');
    }


    public function receiver()
    {
        return $this->belongsTo('App\Employee', 'receiver_id');
    }


    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }


    public function misVoucher()
    {
        return $this->belongsTo('App\MISVoucher_I', 'mis_voucher_id');
    }


    public function currentStock()
    {
        return $this->belongsTo('App\MisCurrentSTock', 'current_stock_id');
    }






}
