@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
{{--                Add {{ $type_id == 1 ? 'Inventory' : 'Restaurant' }} Supplier--}}
            </div>
            <div class="card-body">
                <form action="{{ route('staff.store') }}" method="POST">
                    {{ csrf_field() }}
{{--                    <input type="hidden" name="type_id" value="{{ $type_id }}">--}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact No</label>
                                <input type="text" name="phone_no" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="add-button" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
@endsection
