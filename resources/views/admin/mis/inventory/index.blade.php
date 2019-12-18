@extends('admin.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><big> <strong>INVENTORY CATEGORIES</strong> </big></div>

                    <div class="card-body">
                        <a href="{{ route('mis.inventory.create') }}" class="btn btn-primary">Add New Inventory Category</a>
                    </div>

                    <table id="inventory_category" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $inventories as $inventory )
                            <tr>
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="tree ">
                                        <div class="row">
                                            <div class="col-md-9">
                                                {{ $inventory->name }}
                                                <ul>
                                                    @foreach( $inventory->stock as $item )
                                                        <li>
                                                            <span>
                                                                {{ $item->name }} ({{ $item->currentStock ? $item->currentStock->sum('quantity') : 0 }})
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-md-3">
                                                Total Price
                                                @foreach( $inventory->stock as $item )
                                                    <li>{{ $item->currentStock ? $item->currentStock->sum('amount') : 0 }}</li>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td>{{ $inventory->description }}</td>
                                <td width="15%" align="right">
                                    <a href="{{ route('mis.inventory.create', ['stock_head_id' => $inventory->id] ) }}" class="btn btn-sm btn-info">Add Child</a>
                                    <a href="" class="btn btn-sm btn-info">Edit</a>
                                    <a href="" class="btn btn-sm btn-danger" id="delete">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
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
            $('#inventory_category').DataTable({
                "paging": true,
                "ordering":  true,
            });
        } );
    </script>

@endsection
