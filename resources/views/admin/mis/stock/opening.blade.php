@extends('admin.master')

@section('content')
    <div class="col-md-7">
        <samp>
            @if( count($categories))
                <div class="card text-left">
                    <div class="card-header"> <strong> {{ ucfirst($categories->first()->category) }} Opening Balance</strong></div>
                    <div class="card-body">
                        <form action="{{ route('stock.balance') }}" method="POST">
                            {{ csrf_field()}}
                            <table class="table table-hover table-info">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $categories as $category )
                                    @foreach( $category->stock as $item )
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->stockHead->name }}</td>
                                            <td class="col-md-4">
                                                <div class="row">
                                                    <input type="number" class="inputbox form-control" name="input[{{$item->id}}][quantity]" value="{{ $item->quantity }}" min="0">
                                                    <div class="col-md-5">
                                                        <select class="form-control" name="input[{{$item->id}}][unit]">
                                                            <option value="kg" {{ $item->unit == 'kg' ? 'selected' : '' }}>Kg</option>
                                                            <option value="liter" {{ $item->unit == 'liter' ? 'selected' : '' }}>Liter</option>
                                                            <option value="piece" {{ $item->unit == 'piece' ? 'selected' : ( $category->type_id !=3 ? 'selected' : '') }}>Piece</option>
                                                        </select>
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

                @else
                <H4>Please add some Item first</H4>
            @endif
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
