@extends('admin.master')


@section('content')
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                {!! $data['type_id'] == 3 ? 'Restaurant' : 'Inventory' !!} {{ $data['cat_id']  == 1 ? 'Supplier' : 'Receiver' }} List
                <button class="btn btn-primary float-right" onclick='window.location="{{ route('staff.create', [ 'type_id' => $data['type_id'], 'cat_id' => $data['cat_id']]) }}"'>Add New</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-primary">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( $data['cat_id'] == 1)
                        @foreach( $suppliers as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->address ? $item->address : '' }}</td>
                                <td>{{ $item->phone_no ? $item->phone_no : '' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="">View</a>
                                            <a class="dropdown-item" href="">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                    @if( $data['cat_id'] == 2)
                        @foreach( $receivers as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->address ? $item->address : '' }}</td>
                                <td>{{ $item->phone_no ? $item->phone_no : '' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="">View</a>
                                            <a class="dropdown-item" href="">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('datatable')

    <!-- datatable -->
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
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

