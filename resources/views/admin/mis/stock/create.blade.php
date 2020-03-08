@extends('admin.master')

@section('content')
    <div class="col-md-6">
        <samp>
            <div class="card text-left">
                <div class="card-header">  <strong>Add New {{ $mis_head_id != 4 ? 'Inventory' : 'Grocery' }} {{ isset($cat_id) ? 'Item' : 'Category'  }}</strong>  </div>
                <div class="card-body">
                    <form class="" action="{{ route('stock.store') }}" method="POST" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
                        {{ csrf_field() }}

                        <input type="hidden" name="mis_head_id" value="{{ $mis_head_id }}">

                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>Name<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    <p class="text-danger">{{ $errors->has('name') ? 'Please Enter Name' : '' }}</p>
                                </div>
                            </div>

                            @if( isset($cat_id))
                                <input type="hidden" name="cat_id" value="{{ $cat_id }}">

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Unit<span class="required">*</span></label>
                                        <select class="form-control" name="unit_type_id">
                                            @foreach( $units as $unit )
                                                <option value="{{ $unit->id }}">{{ ucwords($unit->name) }}</option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger">{{ $errors->has('unit_type_id') ? 'Please Select a Unit' : ''}}</p>
                                    </div>
                                </div>
                            @endif
                        </div>


                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-block btn-success">Add</button>


                    </form>
                </div>
            </div>
        </samp>
    </div>
@endsection



@section('style')
    <style>
        .required{
            color: #ff0000;
        }
    </style>
@endsection
