@extends('admin.master')


@section('content')
    <div class="container text-left">
        <div class="row">
            <div class="well col-xs-10 col-sm-10 col-md-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-1">
                <button type="button" class="btn btn-i" data_url="{{'export/'.$bill->id}}" onclick="print( $(this).attr('data_url')); return false;">Print</button>
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
                            <code>Date: {{ date('jS F, Y', strtotime( $data['date']->date )) }}</code>

                        </p>
                        <p>
                            <code>Receipt #: {{ $bill->code }}</code>
                        </p>
                    </div>
                </div>

                <div class="text-center receipt">

                    <address>
                        <code>
                            <strong>
                                {!!  $bill->guest->org_name ? $bill->guest->org_name.'<br>' : '' !!}
                            </strong>
                            {!!  $bill->guest->name.'<br>' !!}
                            {!!  $bill->guest->address ? $bill->guest->address.'<br>' : '' !!}
                            Phone: {!!  $bill->guest->contact_no !!}
                        </code>
                    </address>


                    <br>
                    <h3><code>Receipt</code></h3>
                </div>

                <div class="row">

                    @if( isset( $data['venue']))
                        <h4><code>Venue</code></h4>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="th-down"><code>Check-In</code></th>
                                <th class="th-down"><code>Check-Out</code></th>
                                <th class="th-down"><code>Venue</code></th>
                                <th class="th-down"><code>Total Days</code></th>
                                <th class="th-down text-center"><code>Price</code></th>
                                <th class="th-down text-center"><code>Discount</code></th>
                                <th class="th-down text-center"><code>Total</code></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach( $data['venue'] as $item )
                                <tr>
                                    <td class="bill-top col-md-2"><code>{{ date('d M, Y', strtotime( $item->start_date )) }}</code></td>
                                    <td class="bill-top col-md-3"><code>{{ date('d M, Y', strtotime( $item->end_date )) }}</code></td>
                                    <td class="bill-top col-md-2 no-wrap"><samp>{{ $booking[$item->id]['room_no'] }}</samp></td>
                                    <td class="bill-top col-md-1" style="text-align: center"> <samp>{{ $booking[$item->id]['days'] }} days</samp> </td>
                                    <td class="bill-top col-md-1 text-right no-wrap"><samp>{{ $booking[$item->id]['unit_price'].' tk.' }}</samp></td>
                                    <td class="bill-top col-md-1 text-center"><samp>{{ $item->discount }}</samp></td>
                                    <td class="bill-top col-md-1 text-right"><samp>{{ $item->bill }}</samp></td>
                                </tr>
                            @endforeach

                            <tr>
                                <td class="bill-down"></td><td class="bill-down"></td><td class="bill-down"></td>
                                <td class="bill-down"></td><td class="bill-down"></td>
                                <td class="bill-down">
                                    <strong class="float-right"><code>Sub Total:</code></strong>
                                    <strong class="float-right"><code>Vat({{ $bill->booking[0]->vat }}%):</code></strong>
                                </td>
                                <td class="bill-down">
                                    <strong class="float-right"><samp>{{ $info['venue']['total'] }}</samp></strong><br>
                                    <strong class="float-right"><samp>+{{ $info['venue']['vat'] }}</samp></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="bill-sub"></td><td class="bill-sub"></td><td class="bill-sub"></td><td class="bill-sub"></td><td class="bill-sub"></td>
                                <td class="bill-sub text-right"><b><code>Venue bill:</code></b></td>
                                <td class="bill-sub text-right"><b><samp>{{ $info['venue']['total'] + $info['venue']['vat'] }}</samp></b></td>
                            </tr>
                            </tbody>
                        </table>
                    @endif







                    @if( isset($data['room']))
                        <h4><code>Room</code></h4>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="th-down"><code>Check-In</code></th>
                                <th class="th-down"><code>Check-Out</code></th>
                                <th class="th-down"><code>Room</code></th>
                                <th class="th-down"><code>Total Days</code></th>
                                <th class="th-down text-center"><code>Price</code></th>
                                <th class="th-down text-center"><code>Discount</code></th>
                                <th class="th-down text-center"><code>Total</code></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach( $data['room'] as $item )
                                <tr>
                                    <td class="bill-top col-md-2"><code>{{ date('d M, Y', strtotime( $item->start_date)) }}</code></td>
                                    <td class="bill-top col-md-3"><code>{{ date('d M, Y', strtotime( $item->end_date)) }}</code></td>
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
                                <td class="bill-down"></td>
                                <td class="bill-down">
                                    <strong class="float-right"><code>Sub Total:</code></strong>
                                    <strong class="float-right"><code>Vat({{ $bill->booking[0]->vat }}%):</code></strong>
                                </td>
                                <td class="bill-down">
                                    <strong class="float-right"><samp>{{ $info['room']['total'] }}</samp></strong><br>
                                    <strong class="float-right"><samp>+{{ $info['room']['vat'] }}</samp></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="bill-sub"></td><td class="bill-sub"></td><td class="bill-sub"></td>
                                <td class="bill-sub"></td>
                                <td class="bill-sub"></td>
                                <td class="bill-sub text-right"><b><code>Room bill:</code></b></td>
                                <td class="bill-sub text-right"><b><samp>{{ $info['room']['total'] + $info['room']['vat'] }}</samp></b></td>
                            </tr>
                            </tbody>

                        </table>
                    @endif







                    @if( $bill->restaurant->isNotEmpty())
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
                                    <td class="bill-top col-md-5"><code>{{ date('d M, Y', strtotime( $food->date->date)) }}</code></td>
                                    <td class="bill-top col-md-2"> <samp>{{ $food->menu->name  }}</samp> </td>
                                    <td class="bill-top col-md-1 no-wrap"><samp>{{ $food->menu->price.' tk.' }} </samp></td>
                                    <td class="bill-top col-md-1 text-center"><samp>{{ $food->quantity }}</samp></td>
                                    <td class="bill-top col-md-1 text-center"><samp>{{ $food->discount }}</samp></td>
                                    <td class="bill-top col-md-1 text-right"><samp>{{ $food->bill }}</samp></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="bill-down"></td><td class="bill-down"></td>
                                <td class="bill-down"></td><td class="bill-down"></td>
                                <td class="bill-down">
                                    <strong class="float-right"><code>Sub Total:</code></strong><br>
                                    <strong class="float-right"><code>Vat({{ $restaurant['vat']['%'] }}%):</code></strong><br>
                                    <strong class="float-right"><code>Service Charge({{ $restaurant['service']['%'] }}%):</code></strong>
                                </td>
                                <td class="bill-down">
                                    <strong class="float-right"><samp>{{ $bill->restaurant->sum('bill') }}</samp></strong><br>
                                    <strong class="float-right"><samp>+{{ $restaurant['vat']['total'] }}</samp></strong><br>
                                    <strong class="float-right"><samp>+{{ $restaurant['service']['total'] }}</samp></strong>
                                </td>
                            </tr>

                            <tr>
                                <td class="bill-sub"></td><td class="bill-sub"></td><td class="bill-sub"></td><td class="bill-sub"></td>
                                <td class="bill-sub text-right"><b><code>Food bill:</code></b></td>
                                <td class="bill-sub text-right"><b><samp>{{ $restaurant['total'] }}</samp></b></td>
                            </tr>
                            </tbody>
                        </table>
                    @endif


                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="th-down"></th>
                            <th class="th-down"></th>
                            <th class="th-down"></th>
                            <th class="th-down"></th>
                            <th class="th-down"></th>
                            <th class="th-down"></th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td class="bill-top col-md-5"></td>
                            <td class="bill-top col-md-3"></td>
                            <td class="bill-top col-md-1"></td>

                            <td class="bill-top col-md-1 text-right">
                                <b><code>Advance paid: <samp>{{ $bill->advance_paid }}</samp></code></b>
                                <b><code>Discount: <samp>{{ $bill->discount }}</samp></code></b>
                            </td>

                            <td class="bill-top col-md-1 text-right">
                                <b><code>Total bill:</code></b>
                                {{--                                    <b><code>Discount:</code></b>--}}
                                <b><code>Total paid:</code></b>
                            </td>

                            <td class="bill-top col-md-1 text-right">
                                <b><samp>{{ $bill->total_bill }}</samp></b><br>
                                {{--                                    <b><samp>{{ -$bill->discount }}</samp></b><br>--}}
                                <b><samp>-{{ $bill->total_paid }}</samp></b>
                            </td>
                        </tr>

                        <tr>
                            <td><b><code>In Words:</code></b></td>
                            <td colspan="5" class="text-right"><b><code>{{ ucfirst($data['words']['total_bill']) }} Taka (only)</code></b></td>
                        </tr>

                        <tr>
                            <td class="bill-down"></td><td class="bill-down"></td><td class="bill-down"></td><td class="bill-down"></td>
                            <td class="bill-down text-right">
                                <b><code>Due:</code></b>
                            </td>
                            <td class="bill-down text-right">
                                <b><samp>{{ $bill->total_bill - $bill->total_paid }}</samp></b>
                            </td>
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


@section('script')
    <script>
        function print(url) {
            var win = window.open(url, '_blank');
            win.focus();

        }
    </script>
@endsection


