@extends('admin.master')


@section('content')
    <div class="col-md-8">
        {{ csrf_field() }}
        <br><br><br>
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <b>Delivery List</b>
                    <button type="button" class="btn btn-i btn-sm pull-right" onclick='window.location="{{ route('deliver.create') }}"'>New Delivery</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-info">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="">Date</th>
                            <th class="">Item name</th>
                            <th class="">Delivery quantity</th>
                            <th class=""></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $deliveries as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime($item->date->date)) }}</td>
                                <td>{{ $item->ledger->name }}</td>
                                <td>{{ $item->quantity.' '.$item->unit->name }}</td>
                                <td width="18%" align="right">
                                    <a href="{{ route('deliver.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a href="" class="btn btn-sm btn-danger" title="Delete" onclick="destroy({{$item->id}}); return false;">
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

        function destroy(id){
            var check = confirm('Are you sure want Delete this?')
            if( check)
                $.ajax({
                    type: 'DELETE',
                    url: '/stocks/deliver/'+id,
                    data: {_token: _token},
                    success: function (data) {
                        console.log(data)
                        window.location.href = "{{ route('deliver.index') }}";
                    }
                })
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
