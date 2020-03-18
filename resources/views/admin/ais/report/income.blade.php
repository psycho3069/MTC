@extends('admin.master')

<style>
    ul {
        padding-inline-start: 25px;
    }
    hr {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        border: 0 !important;
        border-top: 1px solid rgba(45, 130, 200, 0.3) !important;
    }
    b {
        color: #007bff;
    }
</style>

@section('content')

    <samp>
        <div class="col-md-11">

            <div class="card text-left">

                <div class="card-header">
                    Income Statement
                    <form action="{{ route('report.income') }}" method="GET" class="pull-right">
                        {{ csrf_field() }}
                        Select a date
                        {{--<input type="date" class="form-horizontal" name="date">--}}
{{--                        <select name="date_id" class="form-horizontal">--}}
{{--                            @foreach( $dates as $date )--}}
{{--                                <option value="{{ $date->id }}" {!! $date->id == $date_id ? 'selected="selected"': '' !!}>{{ $date->date }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
                        <input type="date" class="date" name="date_id" value="{{ date('d-m-Y') }}">
                        <button class="btn btn-dark btn-sm">Show</button>
                    </form>

                </div>
                <div class="card-body">

                    <div class="tree">

                        <ul>
                            <div class="row">
                                <div style="border-left: 3px #5897fb5e solid; position: absolute; z-index: 5; top: 80px; left: 43%; bottom: 143px;"></div>
                                @foreach( $heads as $head)
                                    <div class="col-md-6" style="border-left: 1px solid rgba(45, 130, 200, 0.5); border-right: 1px solid rgba(45, 130, 200, 0.5);">
                                        <li>
                                            <span>
                                                <?php // calculating total for child_i
                                                $child_total = 0;
                                                foreach( $head->transaction as $transaction ){
                                                    if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0)
                                                        $child_total += $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit');

                                                    if( $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                        $child_total += $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit');
                                                }
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <i class="fa fa-minus-square"></i><b style="font-size: larger"> {!! $head->name !!} </b>
                                                    </div>
                                                    <div class="col-md-2" >
                                                        <b class="float-right" style="color: #007bff;">
                                                            @php( $balance = $all_bl->whereIn('thead_id', $head->theads->pluck('id')))
                                                            @php( $bl[$head->id] = $head->id !=4 ? $balance->sum('credit') - $balance->sum('debit') : $balance->sum('debit') - $balance->sum('credit'))
                                                            {!! $bl[$head->id] !!}
                                                            </b>
                                                    </div>
                                                    <div class="col-md-2" >
                                                        <b class="float-right" style="color: #007bff;">
                                                            @php( $balance_year = $all_bl_year->whereIn('thead_id', $head->theads->pluck('id')))
                                                            @php( $bl_year[$head->id] = $head->id !=4 ? $balance_year->sum('credit') - $balance_year->sum('debit') : $balance_year->sum('debit') - $balance_year->sum('credit'))
                                                            {!! $bl_year[$head->id] !!}
                                                        </b>
                                                    </div>
                                                </div>
                                            </span>
                                            <hr>
                                            <ul>
                                                @foreach( $head->child as $child_i )
                                                    <li>
                                                        <span>
                                                            <?php // calculating total for child_i
                                                            $child_i_total = 0;
                                                            $child_i_total_year = 0;
                                                            foreach( $child_i->transaction as $transaction ){
                                                                if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                    $child_i_total += $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit');
                                                                if( $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                    $child_i_total_year += $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit');
                                                            }
                                                            $child_ii_total = 0;
                                                            $child_iii_total = 0;
                                                            $child_iv_total = 0;

                                                            $child_ii_total_year = 0;
                                                            $child_iii_total_year = 0;
                                                            $child_iv_total_year = 0;
                                                            foreach( $child_i->child as $child_ii ){
                                                                foreach( $child_ii->transaction as $transaction ){
                                                                    if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                        $child_ii_total += $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit');
                                                                    if( $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                        $child_ii_total_year += $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit');
                                                                }
                                                                foreach( $child_ii->child as $child_iii ){
                                                                    foreach( $child_iii->transaction as $transaction ){
                                                                        if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                            $child_iii_total += $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit');
                                                                        if( $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                            $child_iii_total_year += $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit');
                                                                    }
                                                                    foreach( $child_iii->child as $child_iv ){
                                                                        foreach( $child_iv->transaction as $transaction ){
                                                                            if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                $child_iv_total += $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit');
                                                                            if( $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                $child_iv_total_year += $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit');
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                             <div class="row">
                                                                <div class="col-md-8">
                                                                    <i class="fa fa-minus-square"></i><b>{!! ' '.$child_i->name !!}</b>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <b class="float-right">{{ $child_i_total+$child_ii_total+$child_iii_total+$child_iv_total }}</b>
                                                                </div>
                                                                 <div class="col-md-2">
                                                                    <b class="float-right">{{ $child_i_total_year+$child_ii_total_year+$child_iii_total_year+$child_iv_total_year }}</b>
                                                                </div>
                                                             </div>
                                                        </span>
                                                        <hr>
                                                        <ul>
                                                            @foreach( $child_i->child as $child_ii )
                                                                <li>
                                                                    <span>
                                                                        <?php // calculating total for child_i
                                                                        $child_ii_total = 0;
                                                                        $child_ii_total_year = 0;
                                                                        foreach( $child_ii->transaction as $transaction ){
                                                                            if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                $child_ii_total += $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit');
                                                                            if( $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                $child_ii_total_year += $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit');
                                                                        }
                                                                        $child_iii_total = 0;
                                                                        $child_iv_total = 0;
                                                                        $child_iii_total_year = 0;
                                                                        $child_iv_total_year = 0;
                                                                        foreach( $child_ii->child as $child_iii ){
                                                                            foreach( $child_iii->transaction as $transaction ){
                                                                                if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                    $child_iii_total += $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit');
                                                                                if( $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                    $child_iii_total_year += $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit');
                                                                            }
                                                                            foreach( $child_iii->child as $child_iv ){
                                                                                foreach( $child_iv->transaction as $transaction ){
                                                                                    if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                        $child_iv_total += $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit');
                                                                                    if( $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                        $child_iv_total_year += $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit');
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                         <div class="row">
                                                                            <div class="col-md-8">
                                                                                <i class="fa fa-minus-square"></i><b>{!! ' '.$child_ii->name !!}</b>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <b class="float-right">{{ $child_ii_total+$child_iii_total+$child_iv_total }}</b>
                                                                            </div>
                                                                             <div class="col-md-2">
                                                                                <b class="float-right">{{ $child_ii_total_year+$child_iii_total_year+$child_iv_total_year }}</b>
                                                                            </div>
                                                                         </div>
                                                                    </span>
                                                                    <hr>
                                                                    <ul>
                                                                        @foreach( $child_ii->child as $child_iii )
                                                                            <li>
                                                                                <span>
                                                                                    <?php // calculating total for child_i
                                                                                    $child_iii_total = 0;
                                                                                    $child_iii_total_year = 0;
                                                                                    foreach( $child_iii->transaction as $transaction ){
                                                                                        if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                            $child_iii_total += $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit');
                                                                                        if( $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                            $child_iii_total_year += $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit');
                                                                                    }
                                                                                    $child_iv_total = 0;
                                                                                    $child_iv_total_year = 0;
                                                                                    foreach( $child_iii->child as $child_iv ){
                                                                                        foreach( $child_iv->transaction as $transaction ){
                                                                                            if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                                $child_iv_total += $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit');
                                                                                            if( $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                                $child_iv_total_year += $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit');
                                                                                        }
                                                                                    }

                                                                                    ?>
                                                                                     <div class="row">
                                                                                        <div class="col-md-8">
                                                                                            <i class="fa fa-minus-square"></i><b>{!! ' '.$child_iii->name !!}</b>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <b class="float-right">{{ $child_iii_total+$child_iv_total }}</b>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <b class="float-right">{{ $child_iii_total_year+$child_iv_total_year }}</b>
                                                                                        </div>
                                                                                     </div>
                                                                                </span>
                                                                                <hr>
                                                                                <ul>
                                                                                    @foreach( $child_iii->child as $child_iv )
                                                                                        <li>
                                                                                            <span>
                                                                                                <?php // calculating total for child_i
                                                                                                $child_iv_total = 0;
                                                                                                $child_iv_total_year = 0;
                                                                                                foreach( $child_iv->transaction as $transaction ){
                                                                                                    if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                                        $child_iv_total += $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit');
                                                                                                    if( $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                                        $child_iv_total_year += $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit');
                                                                                                }
                                                                                                ?>
                                                                                                 <div class="row">
                                                                                                    <div class="col-md-8">
                                                                                                        <b>{{ $child_iv->name }}</b>
                                                                                                    </div>
                                                                                                    <div class="col-md-2">
                                                                                                        <b class="float-right">{{ $child_iv_total }}</b>
                                                                                                    </div>
                                                                                                    <div class="col-md-2">
                                                                                                        <b class="float-right">{{ $child_iv_total_year }}</b>
                                                                                                    </div>
                                                                                                 </div>
                                                                                            </span>
                                                                                            <hr>
                                                                                        </li>
                                                                                    @endforeach

                                                                                    @foreach( $child_iii->transaction as $transaction )
                                                                                        @if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 ||  $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                            <li>
                                                                                                <span>
                                                                                                     <div class="row">
                                                                                                        <div class="col-md-8">
                                                                                                            <i class="fa fa-tag" aria-hidden="true"></i>
                                                                                                            {{ $transaction->name }} [ {{ $transaction->code }} ]
                                                                                                        </div>
                                                                                                        <div class="col-md-2">
                                                                                                            <code class="float-right">{{ $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit') }}</code>
                                                                                                        </div>
                                                                                                         <div class="col-md-2">
                                                                                                            <code class="float-right">{{ $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit') }}</code>
                                                                                                        </div>
                                                                                                     </div>
                                                                                                </span>
                                                                                                <hr>
                                                                                            </li>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </ul>
                                                                            </li>
                                                                        @endforeach

                                                                        @foreach( $child_ii->transaction as $transaction )
                                                                            @if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                                <li>
                                                                                    <span>
                                                                                        <div class="row">
                                                                                            <div class="col-md-8">
                                                                                                <i class="fa fa-tag" aria-hidden="true"></i>
                                                                                                {{ $transaction->name }} [ {{ $transaction->code }} ]
                                                                                            </div>
                                                                                            <div class="col-md-2">
                                                                                                <code class="float-right">{{ $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit') }}</code>
                                                                                            </div>
                                                                                            <div class="col-md-2">
                                                                                                <code class="float-right">{{ $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit') }}</code>
                                                                                            </div>
                                                                                        </div>

                                                                                    </span>
                                                                                    <hr>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    </ul>
                                                                </li>
                                                            @endforeach

                                                            @foreach( $child_i->transaction as $transaction )
                                                                @if( $all_bl->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl->where('thead_id', $transaction->id)->sum('debit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('credit')>0 || $all_bl_year->where('thead_id', $transaction->id)->sum('debit')>0)
                                                                    <li>
                                                                        <span>
                                                                            <div class="row">
                                                                                <div class="col-md-8">
                                                                                    <i class="fa fa-tag" aria-hidden="true"></i>
                                                                                    {{ $transaction->name }} [ {{ $transaction->code }} ]
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <code class="float-right">{{ $all_bl->where('thead_id', $transaction->id)->sum('credit') - $all_bl->where('thead_id', $transaction->id)->sum('debit') }}</code>
                                                                                </div>
                                                                                 <div class="col-md-2">
                                                                                    <code class="float-right">{{ $all_bl_year->where('thead_id', $transaction->id)->sum('credit') - $all_bl_year->where('thead_id', $transaction->id)->sum('debit') }}</code>
                                                                                </div>
                                                                            </div>

                                                                        </span>
                                                                        <hr>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endforeach
                                                @foreach( $head->transaction as $transaction )
                                                    <li>
                                                        <span>
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <i class="fa fa-tag" aria-hidden="true"></i>
                                                                    {{ $transaction->name }} [ {{ $transaction->code }} ]
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <b>Amount</b>
                                                                </div>
                                                            </div>
                                                        </span>
                                                        <hr>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </div>
                                @endforeach
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-5">
                            <h4><b class="pull-left" style="color: rgba(46, 204, 113, 0.7);">Total Income</b> <b class="float-right">{{ $bl[3] }}</b></h4>
                        </div>
                        <div class="col-md-1">
                            <h4><b class="float-right">{{ $bl_year[3] }}</b></h4>
                        </div>
                        <div class="col-md-5">
                            <h4><b class="pull-left" style="color: rgba(217, 30, 24, 0.7);">Total Expense</b> <b class="float-right">{{ $bl[4] }}</b></h4>
                        </div>
                        <div class="col-md-1">
                            <h4><b class="float-right">{{ $bl_year[4] }}</b></h4>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-11">
                            <h4><b class="" style="color: #007bff;">SURPLUS/DEFICIT</b> <b class="float-right">{{ $bl[3] + $bl[4] }}</b></h4>
                        </div>
                        <div class="col-md-1">
                            <h4> <b class="">{{ $bl_year[3] + $bl_year[4] }}</b></h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </samp>


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







