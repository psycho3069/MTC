@extends('admin.master')


@section('content')
    <div class="container">
        <div class="row">
            <div class="well col-xs-10 col-sm-10 col-md-8 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <address>
                            <strong><code>ASPADA Paribesh Unnayan Foundation</code></strong>
                            <br>
                            <code>House#193 (Flat:1st Floor), Road#01, New DOHS</code>
                            <br>
                            <code>Mohakhali, Dhaka-1206</code>
                            <br>
                            <code>Phone: +8801708559698</code>
                        </address>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                        <p>
                            <code>Date: 1st November, 2013</code>
                        </p>
                        <p>
                            <code>Receipt #: 34522677W</code>
                        </p>
                    </div>
                </div>


                <div class="row">
                    <div class="text-center">
                        <h3><code>Receipt</code></h3>
                    </div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="th-down"><code>Product</code></th>
                            <th class="th-down"><code>Quantity</code></th>
                            <th class="th-down text-center"><code>Price</code></th>
                            <th class="th-down text-center"><code>Discount</code></th>
                            <th class="th-down text-center"><code>Total</code></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $bill->booking as $item )
                            <tr>
                                <td class="bill-top col-md-7"><code>{!! $item->room_id < 50 ? 'Room No-'.$item->room->room_no : $item->venue->name !!}</code></td>
                                <td class="bill-top col-md-1" style="text-align: center"> <samp>{{ $data['days'][$item->id] }} days</samp> </td>
                                <td class="bill-top col-md-1 text-right"><samp>{{ $data['unit_price'][$item->id] }}</samp></td>
                                <td class="bill-top col-md-1 text-center"><samp>{{ $item->discount }}</samp></td>
                                <td class="bill-top col-md-1 text-right"><samp>{{ $data['room_cost'][$item->id] }}</samp></td>
                            </tr>
                        @endforeach

                        <tr>
                            <td class="bill-down"></td><td class="bill-down"></td>
                            <td class="bill-down"></td>
                            <td class="bill-down text-center">
                                <strong class="float-right"><code>Sub Total:</code></strong>
                                <strong class="float-right"><code>Advance Paid:</code></strong>
                                <strong class="float-right"><code>Discount:</code></strong>
                                <strong class="float-right"><code>Tax:</code></strong>
                            </td>
                            <td class="bill-down text-center">
                                <strong class="float-right"><samp>{{ $data['total'] }}</samp></strong>
                                <strong class="float-right"><samp>-{{ $bill->advance_paid }}</samp></strong>
                                <strong class="float-right"><samp>-{{ $bill->discount }}</samp></strong>
                                <strong class="float-right"><samp>+{{ $data['tax'] }}</samp></strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="bill-down"></td><td class="bill-down"></td><td class="bill-down"></td>
                            <td class="bill-down text-right"><b><code>Total:</code></b></td>
                            <td class="bill-down text-right"><b><samp>{{ $data['total'] - $bill->advance_paid - $bill->discount + $data['tax'] }}</samp></b></td>
                        </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success btn-lg btn-block">
                        Pay Now   <span class="glyphicon glyphicon-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('style')
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
@endsection

<style>
    body {
        margin-top: 20px;
    }
</style>
