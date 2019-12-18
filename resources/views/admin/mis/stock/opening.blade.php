@extends('admin.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"> <strong> {{ ucfirst($categories->first()->category) }} Opening Balance</strong></div>
                    <div class="card-body">
                        <form action="{{ route('stock.balance') }}" method="POST">
                            {{ csrf_field()}}
                            <table id="inventory_category" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
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
                                            <td style="width: 40%" colspan="2">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="number" class="inputbox form-control" name="input[{{$item->id}}][quantity]" value="{{ $item->quantity }}" min="0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" class="inputbox form-control" name="input[{{$item->id}}][amount]" value="{{ $item->amount }}" min="0">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-dark">Submit</button>
                        </form>
                    </div>
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
