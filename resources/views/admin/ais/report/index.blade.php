@extends('admin.master')


@section('content')
    <div class="col-md-6">



        <div class="col-md-8">
            <table data-toggle="table">
                <thead>
                <tr>
                    <th>Income</th>
                    <th>Balance</th>
                </tr>
                </thead>
                <tbody>
                <b>{{ $balance['income']->first()->date->date }}</b>
                @foreach( $balance['income'] as $income )
                    <tr>
                        <td>
                            <p>{{ $income->thead->name }}</p>
                        </td>
                        <td>{{ $all_bl->where('thead_id', $income->thead_id)->sum('credit')- $all_bl->where('thead_id', $income->thead_id)->sum('debit')}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <b>Total</b>
            <span class="float-right">{{ $all_bl->whereIn('thead_id', $data['income'])->sum('credit') - $all_bl->whereIn('thead_id', $data['income'])->sum('debit')}}</span>
        </div>

        <div class="col-md-8">
            <table data-toggle="table">
                <thead>
                <tr>
                    <th>Expense</th>
                    <th>Balance</th>
                </tr>
                </thead>
                <tbody>
                <b>{{ $balance['expense']->first()->date->date }}</b>
                @foreach( $balance['expense'] as $expense )
                    <tr>
                        <td>
                            <p>{{ $expense->thead->name }}</p>
                        </td>
                        <td>{{ $all_bl->where('thead_id', $expense->thead_id)->sum('credit')- $all_bl->where('thead_id', $expense->thead_id)->sum('debit')}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <b>Total</b>
            <span class="float-right">{{ $all_bl->whereIn('thead_id', $data['expense'])->sum('credit') - $all_bl->whereIn('thead_id', $data['expense'])->sum('debit')}}</span>
        </div>


    </div>

@endsection


@section('header_styles')
    {{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
@endsection
