<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'purchase_group_id', 'stock_id', 'quantity_cr', 'quantity_dr',
        'amount', 'supplier_id', 'receiver_id',
        ];




}
