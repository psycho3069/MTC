@extends('admin.master')

@section('content')
    <div class="col-md-7">
        <samp>
            <div class="card text-left">
                {{--                <div class="card-header"> <strong>All {{ ucfirst($categories->first()->category) }} Item</strong></div>--}}
                <div class="card-header">
                    {{ date('d M, Y', strtotime($p_group->created_at)) }} Purchase List
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
                            <td></td>
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
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            More
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item font-color" href="">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item font-color" href="">Delete</a>
                                        </div>
                                    </div>
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


