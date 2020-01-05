@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <h1 class="text-center">Day End List</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Day End</th>
                <th scope="col" class="text-center">Quantity</th>
                <th scope="col">Amount</th>
                <th scope="col" class="text-center">Total</th>
            </tr>
            </thead>
            <tbody>

            @foreach( $current_stock->groupBy('date_id') as $key => $items )
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td colspan="3">
                        {{ $key ? $items->first()->date->date : 'Current Balance' }}
                        <ul class="list-group">
                            @foreach( $items as $item )
                                @if( $item->quantity)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                {{ str_limit($item->stock->name,10) }}
                                            </div>
                                            <div class="col-md-3">
                                                {{ $item->quantity }}
                                            </div>
                                            <div class="col-md-3">
                                                {{ $item->amount }}
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <br>
                        <ul class="list-group">
                            @foreach( $items as $item )
                                @if( $item->quantity || $item->amount)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                {{ $current_stock->where('stock_id', $item->stock_id)->where( 'date_id', '<=', $key)->sum('quantity') }}
                                            </div>
                                            <div class="col-md-6">
                                                {{ $current_stock->where('stock_id', $item->stock_id)->where( 'date_id', '<=', $key)->sum('amount') }}
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
