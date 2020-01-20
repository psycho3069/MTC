@extends('admin.master')


@section('content')
    <div class="col-md-8">
        <br><br><br>
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <b><code>Menu Items</code></b>
                    <button type="button" class="btn btn-ii float-right" onclick='window.location="{{ route('menu.create') }}"'>Add Menu</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-info">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Menu</th>
                            <th>Items</th>
                            <th>Price</th>
                            <th class="">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $menus as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @foreach( $item->items as $meal )
                                        {{ $meal->meal->name }},
                                    @endforeach
                                </td>
                                <td>{{ $item->price }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-i" for="btnControl">
                                            Menu
                                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="">View</a>
                                            <a href="">Edit</a>
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
