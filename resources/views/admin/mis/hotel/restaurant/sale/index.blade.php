@extends('admin.master')


@section('content')
    <div class="col-md-9">
        <br><br><br>
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <b><code>Food Sales</code></b>
                    <button type="button" class="btn btn-i float-right" onclick='window.location="{{ route('sales.create') }}"'>Add Sales</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-primary">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Guest Name</th>
                            <th>Total Bill</th>
                            <th>Checkout</th>
                            <th class="">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $billing as $bill )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime( $bill->date->date)) }}</td>
                                <td><a href="{{ route('sales.show', $bill->id) }}">{{ $bill->guest->name }}</a></td>
                                <td class="text-center"><code>{{ $data[$bill->id]['bill'] }} tk.</code></td>
                                <td class="text-center"><code>{{ $bill->checkout_status ? 'Yes' : 'No' }}</code></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-i" for="btnControl">
                                            Bill
                                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="{{ route('billing.show', $bill->id) }}">View</a>
                                            <a href="{{ route('sales.edit', $bill->id) }}">Edit</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </samp>

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
