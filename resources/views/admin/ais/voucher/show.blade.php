@extends('admin.master')


@section('content')
    <div class="col-md-6 offset-md-3">
        <h1>List</h1>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Debit Account</th>
                <th scope="col">Credit Account</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
                <th scope="col">Note</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $v_group->vouchers as $voucher )
                <tr>
                    <td>{{ $voucher->debitAccount->name }} <b>[ {{ $voucher->debitAccount->code }} ]</b></td>
                    <td>{{ $voucher->creditAccount->name }} <b>[ {{ $voucher->creditAccount->code }} ]</b></td>
                    <td>{{ $voucher->amount }}</td>
                    <td>{{ $voucher->date->date }}</td>
                    <td>{{ str_limit( $voucher->note, 10)  }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection
