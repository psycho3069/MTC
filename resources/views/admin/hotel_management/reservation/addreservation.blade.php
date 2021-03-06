@extends('admin.master')

@section('header_styles')
    <link href="{{asset('css/datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/flatpickr.min.css')}}" rel="stylesheet">
    <style>
        .error{
            color: #fff;
            opacity: 0;
            text-align: center;
        }
    </style>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <p class="alert-success" style="font-size: 20px; color: #155724; background:#d4edda; padding: 0px 30px; border-radius: 4px;">
                @php
                $message=Session::get('message');
                if($message) {
                echo $message;
                Session::put('message',null);
                }
                @endphp

            </p>
            <div class="card">
                <div class="card-header"><strong><big>ADD ROOM RESERVATION</big></strong></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user())
                        <a href="{{URL::to('/hotel_management/reservation/room_reservation_list')}}" class="btn btn-primary">BACK</a>
                    @endif
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

                <form class="" action="{{ url('/savereservation') }}" method="post" enctype="multipart/form-data" autocomplete="off" style="padding: 0 30px 0 30px;">
                  @csrf


                    <div class="form-group row">
                        <label for="start_date" class="col-md-4 col-form-label text-md-left">Start Date<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" value="{{ old('start_date') }}" id="check_in_date" name="start_date" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="end_date" class="col-md-4 col-form-label text-md-left">End Date<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" value="{{ old('end_date') }}" id="check_out_date" name="end_date" >
                        </div>
                    </div>

                    <div class="form-group row">
                      <label for="org_name" class="col-md-4 col-form-label text-md-left">Organization Name</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control{{ $errors->has('org_name') ? ' is-invalid' : '' }}" value="{{ old('org_name') }}" id="org_name" name="org_name" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="guest_name" class="col-md-4 col-form-label text-md-left">Guest Name<span class="required">*</span></label>
                      <div class="col-md-6">
                        <input type="text" class="form-control{{ $errors->has('guest_name') ? ' is-invalid' : '' }}" value="{{ old('guest_name') }}" id="guest_name" name="guest_name" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="designation" class="col-md-4 col-form-label text-md-left">Designation</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control{{ $errors->has('designation') ? ' is-invalid' : '' }}" value="{{ old('designation') }}" id="designation" name="designation" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="contact_no" class="col-md-4 col-form-label text-md-left">Contact No<span class="required">*</span></label>
                      <div class="col-md-6">
                      <input type="number" class="form-control{{ $errors->has('contact_no') ? ' is-invalid' : '' }}" value="{{ old('contact_no') }}" id="contact_no" name="contact_no" required>
                    </div>
                    </div>

                    <div class="form-group row">
                      <label for="room_id" class="col-md-4 col-form-label text-md-left">Room No</label>
                      <div class="col-md-6">
                        <select id="room_id" name="room_id" class="form-control" readonly required>
                               @foreach($room_category as $value)
                                  @if($value->id == $room_info->category_id)
                                      <option value="{{ $room_info->id }}" selected>{{ $room_info->room_no }} -- {{ $value->name }}</option>
                                  @endif
                               @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="status" class="col-md-4 col-form-label text-md-left">Status</label>
                      <div class="col-md-6">
                      <select id="status" name="status" class="form-control" required>
                        <option value>--Choose One--</option>
                          <option value="1">{{Config::get('constants.roomResStatus.1')}}</option>
                      </select>
                    </div>
                    </div>

                      <!-- Button -->
                      <div class="form-group">
                          @foreach($reserve as $value)
                              @if($room_info->id == $value->room_id && $value->end_date >= date('Y-m-d'))
                                  <style>
                                      .add{
                                          display: none;
                                      }
                                      .error{
                                          color: red;
                                          opacity: 1;
                                      }
                                  </style>
                              @endif
                          @endforeach

                          @foreach($booked as $book)
                              @if($room_info->id == $book->room_id && $book->end_date >= date('Y-m-d'))
                                  <style>
                                      .add{
                                          display: none;
                                      }
                                      .error{
                                          color: red;
                                          opacity: 1;
                                      }
                                  </style>
                              @endif
                          @endforeach
                          <button type="submit" class="btn btn-success add" >ADD</button>
                          <button type="reset" class="btn btn-danger add" >RESET</button>
                          <p class="error">Sorry! The room not available right now</p>
                      </div>
                  </form>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/flatpickr.min.js')}}"></script>
<script src="{{asset('js/custom_datepicker.js')}}"></script>

@stop
