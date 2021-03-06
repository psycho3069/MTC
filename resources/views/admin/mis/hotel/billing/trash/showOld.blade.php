@extends('admin.master')


@section('content')
    <div class="container text-left">
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
                            <code>Date: {{ date('jS F, Y') }}</code>

                        </p>
                        <p>
                            <code>Receipt #: 34522677W</code>
                        </p>
                    </div>
                </div>

                <div class="text-center receipt">
                    <h3><code>Receipt</code></h3>
                </div>

                <div class="row">
                    <h4><code>Room</code></h4>

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="th-down"><code>Date</code></th>
                            <th class="th-down"><code>Room</code></th>
                            <th class="th-down"><code>Total Days</code></th>
                            <th class="th-down text-center"><code>Price</code></th>
                            <th class="th-down text-center"><code>Discount</code></th>
                            <th class="th-down text-center"><code>Total</code></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $bill->booking as $item )
                            <tr>
                                <td class="bill-top col-md-5"><code>{{ date('d M, Y', strtotime($item->created_at)) }}</code></td>
                                <td class="bill-top col-md-2 no-wrap"><samp>{{ $booking[$item->id]['room_no'] }}</samp></td>
                                <td class="bill-top col-md-1" style="text-align: center"> <samp>{{ $booking[$item->id]['days'] }} days</samp> </td>
                                <td class="bill-top col-md-1 text-right no-wrap"><samp>{{ $booking[$item->id]['unit_price'].' tk.' }}</samp></td>
                                <td class="bill-top col-md-1 text-center"><samp>{{ $item->discount }}</samp></td>
                                <td class="bill-top col-md-1 text-right"><samp>{{ $item->bill }}</samp></td>
                            </tr>
                        @endforeach

                        <tr>
                            <td class="bill-down"></td><td class="bill-down"></td><td class="bill-down"></td>
                            <td class="bill-down"></td>
                            <td class="bill-down">
                                <strong class="float-right"><code>Sub Total:</code></strong>
                                <strong class="float-right"><code>Vat(5%):</code></strong>
                            </td>
                            <td class="bill-down">
                                <strong class="float-right"><samp>{{ $bill->booking->sum('bill') }}</samp></strong>
                                <strong class="float-right"><samp>+{{ $booking['vat'] }}</samp></strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="bill-sub"></td><td class="bill-sub"></td><td class="bill-sub"></td><td class="bill-sub"></td>
                            <td class="bill-sub text-right"><b><code>Hotel bill:</code></b></td>
                            <td class="bill-sub text-right"><b><samp>{{ $booking['total'] }}</samp></b></td>
                        </tr>
                        </tbody>
                    </table>





                    <h4><code>Restaurant</code></h4>



                    <table class="table table-hover">
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
                            <tr>
                                <td class="bill-top col-md-5"><code>{{ date('d M, Y', strtotime($food->created_at)) }}</code></td>
                                <td class="bill-top col-md-2"> <samp>{{ $food->menu->name  }}</samp> </td>
                                <td class="bill-top col-md-1 no-wrap"><samp>{{ $food->menu->price.' tk.' }} </samp></td>
                                <td class="bill-top col-md-1 text-center"><samp>{{ $food->quantity }}</samp></td>
                                <td class="bill-top col-md-1 text-center"><samp>{{ $food->discount }}</samp></td>
                                <td class="bill-top col-md-1 text-right"><samp>{{ $food->bill }}</samp></td>
                            </tr>
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
                                <strong class="float-right"><code>Sub Total:</code></strong>
                                <strong class="float-right"><code>Vat(10%):</code></strong>
                            </td>
                            <td class="bill-down">
                                <strong class="float-right"><samp>{{ $bill->restaurant->sum('bill') }}</samp></strong>
                                <strong class="float-right"><samp>+{{ $restaurant['vat'] }}</samp></strong>
                            </td>
                        </tr>

                        <tr>
                            <td class="bill-sub"></td><td class="bill-sub"></td><td class="bill-sub"></td><td class="bill-sub"></td>
                            <td class="bill-sub text-right"><b><code>Food bill:</code></b></td>
                            <td class="bill-sub text-right"><b><samp>{{ $restaurant['total'] }}</samp></b></td>
                        </tr>
                        </tbody>
                    </table>


                    @if( !$bill->checkout_status)
                        <button type="button" class="btn {{ $bill->reserved ? 'btn-success' : 'btn-info' }} btn-lg btn-block" onclick='window.location="{{ $bill->reserved ? route('payment.create', [$bill->id, 'res' => 1]) : route('payment.create', [$bill->id, 'co' => 1]) }}"'>
                            {{ $bill->reserved ? 'Book Now' : 'Checkout' }}
                        </button>
                    @endif

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
