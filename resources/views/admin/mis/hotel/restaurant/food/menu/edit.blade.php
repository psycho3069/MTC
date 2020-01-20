@extends('admin.master')


@section('content')
    <div class="col-md-8">
        <form action="{{ route('menu.update', $menu->id) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PATCH">
            <samp>
                <div class="card text-left">
                    <div class="card-header">
                        <b>Edit Menu</b>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <h4>Menu</h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $menu->name }}">
                                            <p class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="number" class="form-control" name="price" value="{{ $menu->price }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" name="menu_type_id">
                                        @foreach( $data['menu_types'] as $item )
                                            <option value="{{ $item->id }}" {{ $menu->menu_type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1"></div>

                            <div class="col-md-5">
                                <h4>Items</h4>
                                <p class="text-danger">{{ $errors->has('input.*.name') ? 'Please Enter all Item\'s Name ' : '' }}</p>
                                @foreach( $menu->items as $item )
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Item {{ $loop->iteration }}</label>
                                                <select name="input[{{$item->id}}][meal_item_id]" class="form-control">
                                                    @foreach( $data['menu_items'] as $meal )
                                                        <option value="{{ $meal->id }}" {{ $item->meal_item_id == $meal->id ? 'selected' : '' }}>{{ $meal->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Quantity</label>
                                                <input type="number" class="form-control" name="input[{{$item->id}}][quantity]" value="{{ $item->quantity }}">
                                            </div>
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
