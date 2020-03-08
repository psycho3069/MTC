@extends('admin.master')


@section('content')
    <div class="col-md-10">
        <form action="{{ route('units.update', $unit_type->id) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PATCH">
            <samp>
                <div class="card text-left">
                    <div class="card-header">
                        <b>Edit Unit</b>
                    </div>
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-3">
                                <h4>Unit Type</h4>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $unit_type->name }}">
                                    <p class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Short Name</label>
                                    <input type="text" class="form-control" name="short_name" value="{{ old('short_name') ? old('short_name') : $unit_type->short_name }}">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" cols="3" rows="2">{{ old('description') ? old('description') : $unit_type->description }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-1"></div>

                            <div class="col-md-8">
                                <h4>Units</h4>
                                <p class="text-danger">{{ $errors->has('input.*.name') ? $errors->first('input.*.name') : '' }}</p>
                                <p class="text-danger">{{ $errors->has('input.*.short_name') ? $errors->first('input.*.short_name') : '' }}</p>
                                <p class="text-danger">{{ $errors->has('input.*.multiply_by') ? $errors->first('input.*.multiply_by') : '' }}</p>

                                @foreach( $unit_type->units as $unit )
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" name="input[{{$unit->id}}][name]" value="{{ $unit->name }}">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Short Name</label>
                                                <input type="text" class="form-control" name="input[{{$unit->id}}][short_name]" value="{{ $unit->short_name }}">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Multiply By</label>
                                                <input type="text" class="form-control" name="input[{{$unit->id}}][multiply_by]" value="{{ $unit->multiply_by }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Description</label>
                                            <textarea class="form-control" name="input[{{$unit->id}}][description]" cols="3" rows="1">{{ $unit->description }}</textarea>
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
