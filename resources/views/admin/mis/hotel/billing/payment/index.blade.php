@extends('admin.master')


@section('content')
    <div class="col-md-4 offset-md-4">
        <br><br><br>
        <div class="card">
            <div class="card-header">Billing List</div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-info">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Date</th>
                        <th>Note</th>
                        <th>Payment amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $bill->payments as $item )
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ date('d-m-Y', strtotime($item->mis_voucher->date->date)) }}</td>
                            <td>{{ $item->note ? $item->note : 'No Notes' }}</td>
                            <td class="pull-right">{{ $item->amount }}</td>
                            <td><button type="button" class="btn btn-sm btn-blue" onclick='window.location="{{ route('payment.edit', [$item->billing_id, $item->id] ) }}"'>Edit</button></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td><b>Total</b></td>
                        <td></td>
                        <td class="pull-right">{{ $bill->payments->sum('amount') }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

