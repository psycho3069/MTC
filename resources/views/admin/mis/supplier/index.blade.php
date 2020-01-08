@extends('admin.master')


@section('content')
    <div class="col-md-7">
        <br><br><br>
        <div class="card text-left">
            <div class="card-header">
                Supplier List
                <button type="button" class="btn btn-sm btn-default pull-right" onclick='window.location="{{ route('supplier.create') }}"'>Add New</button>
            </div>
            <div class="card-body">
                <samp>
                    <table class="table table-bordered table-hover table-info">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Contact No.</th>
                            <th>Address</th>
                            <th>Designation</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $suppliers as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->contact_no }}</td>
                                <td>{{ $item->address ? $item->address : 'Not found' }}</td>
                                <td>{{ $item->designation }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            More
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item font-color" href="{{ route('supplier.edit', $item->id) }}">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item font-color" href="#">Delete</a>
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
