@extends('admin.master')


@section('content')
    <div class="col-md-6 offset-md-3">
        <h1>{{ $type_id ?  $types->find( $type_id)->name : 'ALL Vouchers' }} List </h1>
        @if( $type_id )
            <a class="btn btn-light float-right" href="{{ route('vouchers.create', [ 'type_id' => $type_id ]) }}">Add voucher</a>
        @endif
        @if( !count($v_groups))
            <h3 class="No-record">No voucher found</h3>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Date</th>
                    <th scope="col">Note</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $v_groups as $v_group )
                    <tr>
                        <td>{{ $v_group->code }}</td>
                        <td>{{ $v_group->date->date }}</td>
                        <td>{{ str_limit( $v_group->note, 10)  }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('vouchers.show', $v_group->id) }}">View</a>
                                    <a class="dropdown-item" href="{{ route('vouchers.edit', $v_group->id ) }}">Edit</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        <div class="card">
            <div class="card-header">Auto Vouchers</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Date</th>
                        <th scope="col">MIS Account</th>
                        <th scope="col">Credit Account</th>
                        <th scope="col">Debit Account</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $mis_vouchers as $mis_voucher )
                        <tr>
                            <td>Auto</td>
                            <td>{{ $mis_voucher->date->date }}</td>
                            <td>{{ $mis_voucher->misAccount->name }}</td>
                            <td>{{ $mis_voucher->creditAccount->name }}</td>
                            <td>{{ $mis_voucher->debitAccount->name }}</td>
                            <td>{{ $mis_voucher->amount }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="">View</a>
                                        <a class="dropdown-item" href="">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
