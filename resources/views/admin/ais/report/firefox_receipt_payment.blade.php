@extends('admin.master')


@section('content')
    <div class="col-md-12">



        <code>
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
                        <b>Receipt Payment Statement[POSMIS-6]</b>
                    </p>

                    <form action="{{ url('reports/receipt_payment') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control" value="{{ $input['date'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success btn-sm" style="margin-top: 33px;">Show</button>
                            </div>
                        </div>
                    </form>

                    <code>
                        Date:  <br>
                    </code>

                    <table class="table top-auto table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center col-md-3 border1">Particular</th>
                            <th class="text-cnter border1">This Month</th>
                            <th class="text-cnter border1">This Year</th>
                            <th class="text-center col-md-3 border1">Particular</th>
                            <th class="text-cnter border1">This Month</th>
                            <th class="text-cnter border1">This Year</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="border2" colspan="3"><strong>Receipt</strong></td>
                            <td class="border2" colspan="3"><strong>Payment</strong></td>
                        </tr>


                        <tr>
                            <td colspan="3" class="no-pad border3">
                                <table class="nested">
                                    @foreach( $data['receipt'] as $key_i => $item_i )
                                        <tr>
                                            <td class="col-md-6 A">
                                                <i class="fa {{ count($item_i) < 3 ? 'fa-tag' : '' }}" aria-hidden="true"></i>
                                                {{ $item_i['name'] }}
                                            </td>
                                            <td class="text-right">{{ $item_i['receipt']['monthly'] }}</td>
                                            <td class="text-right">{{ $item_i['receipt']['yearly'] }}</td>
                                            @if(count($item_i) > 2)
                                                @foreach( collect($item_i)->except('name', 'receipt') as $key_ii => $item_ii )
                                                    <tr>
                                                        <td class="col-md-6 a1 {{ count($item_ii) < 3 ? 'thead' : '' }}">
                                                            <i class="fa {{ count($item_ii) < 3 ? 'fa-tag' : '' }}" aria-hidden="true"></i>
                                                            {{ $item_ii['name'] }}
                                                        </td>
                                                        <td class="text-right">{{ $item_ii['receipt']['monthly'] }}</td>
                                                        <td class="text-right">{{ $item_ii['receipt']['yearly'] }}</td>
                                                        @if(count($item_ii) > 2)
                                                            @foreach( collect($item_ii)->except('name', 'receipt') as $key_iii => $item_iii )
                                                                <tr>
                                                                    <td class="col-md-6 a2 {{ count($item_iii) < 3 ? 'thead' : '' }}">
                                                                        <i class="fa {{ count($item_iii) < 3 ? 'fa-tag' : '' }}" aria-hidden="true"></i>
                                                                        {{ $item_iii['name'] }}
                                                                    </td>
                                                                    <td class="text-right">{{ $item_iii['receipt']['monthly'] }}</td>
                                                                    <td class="text-right">{{ $item_iii['receipt']['yearly'] }}</td>
                                                                    @if(count($item_iii) > 2)
                                                                        @foreach( collect($item_iii)->except('name', 'receipt') as $key_iv => $item_iv )
                                                                            <tr>
                                                                                <td class="col-md-6 a3 {{ count($item_iv) < 3 ? 'thead' : '' }}">
                                                                                    <i class="fa {{ count($item_iv) < 3 ? 'fa-tag' : '' }}" aria-hidden="true"></i>
                                                                                    {{ $item_iv['name'] }}
                                                                                </td>
                                                                                <td class="text-right">{{ $item_iv['receipt']['monthly'] }}</td>
                                                                                <td class="text-right">{{ $item_iv['receipt']['yearly'] }}</td>
                                                                                @if(count($item_iv) > 2)
                                                                                    @foreach( collect($item_iv)->except('name', 'receipt') as $key_v => $item_v )
                                                                                        <tr>
                                                                                            <td class="col-md-6 a4 {{ count($item_v) < 3 ? 'thead' : '' }}">
                                                                                                <i class="fa {{ count($item_v) < 3 ? 'fa-tag' : '' }}" aria-hidden="true"></i>
                                                                                                {{ $item_v['name'] }}
                                                                                            </td>
                                                                                            <td class="text-right">{{ $item_v['receipt']['monthly'] }}</td>
                                                                                            <td class="text-right">{{ $item_v['receipt']['yearly'] }}</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                @endif
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
                            </td>


                            <td colspan="3" class="no-pad border4">
                                <table class="nested">
                                    @foreach( $data['payment'] as $key_i => $item_i )
                                        <tr>
                                            <td class="col-md-6 A">
                                                <i class="fa {{ count($item_i) < 3 ? 'fa-tag' : '' }}" aria-hidden="true"></i>
                                                {{ $item_i['name'] }}
                                            </td>
                                            <td class="text-right">{{ $item_i['payment']['monthly'] }}</td>
                                            <td class="text-right">{{ $item_i['payment']['yearly'] }}</td>
                                            @if(count($item_i) > 2)
                                                @foreach( collect($item_i)->except('name', 'payment') as $key_ii => $item_ii )
                                                    <tr>
                                                        <td class="col-md-6 a1 {{ count($item_ii) < 3 ? 'thead' : '' }}">
                                                            <i class="fa {{ count($item_ii) < 3 ? 'fa-tag' : '' }}" aria-hidden="true"></i>
                                                            {{ $item_ii['name'] }}
                                                        </td>
                                                        <td class="text-right">{{ $item_ii['payment']['monthly'] }}</td>
                                                        <td class="text-right">{{ $item_ii['payment']['yearly'] }}</td>
                                                        @if(count($item_ii) > 2)
                                                            @foreach( collect($item_ii)->except('name', 'payment') as $key_iii => $item_iii )
                                                                <tr>
                                                                    <td class="col-md-6 a2 {{ count($item_iii) < 3 ? 'thead' : '' }}">
                                                                        <i class="fa {{ count($item_iii) < 3 ? 'fa-tag' : '' }}" aria-hidden="true"></i>
                                                                        {{ $item_iii['name'] }}
                                                                    </td>
                                                                    <td class="text-right">{{ $item_iii['payment']['monthly'] }}</td>
                                                                    <td class="text-right">{{ $item_iii['payment']['yearly'] }}</td>
                                                                    @if(count($item_iii) > 2)
                                                                        @foreach( collect($item_iii)->except('name', 'payment') as $key_iv => $item_iv )
                                                                            <tr>
                                                                                <td class="col-md-6 a3 {{ count($item_iv) < 3 ? 'thead' : '' }}">
                                                                                    <i class="fa {{ count($item_iv) < 3 ? 'fa-tag' : '' }}" aria-hidden="true"></i>
                                                                                    {{ $item_iv['name'] }}
                                                                                </td>
                                                                                <td class="text-right">{{ $item_iv['payment']['monthly'] }}</td>
                                                                                <td class="text-right">{{ $item_iv['payment']['yearly'] }}</td>
                                                                                @if(count($item_iv) > 2)
                                                                                    @foreach( collect($item_iv)->except('name', 'payment') as $key_v => $item_v )
                                                                                        <tr>
                                                                                            <td class="col-md-6 a4 {{ count($item_v) < 3 ? 'thead' : '' }}">
                                                                                                <i class="fa {{ count($item_v) < 3 ? 'fa-tag' : '' }}" aria-hidden="true"></i>
                                                                                                {{ $item_v['name'] }}
                                                                                            </td>
                                                                                            <td class="text-right">{{ $item_v['payment']['monthly'] }}</td>
                                                                                            <td class="text-right">{{ $item_v['payment']['yearly'] }}</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                @endif
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
                            </td>

                        </tr>
                        </tbody>
                    </table>


                </div>
            </div>
        </code>



    </div>
