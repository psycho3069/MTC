@extends('admin.master')


@section('content')
    <div class="col-md-7 offset-md-2">
        <br><br><br>
        <div class="card">
            <div class="card-header">Billing List</div>
            <div class="card-body">
                <samp>
                    <table class="table table-bordered table-hover table-info">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="">Guest Name</th>
                            <th class="">Organization</th>
                            <th class="">Bill w/o discount</th>
                            <th class="">Total Paid</th>
                            <th class="">Due</th>
                            <th class="">Checkout</th>
                            <th class=""></th>
                            <th class=""></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $billing as $bill )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('billing.show', $bill->id) }}">{{ $bill->guest->name }}</a></td>
                                <td><code>{{ $bill->guest->org_name ? $bill->guest->org_name : 'Not Found' }}</code></td>
                                <td>{{ $bill->total_bill }}</td>
                                <td>{{ $bill->total_paid }}</td>
                                <td>{{ $bill->total_bill - $bill->total_paid }}</td>
                                <td>{{ $bill->checkout_status ? 'Yes' : 'No' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Bill
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item font-color" href="{{ route('billing.show', $bill->id) }}">View</a>
                                            <a class="dropdown-item font-color" href="{{ route('booking.show', $bill->id) }}">Booking</a>
                                            <a class="dropdown-item font-color" href="{{ route('sales.show', $bill->id) }}">Restaurant</a>
                                            <a class="dropdown-item font-color" href="{{ route('billing.edit', $bill->id) }}">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item font-color" href="#">Delete</a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Payment
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item font-color" href="{{ route('payment.create', $bill->id) }}">Make Payment</a>
                                            <a class="dropdown-item font-color" href="{{ route('payment.index', $bill->id) }}">All Payments</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item font-color" href="{{ route('payment.create', [$bill->id, 'co' => 1]) }}">Checkout</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </samp>
            </div>
        </div>

    </div>

@endsection

