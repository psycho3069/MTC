@extends('admin.master')

@section('header_styles')
@stop

@section('content')
<style>
        .required{
            color: #ff0000;
        }
    </style>
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

                <form class="" action="{{ url('/sale/store-food-sale') }}" method="post" autocomplete="off" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
                        <label for="guest_name" class="col-md-4 col-form-label text-md-left">Booking Status: <span class="required">*</span></label>
                        <div class="col-md-6">
                            <label for="room"><input type="radio" name="booking_status" id="booking_status" value="1" required> Room &nbsp;&nbsp;</label>
                            <label for="venue">&nbsp;&nbsp;<input type="radio" name="booking_status" value="2" id="booking_status"> Venue</label>
                        </div>
                    </div>

                    <div class="form-group row">
                      <label for="guest_name" class="col-md-4 col-form-label text-md-left">Guest Name: <span class="required">*</span></label>
                      <div class="col-md-6">
                          <select id="guest_name" name="guest_id" class="form-control" required>
                              <option value="">--Choose One--</option>
                              @foreach($room_guests as $value)
                                  <option value="{{ $value->id }}">{{ $value->guest_name }} (room)</option>
                              @endforeach
                              @foreach($venue_guests as $value)
                                  <option value="{{ $value->id }}">{{ $value->name }} (venue)</option>
                              @endforeach
                          </select>
                      </div>
                    </div>

                    <div class="form-group row">
                        <label for="menu_type" class="col-md-4 col-form-label text-md-left">Menu Type: <span class="required">*</span></label>
                        <div class="col-md-6">
                            <select id="menu_type" name="menu_type" class="form-control" required>
                                <option value="">--Choose One--</option>
                                @foreach($menu_types as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="menus" class="col-md-4 col-form-label text-md-left">Menus: <span class="required">*</span></label>
                        <div class="col-md-6">
                            <select id="menus" name="menu_id" class="form-control" required>
                                <option value="">--Choose One--</option>
                                @foreach($menus as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="quantity" class="col-md-4 col-form-label text-md-left">Quantity: <span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" id="quantity" min="1" name="quantity" required>
                        </div>
                    </div>


                      <!-- Button -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-success add" >ADD</button>
                        <button type="reset" class="btn btn-danger add" >RESET</button>
                    </div>

                  </form>
            </div>
        </div>
    </div>
</div>

@endsection
