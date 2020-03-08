@extends('admin.master')

@section('content')
    <div class="col-md-7">
        <samp>
            @if( count($categories))
                <div class="card text-left">
                    <div class="card-header"> <strong> {{ $categories->first()->mis_head_id != 5 ? 'Grocerie' : 'Inventorie' }}'s Opening Balance</strong></div>
                    <div class="card-body">
                        <p class="text-danger">{{ $errors->has('input.*.amount') ? $errors->first('input.*.amount') : '' }}</p>
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
                                    @foreach( $category->ledger as $item )
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="input[{{$item->id}}][amount]" value="{{ $item->amount }}" min="0">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <select class="form-control" name="input[{{$item->id}}][unit_type_id]">
                                                            @foreach( $units as $unit )
                                                                <option value="{{ $unit->id }}" {{ $item->unit_type_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                                            @endforeach
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
