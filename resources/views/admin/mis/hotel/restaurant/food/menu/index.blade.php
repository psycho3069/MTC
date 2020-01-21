@extends('admin.master')


@section('content')
    <div class="col-md-8">
        {{ csrf_field() }}
        <br><br><br>
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <b><code>Menu Items</code></b>
                    <button type="button" class="btn btn-iii float-right" onclick='window.location="{{ route('menu.create') }}"'>Add Menu</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-primary" style="table-layout: auto">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Menu</th>
                            <th class="text-center" width="17%">Price</th>
                            <th class="">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $menus as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <b><code>{{ $item->name }}</code></b>
                                    <ul>
                                        @foreach( $item->items as $meal )
                                            <li>
                                                <span>
                                                    {{ $meal->meal->name.' ('.$meal->quantity.')' }}
                                                    <a href="" class="delete" id="{{ $meal->id }}" onclick="destroy(this.id, 1); return false;">
                                                        <i title="Delete" class="fa fa-trash-o delete" aria-hidden="true"></i>
                                                    </a>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>

                                <td class="text-center">{{ $item->price }}</td>
                                <td>
                                    <a href="" class="btn btn-sm btn-i" title="Add Item">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('menu.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a href="" class="btn btn-sm btn-danger" data_id="{{ $item->id }}" title="Delete" onclick="destroy( $(this).attr('data_id'), 0); return false;">
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
            console.log(id +' ->'+ type)
            var check = confirm('Are you sure want Delete this?')
            // console.log( id+' ->'+ type)
            if( check){
                $.ajax({
                    type: 'DELETE',
                    url: "menu/"+id,
                    data: {_token: _token, id: id, type: type},
                    success:function (data) {
                        // console.log(data)
                        window.location.href = "{{ route('menu.index') }}"
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
