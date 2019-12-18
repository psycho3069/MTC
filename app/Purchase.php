<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['purchase_group_id', 'stock_id', 'quantity', 'amount', 'supplier_id', 'receiver_id',  ];




}
