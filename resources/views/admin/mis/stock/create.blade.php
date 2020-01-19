@extends('admin.master')

@section('content')
    <div class="col-md-6">
        <samp>
            <div class="card text-left">
                <div class="card-header">  <strong>Add New {{ $type_id != 3 ? 'Inventory' : 'Grocery' }} {{ isset($stock_head_id) ? 'Item' : 'Category'  }}</strong>  </div>
                <div class="card-body">
                    <form class="" action="{{ route('stock.store') }}" method="POST" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
                        {{ csrf_field() }}

                        <input type="hidden" name="type_id" value="{{ $type_id }}">
                        @if( isset($stock_head_id))
                            <input type="hidden" name="stock_head_id" value="{{ $stock_head_id }}">
                        @endif

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-left">Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="name" name="name">
                            <p class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</p>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-left">Description</label>
                            <textarea type="text" class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success" >ADD</button>
                        <button type="reset" class="btn btn-danger" >RESET</button>
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
