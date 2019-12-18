@extends('admin.master')

@section('header_styles')
    <link href="{{asset('css/datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/flatpickr.min.css')}}" rel="stylesheet">
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><strong><big>EDIT ROOM RESERVATION</big></strong></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/hotel_management/reservation/room_reservation_list')}}" class="btn btn-primary">Back</a>
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
               
                <form class="" action="{{ url('/updatereservation',$reservation_info->id) }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
                        <label for="start_date" class="col-md-4 col-form-label text-md-left">Start Date:</label>
                        <div class="col-md-6">
                            <input class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" id="check_in_date" value="{{$reservation_info->start_date}}" name="start_date" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="end_date" class="col-md-4 col-form-label text-md-left">End Date:</label>
                        <div class="col-md-6">
                            <input class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" value="{{$reservation_info->end_date}}" id="check_out_date" name="end_date" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="org_name" class="col-md-4 col-form-label text-md-left">Guest Org Name:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control{{ $errors->has('org_name') ? ' is-invalid' : '' }}" value="{{$reservation_info->org_name}}" id="org_name" name="org_name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                      <label for="guest_name" class="col-md-4 col-form-label text-md-left">Guest Name:</label>
                      <div class="col-md-6">
                      <input type="text" class="form-control{{ $errors->has('guest_name') ? ' is-invalid' : '' }}" value="{{$reservation_info->guest_name}}" id="guest_name" name="guest_name" required>
                    </div>
                    </div>

                    <div class="form-group row">
                      <label for="guest_contact" class="col-md-4 col-form-label text-md-left">Contact No:</label>
                      <div class="col-md-6">
                      <input type="text" class="form-control{{ $errors->has('guest_contact') ? ' is-invalid' : '' }}" value="{{$reservation_info->guest_contact}}" id="guest_contact" name="guest_contact" required>
                    </div>
                    </div>

                    <div class="form-group row">
                      <label for="room_id" class="col-md-4 col-form-label text-md-left">Room:</label>
                      <div class="col-md-6">
                      <select id="room_id" name="room_id" class="form-control{{ $errors->has('room_id') ? ' is-invalid' : '' }}" required>
                        <option value>--Choose One--</option>
                          @foreach($room_info as $row_room)
                              @foreach($room_category as $value)
                                  @if($row_room->category_id == $value->id)
                                    <option value="{{ $row_room->id }}"
                                      @if($reservation_info->room_id == $row_room->id)
                                        {{'Selected'}}
                                      @endif
                                      >{{ $row_room->room_no }} -- {{ $value->name }}
                                    </option>
                                  @endif
                              @endforeach
                          @endforeach
                      </select>
                    </div>
                    </div>

                    <div class="form-group row">
                      <label for="status" class="col-md-4 col-form-label text-md-left">Status:</label>
                      <div class="col-md-6">
                      <select id="status" name="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" required>
                          <option value="1">{{Config::get('constants.roomResStatus.1')}}</option>
                      </select>
                    </div>
                    </div>      

                    <!-- Button -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" >Update</button>
                    </div>

                  </form>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/flatpickr.min.js')}}"></script>
<script src="{{asset('js/custom_datepicker.js')}}"></script>

@endsection