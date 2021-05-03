<?php use \App\Http\Controllers\ProcessController; ?>
@extends('admin.master')


@section('content')
    <div class="col-md-12">
        <h1 class="text-center">Day End List</h1>

        @if( $dates->isEmpty() )
            <h3> No vouchers found</h3>
        @else
            <samp>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Day End</th>
                        <th scope="col">Debit</th>
                        <th scope="col">Credit</th>
                        <th scope="col">Current Balance</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach( $all_bl->groupBy('date_id') as $key => $accounts )
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td colspan="3">
                                {{ $key ? date( 'd-m-Y', strtotime( $accounts->first()->date->date)) : 'Current Balance' }}
                                <ul class="list-group">
                                    @foreach( $accounts as $item )
                                        @if( $item->debit !=0 || $item->credit !=0)
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        {{ str_limit($item->thead->name,10) }} <b>[ {{ $item->thead->code }} ]</b>
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{ $item->debit }}
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{ $item->credit }}
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                    <div class="row">
                                        <div class="col-md-6">
                                            Total
                                        </div>
                                        <div class="col-md-3">
                                            {{ $accounts->sum('debit') }}
                                        </div>
                                        <div class="col-md-3">
                                            {{ $accounts->sum('credit') }}
                                        </div>
                                    </div>
                                    <div class="row grand-total">
                                        <div class="col-md-6">
                                            Grand Total
                                        </div>

                                        <div class="col-md-3">
                                            {{ $all_bl->where( 'date_id', '<=', $key)->sum('debit') }}
                                        </div>
                                        <div class="col-md-3">
                                            {{ $all_bl->where( 'date_id', '<=', $key)->sum('credit') }}
                                        </div>
                                    </div>
                                </ul>
                            </td>
                            <td>
                                <br>
                                <ul class="list-group">
                                    @foreach( $accounts as $item )
                                        @if( $item->debit != 0 || $item->credit != 0)
                                            @php( $balance = ProcessController::calculate( $item ) )
                                            <li class="list-group-item">
                                                {{ $balance }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
{{--                {{ $data->links() }}--}}


            </samp>
            {{--            {{ $all_bl->links() }}--}}
        @endif
    </div>
@endsection




