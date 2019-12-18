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
                <div class="card-header"><strong><big>MAKE ROOM BOOKING</big></strong></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/hotel_management/reservation/room_reservation_list')}}" class="btn btn-primary">BACK</a>
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
               
                <form class="" action="{{ url('/savebooking') }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
                        <label for="start_date" class="col-md-4 col-form-label text-md-left">Date/Start Date:</label>
                        <div class="col-md-6">
                            <input class="form-control" id="check_in_date" name="start_date" autocomplete="off" value="{{ $reservation_info->start_date }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="end_date" class="col-md-4 col-form-label text-md-left">End Date:</label>
                        <div class="col-md-6">
                            <input class="form-control" value="{{ $reservation_info->end_date }}" id="check_out_date" name="end_date" autocomplete="off" required >
                        </div>
                    </div>

                    <div class="form-group row">
                      <label for="guest_name" class="col-md-4 col-form-label text-md-left">Guest Name:</label>
                      <div class="col-md-6">
                      <input type="text" class="form-control" id="guest_name" name="guest_name" value="{{ $reservation_info->guest_name }}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="contact_no" class="col-md-4 col-form-label text-md-left">Contact No:</label>
                      <div class="col-md-6">
                      <input type="text" class="form-control" id="contact_no" name="guest_contact" value="{{ $reservation_info->guest_contact }}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="room_id" class="col-md-4 col-form-label text-md-left">Room No:</label>
                      <div class="col-md-6">
                        <select id="room_id" name="room_id" class="form-control" readonly required>
                          @foreach($room_info as $row_room)
                                @foreach($room_category as $value)
                                    @if($row_room->category_id == $value->id)
                                        @if($reservation_info->room_id == $row_room->id)
                                        <option value="{{ $row_room->id }}" selected>
                                            {{ $row_room->room_no }} -- {{ $value->name }}
                                        </option>
                                        @endif
                                    @endif
                                @endforeach
                          @endforeach
                        </select>

                      </div>
                    </div>

                    @foreach($room_info as $row_room)
                        @if($reservation_info->room_id == $row_room->id)
                            <script type = "text/javascript" >
                                var date1 = new Date("{{ $reservation_info->start_date }}");
                                var date2 = new Date("{{ $reservation_info->end_date }}");

                                var price = "{{ $row_room->price }}"

                                var Difference_In_Time = (date2.getTime() + (1000 * 3600 * 24)) - date1.getTime();

                                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                                var total_cost = price * Difference_In_Days;

                                document.write("<div class='form-group row'>" +
                                        "<label for='end_date' class='col-md-4 col-form-label text-md-left'>Total Cost:</label>" +
                                        "<div class='col-md-6'>" +
                                        "<input type='text' class='form-control' value="+ total_cost + '/-'+ " autocomplete='off' readonly>" +
                                        "</div>" +
                                        "</div>");

                            </script>
                        @endif
                    @endforeach

                    <div class="form-group row">
                      <label for="status" class="col-md-4 col-form-label text-md-left">Status:</label>
                      <div class="col-md-6">

                        <select id="status" name="status" class="form-control" required>
                          <option value>--Choose One--</option>
                            <option value="1">{{Config::get('constants.roomBookStatus.1')}}</option>
                            <option value="2">{{Config::get('constants.roomBookStatus.2')}}</option>
                             <option value="3">{{Config::get('constants.roomBookStatus.3')}}</option>
                        </select>
                        
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="amount" class="col-md-4 col-form-label text-md-left">Amount:</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" id="amount" name="amount" value="">
                        </div>
                    </div>

                      <!-- Button -->
                      <div class="form-group">
                          <button type="submit" class="btn btn-success" >ADD</button>
                          <button type="reset" class="btn btn-danger" >RESET</button>
                      </div>

                      
                  </form>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/flatpickr.min.js')}}"></script>
<script src="{{asset('js/custom_datepicker.js')}}"></script>

@endsection