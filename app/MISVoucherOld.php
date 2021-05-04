<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
 * MisVoucher -> MISVoucherOld
 * */
class MISVoucherOld extends Model
{
    protected $table = "m1_mis_vouchers";

    protected $fillable = [ 'mis_ac_head_id', 'date_id', 'credit_head_id', 'debit_head_id', 'amount', 'ais_vgroup_id', 'ais_voucher_id', ];




    public function misAccount()
    {
        return $this->belongsTo('App\MisAccountHead', 'mis_ac_head_id');
    }

    public function purchaseGroup()
    {
        return $this->hasMany('App\PurchaseGroup', 'mis_voucher_id');
    }

    public function date()
    {
        return $this->belongsTo('App\Date');
    }

    public function debitAccount()
    {
        return $this->belongsTo('App\TransactionHead', 'debit_head_id');
    }

    public function creditAccount()
    {
        return $this->belongsTo('App\TransactionHead', 'credit_head_id');
    }

    public function vGroup()
    {
        return $this->belongsTo('App\VoucherGroup', 'ais_vgroup_id');
    }

    public function voucher()
    {
        return $this->belongsTo('App\Voucher', 'ais_voucher_id');
    }








}
