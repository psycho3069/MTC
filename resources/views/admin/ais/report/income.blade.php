@extends('admin.master')


@section('content')

    <samp>
        <div class="col-md-7">
            <div class="card text-left">
                <div class="card-header">
                    Income Statement
                    <form action="{{ route('report.income') }}" method="GET" class="pull-right">
                        {{ csrf_field() }}
                        Select a date
                        {{--                            <input type="date" class="form-horizontal" name="date">--}}
                        <select name="date_id" class="form-horizontal">
                            @foreach( $dates as $date )
                                <option value="{{ $date->id }}" {!! $date->id == $date_id ? 'selected="selected"': '' !!}>{{ $date->date }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-dark btn-sm">Show</button>
                    </form>

                </div>
                <div class="card-footer">

                    <div class="tree">
                        <ul>
                            @foreach( $heads as $head)
                                <li>
                            <span>
                                {!! count( $head->child )>0 ? '<i class="fa fa-minus-square"></i> '.$head->name : $head->name !!}
                                <b class="float-right">
                                    @php( $balance = $all_bl->whereIn('thead_id', $head->theads->pluck('id')))
                                    @php( $bl[$head->id] = $head->id !=4 ? $balance->sum('credit') - $balance->sum('debit') : $balance->sum('debit') - $balance->sum('credit'))
                                    {!! $bl[$head->id] !!}
                                </b>
                            </span>

                                    <ul>
                                        @foreach( $head->child as $child_i )
                                            <li>
                                        <span>
                                                {!! count( $child_i->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_i->name : $child_i->name !!}
                                        </span>

                                                <ul>
                                                    @foreach( $child_i->child as $child_ii )
                                                        <li>
                                                            <span>
                                                                {!! count( $child_ii->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_ii->name : $child_ii->name !!}
                                                            </span>

                                                            <ul>
                                                                @foreach( $child_ii->child as $child_iii )
                                                                    <li>
                                                                <span>
                                                                    {!! count( $child_iii->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_iii->name : $child_iii->name !!}
                                                                </span>

                                                                        <ul>
                                                                            @foreach( $child_iii->child as $child_iv )
                                                                                <li>
                                                                                    <span>{{ $child_iv->name }}</span>
                                                                                </li>
                                                                            @endforeach

                                                                            @foreach( $child_iii->transaction as $transaction )
                                                                                @if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0 )
                                                                                    <li>
                                                                                        <span>
                                                                                            <i class="fa fa-tag" aria-hidden="true"></i>
                                                                                            {{ $transaction->name }} [ {{ $transaction->code }} ]  <b class="float-right">{{ $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit') }}</b>
                                                                                        </span>
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @endforeach

                                                                @foreach( $child_ii->transaction as $transaction )
                                                                    @if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                        <li>
                                                                            <span>
                                                                                <i class="fa fa-tag" aria-hidden="true"></i>
                                                                                {{ $transaction->name }} [ {{ $transaction->code }} ]  <b class="float-right">{{ $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit') }}</b>
                                                                            </span>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach

                                                    @foreach( $child_i->transaction as $transaction )
                                                        @if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0)
                                                            <li>
                                                        <span>
                                                            <i class="fa fa-tag" aria-hidden="true"></i>
                                                            {{ $transaction->name }} [ {{ $transaction->code }} ] <b class="float-right">{{ $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit') }}</b>
                                                        </span>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>

                                            </li>
                                        @endforeach
                                        @foreach( $head->transaction as $transaction )
                                            <li>
                                            <span>
                                                <i class="fa fa-tag" aria-hidden="true"></i>
                                                {{ $transaction->name }} [ {{ $transaction->code }} ]
                                                <b>Amount</b>
                                            </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <br><br><br>

                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
            <h4><b class="pull-left">Revenue</b> <b class="float-right">{{ $bl[3] -$bl[4] }}</b></h4>
        </div>
    </samp>

    <br><br>
    <br><br>





@endsection


@section('style')
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
@endsection






@section('script')
    <script>
        $(function () {
            $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
            $('.tree li.parent_li > span').on('click', function (e) {
                var children = $(this).parent('li.parent_li').find(' > ul > li');
                if (children.is(":visible")) {
                    children.hide('fast');
                    $(this).attr('title', 'Expand this branch').find(' > i').addClass('fa-plus-square').removeClass('fa-minus-square');
                } else {
                    children.show('fast');
                    $(this).attr('title', 'Collapse this branch').find(' > i').addClass('fa-minus-square').removeClass('fa-plus-square');
                }
                e.stopPropagation();
            });
        });
    </script>
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('button').click(function () {--}}
{{--                var date = $('input[name="date"]').val()--}}
{{--                var _token = $('input[name="_token"]').val()--}}
{{--                $.ajax({--}}
{{--                    type:'POST',--}}
{{--                    url:'{{ route("report.get") }}',--}}
{{--                    data:{ _token:_token, date:date} ,--}}
{{--                    success:function (data) {--}}
{{--                        alert(data)--}}
{{--                    }--}}
{{--                })--}}
{{--            })--}}
{{--        })--}}
{{--    </script>--}}
@endsection







