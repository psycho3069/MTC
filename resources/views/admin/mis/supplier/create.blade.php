@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <samp>
            <div class="card text-left">
                <div class="card-header">New Supplier</div>
                <div class="card-body">
                    <form action="{{ route('supplier.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name*</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact No.*</label>
                                    <input type="text" name="contact_no" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input type="text" name="designation" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="add-button" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </samp>
    </div>
@endsection
