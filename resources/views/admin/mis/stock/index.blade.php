@extends('admin.master')

@section('content')
    <div class="col-md-7">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <strong>{{ $type_id != 3 ? 'Inventory' : 'Grocery' }} List</strong>
                    <a href="{{ route('stock.create', ['type_id' => $type_id]) }}" class="btn btn-primary float-right">Add Category </a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover table-info">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $stock_heads as $stock_head )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <b><code>{{ $stock_head->name }}</code></b>
                                    <ul>
                                        @foreach( $stock_head->stock as $item )
                                            <li>
                                                <span>
                                                    {{ $item->name }} ({{ $item->currentStock ? $item->currentStock->sum('quantity_dr') - $item->currentStock->sum('quantity_cr').' '.$item->unit : 0 }})
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>

                                </td>
                                <td>{{ $stock_head->description ? $stock_head->description : 'Not Found'}}</td>
                                <td width="18%" align="right">
                                    <a href="{{ route('stock.create', ['stock_head_id' => $stock_head->id] ) }}" class="btn btn-sm btn-info">Add Item</a>
                                    <a href="" class="btn btn-sm btn-info">Edit</a>
                                    <a href="" class="btn btn-sm btn-danger" id="delete">Delete</a>
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
