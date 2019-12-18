@extends('admin.master')


@section('content')
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                Add {{ $data['type_id'] == 3 ? 'Restaurant' : 'Inventory' }} {{ $data['cat_id']  == 1 ? 'Supplier' : 'Receiver' }}
            </div>
            <div class="card-body">
                <form action="{{ route('staff.store') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="type_id" value="{{ $data['type_id'] }}">
                    <input type="hidden" name="cat_id" value="{{ $data['cat_id'] }}">
                    @if( $data['cat_id'] == 1)
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
                    @endif
                    @if( $data['cat_id'] == 2)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Employee Name</label>
                                    <select class="form-control" name="employee_id">
                                        @foreach( $receivers as $item )
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                    <button type="submit" id="add-button" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
@endsection
