@extends('admin.master')


@section('content')
    <div class="col-md-7 offset-md-2">
        <br><br><br>
        <div class="card">
            <div class="card-header">Billing List</div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-info">
                    <thead>
                    <tr>
                        <th></th>
                        <th class="">Guest Name</th>
                        <th class="">Organization</th>
                        <th class="">Total Bill</th>
                        <th class="">Total Paid</th>
                        <th class="">Due</th>
                        <th class="">Checkout Status</th>
                        <th class="">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $billing as $bill )
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $bill->guest->name }}</td>
                            <td>{{ $bill->guest->org_name ? $bill->guest->org_name : ' ' }}</td>
                            <td>{{ $bill->total_bill + $data[$bill->id]['vat'] }}</td>
{{--                            <td>{{ $data[$bill->id]['booking'].'+'. $data[$bill->id]['tax'].'-'. $bill->discount }} = {{ $data[$bill->id]['booking'] + $data[$bill->id]['tax'] - $bill->discount }}</td>--}}
                            <td>{{ $bill->total_paid }}</td>
                            <td>{{ $bill->total_bill + $data[$bill->id]['vat'] - $bill->total_paid }}</td>
{{--                            <td>{{ $data[$bill->id]['booking'] + $data[$bill->id]['tax'] - $bill->discount - $bill->total_paid }}</td>--}}
                            <td>{{ $bill->checking_status ? 'Yes' : 'No' }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('billing.show', $bill->id) }}">View</a>
                                        <a class="dropdown-item" href="">Edit</a>
                                        <a class="dropdown-item" href="{{ route('payment.create', $bill->id) }}">Make Payment</a>
                                        <a class="dropdown-item" href="{{ route('payment.index', $bill->id) }}">All Payments</a>
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

