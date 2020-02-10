@extends('admin.master')

@section('content')
    <div class="col-md-8">
        {{ csrf_field() }}
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <strong>{{ $mis_head_id != 4 ? 'Inventory' : 'Grocery' }} List</strong>
                    <a href="{{ route('stock.create', ['mis_head_id' => $mis_head_id]) }}" class="btn btn-iii float-right">Add Category </a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover table-primary">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php( $i = 0)
                        @foreach( $mis_heads as $mis_head )
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td class="tree">
                                    <ul>
                                        <li>
                                            <span>
                                                <i class="fa fa-plus-circle"></i>
                                                <b><code>{{ $mis_head->name }}</code></b>
                                            </span>

                                            <ul>
                                                @foreach( $mis_head->ledger as $item )
                                                    <li class="collapse-i">
                                                        <span>
                                                            {{ $item->name }} ({{ $item->currentStock ? $item->currentStock->sum('quantity_dr') - $item->currentStock->sum('quantity_cr').' '.$item->unitType->name: 0 }})
                                                            <a href="" class="delete" id="{{ $item->id }}" onclick="destroy(this.id, 1); return false;">
                                                                <i title="Delete" class="fa fa-trash-o delete" aria-hidden="true"></i>
                                                            </a>
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </li>
                                    </ul>

                                </td>
                                <td>{{ $mis_head->description ? $mis_head->description : 'Not Found'}}</td>
                                <td width="18%" align="right">
                                    <a href="{{ route('stock.create', ['cat_id' => $mis_head->id, 'mis_head_id' => $mis_head->mis_head_id] ) }}" class="btn btn-sm btn-i" title="Add Item">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('stock.edit', $mis_head->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a href="" class="btn btn-sm btn-danger" data_id="{{ $mis_head->id }}" title="Delete" onclick="destroy( $(this).attr('data_id'), 0); return false;">
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

        setTimeout(function () {
            $('.collapse-i').hide(2500)
        }, 500)


        $(function () {


            $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');

            $('.tree li.parent_li > span').on('click', function (e) {
                var children = $(this).parent('li.parent_li').find(' > ul > li');
                if (children.is(":visible")) {
                    children.hide(500);
                    $(this).attr('title', 'Expand this branch').find(' > i').addClass('fa-plus-circle').removeClass('fa-minus-circle');
                } else {
                    children.show(500);
                    $(this).attr('title', 'Collapse this branch').find(' > i').addClass('fa-minus-circle').removeClass('fa-plus-circle');
                }
                e.stopPropagation();
            });
        });
    </script>




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
                        var m_id = @json($mis_head_id);
                        window.location.href = "stock?mis_head_id="+m_id
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
