@extends('admin.master')


@section('content')
    <div class="col-md-8">
        <form action="{{ route('stock.update', $mis_head->id) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PATCH">
            <samp>
                <div class="card text-left">
                    <div class="card-header">
                        <b>Edit Item</b>
                    </div>
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-4">
                                <h4>Category</h4>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $mis_head->name }}">
                                    <p class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" cols="3" rows="1">{{ old('description') ? old('description') : $mis_head->description }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-1"></div>

                            <div class="col-md-7">
                                <h4>Items</h4>
                                <p class="text-danger">{{ $errors->has('input.*.name') ? $errors->first('input.*.name') : '' }}</p>
                                <p class="text-danger">{{ $errors->has('input.*.unit_type_id') ? $errors->first('input.*.unit_type_id') : '' }}</p>
                                @foreach( $mis_head->ledger as $item )
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" name="input[{{$item->id}}][name]" value="{{ $item->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Unit</label>
                                            <select class="form-control" name="input[{{$item->id}}][unit_type_id]">
                                                @foreach( $units as $unit )
                                                    <option value="{{ $unit->id }}" {{ $item->unit_type_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label>Description</label>
                                            <textarea class="form-control" name="input[{{$item->id}}][description]" cols="3" rows="1">{{ $item->description }}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn-i">Update</button>
                    </div>

                </div>
            </samp>

        </form>
    </div>
@endsection