@endsection


@section('style')
    <style>
        /*.table-bordered th, .table-bordered td {*/
        /*    border: 1px solid;*/
        /*}*/

        .border1{
            border: 2px solid black !important;
        }

        .border2{
            border-bottom: 1px solid !important;
            border-left: 2px solid !important;
            border-right: 2px solid !important;
        }

        .border3{
            border-right: 1px solid !important;
            border-left: 1px solid !important;
            border-bottom: 2px solid !important;
        }

        .border4{
            border-right: 1px solid !important;
            border-bottom: 1px solid !important;
        }

        .A {
            font-size: 1.04rem;
            font-weight: 700;
            color: darkcyan;
        }

        .a1{
            padding-left: 25px !important;
            color: #d22958;
            font-size: .91rem;
            font-weight: 600;
        }
        .a2{
            padding-left: 40px !important;
            color: #d9874c;
            font-size: .9rem;
            font-weight: 650;
        }
        .a3{
            padding-left: 55px !important;
            color: coral;
            font-size: .85rem;
            font-weight: 350;
        }
        .a4{
            padding-left: 65px !important;
            color: #1c8c00;
        }


        .fa-tag {
            padding-left: 38px;
        }

        .thead{
            color: teal;
            font-size: .73rem;
            font-weight: 200;
        }


        .no-pad{
            padding: 0 !important;
            width: 50%;
        }

        .nested{
            width: 100%;
        }

        .nested table, .nested th, .nested td{
            border: 1px solid black;
            padding: 0.19rem;
            /*border-top: 1px solid black;*/
        }
    </style>
@endsection

