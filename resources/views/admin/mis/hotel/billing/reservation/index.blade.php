@extends('admin.master')


@section('content')
    <div class="col-md-8">
        <br><br><br>
        <div class="card text-left">
            <div class="card-header"><code>Reservation List</code></div>
            <div class="card-body">
                <samp>
                    <table class="table table-bordered table-hover table-info">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Guest Name</th>
                            <th>Organization</th>
                            <th>Bill w/o discount</th>
                            <th></th>
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
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-i" for="btnControl">Reservation</button>
                                        <div class="dropdown-content">
                                            <a href="{{ route('billing.show', $bill->id) }}">View</a>
                                            <a href="{{ route('payment.create', $bill->id) }}">Make Payment</a>
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


