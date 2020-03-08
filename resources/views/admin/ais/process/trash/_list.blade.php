<?php use \App\Http\Controllers\ProcessController; ?>
@extends('admin.master')


@section('content')
    <div class="col-md-6 offset-md-3">
        <h1 class="text-center">Day End List</h1>

        @if( $dates->isEmpty() )
            <h3> No opening balance found</h3>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Day End</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Credit</th>
                    <th scope="col">Amount</th>
                </tr>
                </thead>
                <tbody>

                @foreach( $dates as $date )
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td colspan="3">
                            {{ $date->date }}
                            <ul class="list-group">
                                @foreach( $date->currentBalance as $item )
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                {{ $item->thead->name }} <b>[ {{ $item->thead->code }} ]</b>
                                            </div>
                                            <div class="col-md-3">
                                                {{ $item->debit }}
                                            </div>
                                            <div class="col-md-3">
                                                {{ $item->credit }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                <div class="row">
                                    <div class="col-md-6">
                                        Total
                                    </div>
                                    <div class="col-md-3">
                                        {{ $date->currentBalance->sum('debit') }}
                                    </div>
                                    <div class="col-md-3">
                                        {{ $date->currentBalance->sum('credit') }}
                                    </div>
                                </div>
                                <div class="row grand-total">
                                    <div class="col-md-6">
                                        Grand Total
                                    </div>

                                    <div class="col-md-3">
                                        {{ $all_bl->where( 'date_id', '<=', $date->id)->sum('debit') }}
                                    </div>
                                    <div class="col-md-3">
                                        {{ $all_bl->where( 'date_id', '<=', $date->id)->sum('credit') }}
                                    </div>
                                </div>
                            </ul>
                        </td>
                        <td>
                            <br>
                            <ul class="list-group">
                                @foreach( $date->currentBalance as $item )
                                    @php( $balance = ProcessController::calculate( $item ) )
                                    <li class="list-group-item">
                                        {{ $balance }}
                                    </li>
                                @endforeach
                            </ul>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
