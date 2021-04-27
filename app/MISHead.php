<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MISHead extends Model
{
    protected $table = 'm1_mis_heads';
    protected $fillable = [ 'voucher_type_id', 'name', 'description', 'credit_head_id', 'debit_head_id', ];

    public static $accountType = [
        'room_booking' => 'room_booking',
        'venue_booking' => 'venue_booking',
        'food_sale' => 'food_sale',
        'grocery_purchase' => 'grocery_purchase',
        'inventory_purchase' => 'inventory_purchase',
        'discount' => 'discount',
    ];

    public function voucherType()
    {
        return $this->belongsTo('App\VoucherType', 'voucher_type_id');
    }


    public function child()
    {
        return $this->hasMany('App\MISHeadChild_I', 'mis_head_id');
    }


    public function ledgerHeads()
    {
        return $this->hasMany('App\MISLedgerHead', 'mis_head_id');
    }

    public function ledger()
    {
        return $this->morphMany('App\MISLedgerHead', 'ledgerable');
    }


    public function firstAccount()
    {
        return $this->hasOne('App\MISLedgerHead', 'mis_head_id', 'id')
            ->orderBy('id', 'asc');
    }

    public function foodSaleHotel()
    {
        return $this->hasOne('App\MISLedgerHead', 'mis_head_id', 'id')
            ->orderBy('id', 'asc');
    }


    public function foodSalePersonal()
    {
        return $this->hasOne('App\MISLedgerHead', 'mis_head_id', 'id')
            ->orderBy('id', 'desc');
    }








}
