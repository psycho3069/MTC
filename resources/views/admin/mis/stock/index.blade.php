@extends('admin.master')

@section('content')
    <div class="col-md-8">
        {{ csrf_field() }}
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <strong>{{ $type_id != 3 ? 'Inventory' : 'Grocery' }} List</strong>
                    <a href="{{ route('stock.create', ['type_id' => $type_id]) }}" class="btn btn-iii float-right">Add Category </a>
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
                                                    <a href="" class="delete" id="{{ $item->id }}" onclick="destroy(this.id, 1); return false;"><i title="Delete" class="fa fa-trash-o delete" aria-hidden="true"></i></a>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>

                                </td>
                                <td>{{ $stock_head->description ? $stock_head->description : 'Not Found'}}</td>
                                <td width="18%" align="right">
                                    <a href="{{ route('stock.create', ['stock_head_id' => $stock_head->id, 'type_id' => $stock_head->type_id] ) }}" class="btn btn-sm btn-i" title="Add Item">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('stock.edit', $stock_head->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a href="" class="btn btn-sm btn-danger" data_id="{{ $stock_head->id }}" title="Delete" onclick="destroy( $(this).attr('data_id'), 0); return false;">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
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




@section('script')
    <script>

        var _token = $('input[name="_token"]').val()

        function destroy( id, type) {
            var check = confirm('Are you sure want Delete this?')
            // console.log( id+' ->'+ type)
            if( check){
                $.ajax({
                    type: 'DELETE',
                    url: "stock/"+id,
                    data: {_token: _token, id: id, type: type},
                    success:function (data) {
                        // console.log(data)
                        window.location.href = "{{ route('stock.index') }}"

                    }

                })

            }

        }



    </script>
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
