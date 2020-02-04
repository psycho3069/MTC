<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MISVoucher_I extends Model
{
    use SoftDeletes;

    protected $table = 'm4_mis_vouchers_i';
    protected $fillable = [ 'ledger_head_id', 'date_id', 'voucher_id', ];
}
