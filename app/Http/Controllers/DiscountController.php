<?php

namespace App\Http\Controllers;

use App\Billing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscountController extends Controller
{
    //

    public function index()
    {
        $bills = Billing::orderby('id', 'desc')->get();
        foreach ($bills as $bill) {
            if ( $bill->restaurant->sum('discount') && $bill->booking->sum('discount'))
                $data['bill'][] = $bill;
        }

        return view('admin.mis.hotel.discount.index', compact('data'));
    }

}
