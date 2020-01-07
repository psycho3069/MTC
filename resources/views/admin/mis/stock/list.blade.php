@extends('admin.master')

@section('content')
    <div class="col-md-5">
        <samp>
            <div class="card text-left">
{{--                <div class="card-header"> <strong>All {{ ucfirst($categories->first()->category) }} Item</strong></div>--}}
                <div class="card-header">
                    {{ $type_id != 5 ? 'Grocerie\'s' : 'Inventorie\'s' }} Stock
                </div>

                <div class="card-body">
                    <table class="table table-info table-hover table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
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
                                    <td>{{ $item->currentStock->sum('quantity_dr') - $item->currentStock->sum('quantity_cr').' '.$item->unit }}</td>
                                </tr>
                            @endforeach
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


