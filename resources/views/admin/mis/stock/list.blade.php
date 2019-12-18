@extends('admin.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"> <strong>All {{ ucfirst($categories->first()->category) }} Item</strong></div>

                    <table id="inventory_category" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Balance</th>
                            {{--                            <th>Date</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $categories as $category )
                            @foreach( $category->stock as $item )
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->stockHead->name }}</td>
                                    <td>{{ $item->currentStock->sum('quantity') }}</td>
                                    <td>{{ $item->currentStock->sum('amount') }}</td>
                                    {{--                                    <td>{{ $item->currentStock->sortBy('date_id')->last()->date->date }}</td>--}}
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('datatable')

    <!-- datatable -->
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#inventory_category').DataTable({
                "paging": true,
                "ordering":  true,
            });
        } );
    </script>

@endsection
