@extends('admin.master')


@section('content')
    <div class="col-md-9">

        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <button type="button" class="btn btn-i" onclick='window.location="{{ URL::previous() }}"'>Back</button>
                </div>
                <div class="card-body">
                    <table class="table table-info">
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
                                <td>{{ date('d-m-Y', strtotime( $voucher->date->date)) }}</td>
                                <td>{{ str_limit( $voucher->note)  }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </samp>
    </div>
@endsection
