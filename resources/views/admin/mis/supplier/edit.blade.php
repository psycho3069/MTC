@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <samp>
            <div class="card text-left">
                <div class="card-header"></div>
                <div class="card-body">
                    <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name*</label>
                                    <input type="text" name="name" class="form-control" value="{{ $supplier->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ $supplier->address }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact No.*</label>
                                    <input type="text" name="contact_no" class="form-control" value="{{ $supplier->contact_no }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input type="text" name="designation" class="form-control" value="{{ $supplier->designation }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="add-button" class="btn btn-block btn-success">Update</button>
                    </form>
                </div>
            </div>
        </samp>
    </div>
@endsection
