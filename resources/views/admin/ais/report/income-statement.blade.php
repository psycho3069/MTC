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

                    <form action="{{ route('reports.income.statement') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control" value="{{ $date ?? '' }}">
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
                            <th class="text-center border1 H1">Particular</th>
                            <th class="text-cnter border1 H2">This Month</th>
                            <th class="text-cnter border1 H3">This Year</th>
                            <th class="text-center border1 H1">Particular</th>
                            <th class="text-cnter border1 H2">This Month</th>
                            <th class="text-cnter border1 H3">This Year</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="border2" colspan="3"><strong>Income</strong></td>
                            <td class="border2" colspan="3"><strong>Expense</strong></td>
                        </tr>

                        <tr>
                            @foreach($data as $acHead)
                                <td colspan="3" class="no-pad border3">
                                    @if(count($acHead) >= 3 )
                                    <table class="nested">
                                        <tr>
                                            <td class="A T1">
                                                <i class="fa" aria-hidden="true"></i>
                                                {{ $acHead['name'] }}
                                            </td>
                                            <td class="text-right T2">{{ $acHead['monthly'] }}</td>
                                            <td class="text-right T3">{{ $acHead['cumulative'] }}</td>

                                            <?php unset($acHead['name'], $acHead['monthly'], $acHead['cumulative']) ?>
                                            @foreach($acHead as $child_i )
                                                <tr>
                                                    <td class="a1 ">
                                                        <i class="fa {{count($child_i)<4?'fa-tag':''}}" aria-hidden="true"></i>
                                                        {{ $child_i['name'] }}
                                                    </td>
                                                    <td class="text-right">{{ $child_i['monthly'] }}</td>
                                                    <td class="text-right">{{ $child_i['cumulative'] }}</td>

                                                    <?php unset($child_i['name'], $child_i['monthly'], $child_i['cumulative']) ?>
                                                    @foreach($child_i as $child_ii)
                                                        <tr>
                                                            <td class="a2 {{count($child_ii)<4?'thead':''}}">
                                                                <i class="fa {{count($child_ii)<4?'fa-tag':''}}" aria-hidden="true"></i>
                                                                {{ $child_ii['name'] }}
                                                            </td>
                                                            <td class="text-right">{{ $child_ii['monthly'] }}</td>
                                                            <td class="text-right">{{ $child_ii['cumulative'] }}</td>

                                                            <?php unset($child_ii['name'], $child_ii['monthly'], $child_ii['cumulative']) ?>
                                                            @foreach( $child_ii as $child_iii )
                                                                <tr>
                                                                    <td class="a3 {{count($child_iii)<4?'thead':''}}">
                                                                        <i class="fa {{count($child_ii)<4?'fa-tag':''}}" aria-hidden="true"></i>
                                                                        {{ $child_iii['name'] }}
                                                                    </td>
                                                                    <td class="text-right">{{ $child_iii['monthly'] }}</td>
                                                                    <td class="text-right">{{ $child_iii['cumulative'] }}</td>

                                                                    <?php unset($child_iii['name'], $child_iii['monthly'], $child_iii['cumulative']) ?>
                                                                    @foreach( $child_iii as $child_iv )
                                                                        <tr>
                                                                            <td class="a4 {{count($child_iv)<4?'thead':''}}">
                                                                                <i class="fa {{count($child_iv)<4?'thead':''}}" aria-hidden="true"></i>
                                                                                {{ $child_iv['name'] }}
                                                                            </td>
                                                                            <td class="text-right">{{ $child_iv['monthly'] }}</td>
                                                                            <td class="text-right">{{ $child_iv['cumulative'] }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tr>
                                    </table>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        </tbody>
                        <tr class="profit">
                            <td colspan="3">
                                <table class="nested">
                                    <td class="no-border">Profit</td>
                                    <td class="no-border text-right T2">{{$data[3]['monthly'] - $data[4]['monthly']}}</td>
                                    <td class="no-border text-right T3">{{$data[3]['cumulative'] - $data[4]['cumulative']}}</td>

                                </table>
                            </td>
                        </tr>
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
        .profit td{
            font-weight: 800;
            border: 0.21em solid black;
        }
        .no-border{
            border: transparent !important;
        }

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


        .H1{
            width: 27%;
        }

        .H2{
            width: 11%;
        }

        .H3{
            width: 12%;
        }

        .T1{
            width: 55%;
        }

        .T2{
            width: 22%;
        }

        .T3{
            width: 24%;
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

