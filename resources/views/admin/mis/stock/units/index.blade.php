@extends('admin.master')


@section('content')
    <div class="col-md-8">
        {{ csrf_field() }}
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <strong> List</strong>
                    <a href="{{ route('units.create') }}" class="btn btn-i float-right">Add Unit Type </a>
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
                        @foreach( $unit_types as $type )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <b><code>1 {{ $type->name }}</code></b>
                                    <ul>
                                        @foreach( $type->units as $unit )
                                            <li>
                                                <span>
                                                    {{ $unit->multiply_by. ' '.$unit->name  }}
                                                    <a href="" class="delete" id="{{ $unit->id }}" onclick="destroy(this.id, 1); return false;">
                                                        <i title="Delete" class="fa fa-trash-o delete" aria-hidden="true"></i>
                                                    </a>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>

                                <td>{{ $type->description ? $type->description : 'Not Found'}}</td>

                                <td width="18%" align="right">
                                    <a href="{{ route('units.create', ['type_id' => $type->id]) }}" class="btn btn-sm btn-i" title="Add Item">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('units.edit', $type->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a href="" class="btn btn-sm btn-danger" data_id="{{ $type->id }}" title="Delete" onclick="destroy( $(this).attr('data_id'), 0); return false;">
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

        function destroy(id, type) {
            var check = confirm('Are you sure want Delete this?')
            // console.log( id+' ->'+ type)
            if( check){
                $.ajax({
                    type: 'DELETE',
                    url: "units/"+id,
                    data: {_token: _token, id: id, type: type},
                    success:function (data) {
                        // console.log(data)
                        window.location.href = "units"
                    }

                })

            }

        }

    </script>
@endsection
