@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <strong>Add New Unit</strong>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('units.store') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    <p class="text-danger">{{ $errors->has('name') ? 'Please Enter Name of The Unit' : ''}}</p>
                                </div>
                                <div class="form-group">
                                    <label>Short Name</label>
                                    <input type="text" class="form-control" name="short_name" value="{{ old('short_name') }}">
                                    <p class="text-danger">{{ $errors->has('short_name') ? 'Please Enter Short Name' : ''}}</p>
                                </div>

                            </div>


                            <div class="col-md-6">
                                @if( isset( $type_id))
                                    <input type="hidden" name="type_id" value="{{ $type_id }}">
                                    <div class="form-group">
                                        <label>Multiply By</label>
                                        <input type="text" class="form-control" name="multiply_by" value="{{ old('multiply_by') }}">
                                        <p class="text-danger">{{ $errors->has('multiply_by') ? $errors->first('multiply_by') : ''}}</p>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-i btn-block">Add</button>
                    </form>
                </div>
            </div>
        </samp>
    </div>
@endsection
