@extends('admin.master')


@section('content')
    <div class="container text-left">
        <div class="row">
            <div class="well col-xs-10 col-sm-10 col-md-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-1">
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
                            <code>Date: {{ date('jS F, Y', strtotime( $data['date']->date)) }}</code>
                        </p>
                        <p>
                            <code>Receipt #: {{ $bill->code }}</code>
                        </p>
                    </div>
                </div>


                <div class="row">
                    <div class="text-center">
                        <h3><code>Receipt</code></h3>
                    </div>

                    <table class="table table-hover" style="table-layout: auto !important;">
                        <thead>
                        <tr>
                            <th class="th-down"><code>Date</code></th>
                            <th class="th-down"><code>Item</code></th>
                            <th class="th-down"><code>Price</code></th>
                            <th class="th-down text-center"><code>Quantity</code></th>
                            <th class="th-down text-center"><code>Discount</code></th>
                            <th class="th-down text-center"><code>Total</code></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $bill->restaurant as $food )
                            @if( $food->bill != 0 )
                                <tr>
                                    <td class="bill-top col-md-5"><code>{{ date('d-m-Y', strtotime( $food->date->date)) }}</code></td>
                                    <td class="bill-top col-md-2"> <samp>{{ $food->menu->name  }}</samp> </td>
                                    <td class="bill-top col-md-1" style="white-space: nowrap"><samp>{{ $food->menu->price.' tk.' }} </samp></td>
                                    <td class="bill-top col-md-1 text-center"><samp>{{ $food->quantity }}</samp></td>
                                    <td class="bill-top col-md-1 text-center"><samp>{{ $food->discount }}</samp></td>
                                    <td class="bill-top col-md-1 text-right"><samp>{{ $food->bill }}</samp></td>
                                </tr>
                            @endif
                        @endforeach

                        @if( $bill->restaurant->isEmpty())
                            <tr>
                                <td class="bill-top col-md-5"><code>Null</code></td>
                                <td class="bill-top col-md-3"> <samp>Null</samp> </td>
                                <td class="bill-top col-md-1" style="white-space: nowrap"><samp>Null </samp></td>
                                <td class="bill-top col-md-1 text-center"><samp>Null</samp></td>
                                <td class="bill-top col-md-1 text-center"><samp>Null</samp></td>
                                <td class="bill-top col-md-1 text-right"><samp>Null</samp></td>
                            </tr>
                        @endif

                        <tr>
                            <td class="bill-down"></td><td class="bill-down"></td>
                            <td class="bill-down"></td><td class="bill-down"></td>
                            <td class="bill-down">
                                <strong class="float-right"><code>Sub Total:</code></strong><br>
                                <strong class="float-right"><code>Vat({{ $data['vat']['%'] }}%):</code></strong><br>
                                <strong class="float-right"><code>Service Charge({{ $data['service']['%'] }}%):</code></strong><br>
                            </td>
                            <td class="bill-down">
                                <strong class="float-right"><samp>{{ $bill->restaurant->sum('bill') }}</samp></strong><br>
                                <strong class="float-right"><samp>+{{ $data['vat']['total'] }}</samp></strong><br>
                                <strong class="float-right"><samp>+{{ $data['service']['total'] }}</samp></strong>
                            </td>
                        </tr>

                        <tr>
                            <td class="bill-sub"></td><td class="bill-sub"></td><td class="bill-sub"></td><td class="bill-sub"></td>
                            <td class="bill-sub text-right"><b><code>Food bill:</code></b></td>
                            <td class="bill-sub text-right"><b><samp>{{ $data['total'] }}</samp></b></td>
                        </tr>
                        </tbody>
                    </table>
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
