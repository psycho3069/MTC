@extends('admin.master')


@section('content')
    <div class="col-md-9">

        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <button type="button" class="btn btn-i" onclick='window.location="{{ URL::previous() }}"'>Back</button>
                </div>
                <div class="card-body">
                    <h5 class="text-center">ASPADA Paribesh Unnayan Foundation</h5>
                    <p>
                        <img src="{{ asset('img/mtclogo.png') }}" alt="Aspada" style="width: 33px; margin-left: 28%; margin-bottom: 2%;">
                        House:193(1st Floor), Road:1, New DOHS, Mohakhali, Dhaka-1206
                    </p>

                    <p class="text-center" style="margin-bottom: 3%; color: blue;">
                        <b>{{ $info['v_type'].' Voucher' }}</b>
                    </p>

                    <code>
                        Date: {{ date('d-m-Y', strtotime( $info['v_date'])) }} <br>
                        Code: {{ $info['v_code'] }}
                    </code>
                    
                    <table class="table top-auto table-bordered" style="margin-top: 2%;">
                        <thead>
                        <tr>
                            <th>Ledger head</th>
                            <th class="text-center">Code</th>
                            <th class="text-right">Debit Amount</th>
                            <th class="text-right">Credit Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $data as $item )
                            <tr>
                                <td class="v_list">{{ $item['name'] }}</td>
                                <td class="text-center v_list">{{ $item['code'] }}</td>
                                <td class="text-right v_list">{{ $item['debit'] ? $item['debit'] : '-'  }}</td>
                                <td class="text-right v_list">{{ $item['credit'] ? $item['credit'] : '-' }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="v_list" colspan="2"><b><code>Total</code></b></td>
                            <td class="text-right v_list"><code><b>{{ $info['total']['amount'] }}</b></code></td>
                            <td class="text-right v_list"><code><b>{{ $info['total']['amount'] }}</b></code></td>
                        </tr>
                        <tr>
                            <td class="v_list" colspan="4"><code><b>In words : {{ ucwords($info['total']['words']) }}  Taka (only)</b></code></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </samp>
    </div>
@endsection

@section('style')
    <style>
        table thead th {
            border: 2px solid black !important;
        }

        .v_list {
            border: 1px solid #181717 !important;
        }

        .v_total {
            border: 1.5px solid black !important;
        }

        /*td {*/
        /*    border: 1px solid black !important;*/
        /*}*/
        /*table tbody tr {*/
        /*    border: 1.5px solid black !important;*/
        /*}*/
    </style>
@endsection
