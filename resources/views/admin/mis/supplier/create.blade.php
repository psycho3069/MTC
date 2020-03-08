@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <samp>
            <div class="card text-left">
                <div class="card-header"> <b>Add Supplier</b></div>
                <div class="card-body">
                    <form action="{{ route('supplier.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span class="required">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    <p class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact No.<span class="required">*</span></label>
                                    <input type="text" name="contact_no" class="form-control" value="{{ old('contact_no') }}">
                                    <p class="text-danger">{{ $errors->has('contact_no') ? $errors->first('contact_no') : '' }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input type="text" name="designation" class="form-control" value="{{ old('designation') }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="add-button" class="btn btn-i btn-block">Add</button>
                    </form>
                </div>
            </div>
        </samp>
    </div>
@endsection
