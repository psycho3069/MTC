@extends('admin.master')


@section('content')
    <div class="col-md-8">
        <br><br><br>
        <div class="card text-left">
            <div class="card-header">
                Delivery List
                <button type="button" class="btn btn-i btn-sm pull-right" onclick='window.location="{{ route('deliver.create') }}"'>New Delivery</button>
            </div>
            <div class="card-body">
                <samp>
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
                                <td>{{ date('d M,y', strtotime($item->created_at)) }}</td>
                                <td>{{ $item->stock->name }}</td>
                                <td>{{ $item->quantity.' '.$item->stock->unit }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item font-color" href="">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item font-color" href="#">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </samp>
            </div>
        </div>

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
