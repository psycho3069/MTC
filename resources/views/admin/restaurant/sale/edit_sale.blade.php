@extends('admin.master')

@section('header_styles')
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><strong><big>ADD FOOD SALE</big></strong></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a href="{{URL::to('/restaurant/sale/food-sale')}}" class="btn btn-primary">BACK</a>
                    </div>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger" style="padding: 0 30px 0 30px;">
                            Upload Validation Error<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif

                                <!--form-->

                        <form class="" action="{{ url('/update/sale',$sales->id) }}" method="post" autocomplete="off" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
                            @csrf

                            <p class="alert-success" style="font-size: 20px; color: white; background:#149278; padding: 0 30px 0 30px;">
                                @php
                                $message=Session::get('message');
                                if($message) {
                                echo $message;
                                Session::put('message',null);
                                }
                                @endphp

                            </p>

                            <div class="form-group row">
                                <label for="guest" class="col-md-4 col-form-label text-md-left">Booking Status:</label>
                                <div class="col-md-6">
                                    <label for="room"><input type="radio" name="booking_status" id="booking_status" value="1" @if($sales->booking_status == 1) {{ 'checked' }}@endif required> Room &nbsp;&nbsp;</label>
                                    <label for="venue">&nbsp;&nbsp;<input type="radio" name="booking_status" value="2" id="booking_status" @if($sales->booking_status == 2) {{ 'checked' }}@endif > Venue</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="guest_name" class="col-md-4 col-form-label text-md-left">Guest Name:</label>
                                <div class="col-md-6">
                                    <select id="guest_name" name="guest_id" class="form-control" required>
                                        <option value="">--Choose One--</option>
                                        @foreach($room_guests as $value)
                                            <option value="{{ $value->id }}" @if($value->id == $sales->guest_id) {{ 'selected' }}@endif>{{ $value->guest_name }}</option>
                                        @endforeach
                                        @foreach($venue_guests as $value)
                                            <option value="{{ $value->id }}" @if($value->id == $sales->guest_id) {{ 'selected' }}@endif>{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="menu_type" class="col-md-4 col-form-label text-md-left">Menu Type:</label>
                                <div class="col-md-6">
                                    <select id="menu_type" name="menu_type" class="form-control" required>
                                        <option value="">--Choose One--</option>
                                        @foreach($menu_types as $value)
                                            <option value="{{ $value->id }}" @if($value->id == $sales->menu_type) {{ 'selected' }}@endif>{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="menus" class="col-md-4 col-form-label text-md-left">Menus:</label>
                                <div class="col-md-6">
                                    <select id="menus" name="menu_id" class="form-control" required>
                                        <option value="">--Choose One--</option>
                                        @foreach($menus as $value)
                                            <option value="{{ $value->id }}" @if($value->id == $sales->menu_id) {{ 'selected' }}@endif>{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity" class="col-md-4 col-form-label text-md-left">Quantity:</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="quantity" value="{{ $sales->quantity }}" min="1" name="quantity" required>
                                </div>
                            </div>


                            <!-- Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-success add" >UPDATE</button>
                                <button type="reset" class="btn btn-danger add" >RESET</button>
                            </div>

                        </form>

                </div>
            </div>
        </div>
    </div>

@endsection