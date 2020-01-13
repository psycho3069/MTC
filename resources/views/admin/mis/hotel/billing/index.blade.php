@extends('admin.master')


@section('content')
    <div class="col-md-10">
        <br><br><br>
        <div class="card text-left">
            <div class="card-header"><code><b>{{ $data['checkout'] ? 'Checkout' : 'Billing' }} List</b></code></div>
            <div class="card-body">
                <samp>
                    <table class="table table-bordered table-hover table-info">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="">Date</th>
                            <th class="">Guest Name</th>
                            <th class="">Organization</th>
                            <th class="no-wrap">Bill w/o discount</th>
                            <th class="no-wrap">Total Paid</th>
                            <th class="">Due</th>
                            <th class="">Checkout</th>
                            <th class=""></th>
                            <th class=""></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $billing as $bill )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime( $bill->created_at)) }}</td>
                                <td><a href="{{ route('billing.show', $bill->id) }}">{{ $bill->guest->name }}</a></td>
                                <td><code>{{ $bill->guest->org_name ? $bill->guest->org_name : 'Not Found' }}</code></td>
                                <td>{{ $bill->total_bill }}</td>
                                <td>{{ $bill->total_paid }}</td>
                                <td>{{ $bill->total_bill - $bill->total_paid }}</td>
                                <td><b>{!! $bill->checkout_status ? '<span class="badge badge-success">YES</span>' : '<span class="badge badge-danger">NO</span>' !!}</b></td>
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
                                            @if( !$bill->checkout_status)
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item font-color" href="{{ route('payment.create', [$bill->id, 'co' => 1]) }}">Checkout</a>
                                            @endif
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

@section('datatable')

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "paging": true,
                "ordering":  true,
            });
        } );
    </script>

@endsection
