@extends('admin.master')


@section('content')
    <div class="col-md-7">
        <br><br><br>
        <div class="card text-left">
            <div class="card-header">Reservation List</div>
            <div class="card-body">
                <samp>
                    <table class="table table-bordered table-hover table-info">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="">Guest Name</th>
                            <th class="">Organization</th>
                            <th class="">Bill w/o discount</th>
                            <th class=""></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $billing as $bill )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('billing.show', $bill->id) }}">{{ $bill->guest->name }}</a></td>
                                <td><code>{{ $bill->guest->org_name ? $bill->guest->org_name : 'Not Found' }}</code></td>
                                <td>{{ $bill->total_bill }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Reservation
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item font-color" href="{{ route('billing.show', $bill->id) }}">View</a>
                                            <a class="dropdown-item font-color" href="{{ route('payment.create', $bill->id) }}">Make Payment</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item font-color" href="">Cancel</a>
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

    <!-- datatable -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "paging": true,
                "ordering":  true,
            });
        } );
    </script>

@endsection


