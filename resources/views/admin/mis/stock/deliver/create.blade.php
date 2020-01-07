@extends('admin.master')


@section('content')
    <div class="col-md-4">
        <samp>
            <div class="card text-left">
                <div class="card-header">Kitchen delivery</div>
                <div class="card-body">
                    <form action="{{ route('deliver.store') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Item</label>
                                    <select class="form-control" name="stock_id">
{{--                                        <option></option>--}}
                                        @foreach( $stocks as $item )
                                            <option value="{{ $item->id }}">{{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" class="form-control" name="quantity" value="0" min="0" required>
                                </div>
                            </div>
                         </div>
                        <button type="submit" class="btn btn-info btn-block">Deliver</button>
                    </form>
                </div>
            </div>
        </samp>
    </div>

@endsection
