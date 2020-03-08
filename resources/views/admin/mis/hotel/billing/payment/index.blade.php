@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <br><br><br>
        <samp>
            <div class="card text-left">
                <div class="card-header">All Payments of {{ ucfirst( $bill->guest->name) }}</div>
                <div class="card-body">
                    <table class="table table-info table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Payment Type</th>
                            <th>Amount</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $bill->payments->where( 'payment_type', '!=', 'discount') as $item )
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ date('d-m-Y', strtotime( $item->misVoucher->voucher->date->date)) }}</td>
                                <td>{{ ucfirst( $item->payment_type).' Bill' }}</td>
                                <td class="text-center">{{ $item->amount }}</td>
                                <td>{{ $item->note ? $item->note : 'No Notes' }}</td>
                                <td><button type="button" class="btn btn-sm btn-ii" onclick='window.location="{{ route('payment.edit', [$item->billing_id, $item->id] ) }}"'>Edit</button></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td><b>Total</b></td>
                            <td></td>
                            <td class="text-center">{{ $bill->payments->where( 'payment_type', '!=', 'discount')->sum('amount') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </samp>

    </div>

@endsection

