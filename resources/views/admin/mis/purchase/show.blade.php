@extends('admin.master')

@section('content')
    <div class="col-md-7">
        <samp>
            <div class="card text-left">
                {{--                <div class="card-header"> <strong>All {{ ucfirst($categories->first()->category) }} Item</strong></div>--}}
                <div class="card-header">
                    <b>{{ date('d M, Y', strtotime($p_group->created_at)) }} Purchase</b>
                </div>

                <div class="card-body">
                    <table class="table table-info table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Cost</th>
                            <th>Supplier</th>
                            <th>Receiver</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $p_group->purchases as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->stock->name }}</td>
                                <td>{{ $item->quantity_dr.' '.$item->stock->unit }}</td>
                                <td>{{ $item->amount }} tk.</td>
                                <td>{{ $item->supplier->name }}</td>
                                <td>{{ $item->receiver->name }}</td>
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
