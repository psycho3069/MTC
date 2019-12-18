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
                <div class="card-header"><strong><big>ADD VENUE BILLING</big></strong></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/training/venue-booking-list')}}" class="btn btn-primary">BACK</a>
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

                <form class="" action="{{ url('/training/storemakebilling/') }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
                            <input class="form-control" id="check_in_date" name="start_date" autocomplete="off" value="{{ $billing->start_date }}" readonly required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="end_date" class="col-md-4 col-form-label text-md-left">End Date:</label>
                        <div class="col-md-6">
                            <input class="form-control" id="check_out_date" name="end_date" value="{{ $billing->end_date }}" autocomplete="off" readonly required>
                        </div>
                    </div>
                    <script type = "text/javascript" >
                        var date1 = new Date("{{ $billing->start_date }}");
                        var date2 = new Date("{{ $billing->end_date }}");

                        var Difference_In_Time = (date2.getTime() + (1000 * 3600 * 24)) - date1.getTime();

                        var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

                        document.write("<div class='form-group row'>" +
                                "<label for='end_date' class='col-md-4 col-form-label text-md-left'>Total day:</label>" +
                                "<div class='col-md-6'>" +
                                "<input type='number' class='form-control' name='total_day' value="+ Difference_In_Days +" autocomplete='off' readonly>" +
                                "</div>" +
                                "</div>");
                    </script>
                    <div class="form-group row">
                      <label for="booking_id" class="col-md-4 col-form-label text-md-left">Venue Booking id:</label>
                      <div class="col-md-6">
                      <input type="text" class="form-control" id="venue_booking_id" name="venue_booking_id" value="{{ $billing->id }}" readonly required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="guest_name" class="col-md-4 col-form-label text-md-left">Guest Name:</label>
                      <div class="col-md-6">
                      <input type="text" class="form-control" id="guest_name" name="guest_name" value="{{ $billing->name }}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="contact_no" class="col-md-4 col-form-label text-md-left">Contact No:</label>
                      <div class="col-md-6">
                      <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ $billing->contact_no }}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="venue_id" class="col-md-4 col-form-label text-md-left">Venue:</label>
                      <div class="col-md-6">
                          <select name="venue_id" id="" class="form-control" readonly>
                              @foreach($allvenueinfo as $row)
                                  @if($row->id == $billing->venue_id)
                                      <option value="{{ $row->id }}">{{ $row->name }}</option>
                                  @endif
                              @endforeach
                          </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="status" class="col-md-4 col-form-label text-md-left">Status:</label>
                      <div class="col-md-6">

                          <select id="status" name="status" class="form-control" required>
                              <option value>--Choose One--</option>
                              <option value="1"
                              @if($billing->status == '1')
                                  {{'Selected'}}
                                      @endif
                                      >{{Config::get('constants.roomBookStatus.1')}}</option>
                              <option value="2"
                              @if($billing->status == '2')
                                  {{'Selected'}}
                                      @endif
                                      >{{Config::get('constants.roomBookStatus.2')}}</option>
                              <option value="3"
                              @if($billing->status == '3')
                                  {{'Selected'}}
                                      @endif
                                      >{{Config::get('constants.roomBookStatus.3')}}</option>
                          </select>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="add_pay" class="col-md-4 col-form-label text-md-left">Advance Payment:</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" id="add_pay" name="advanced_pay" value="{{ $billing->amount }}" required>
                        </div>
                    </div>

                    @foreach($allvenueinfo as $info)
                        @if($billing->venue_id == $info->id)
                            <script type = "text/javascript" >
                                var date1 = new Date("{{ $billing->start_date }}");
                                var date2 = new Date("{{ $billing->end_date }}");

                                var price = "{{ $info->price }}"

                                var Difference_In_Time = (date2.getTime() + (1000 * 3600 * 24)) - date1.getTime();

                                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                                var total_cost = price * Difference_In_Days;

                                document.write("<div class='form-group row'>" +
                                        "<label for='end_date' class='col-md-4 col-form-label text-md-left'>Total Payment:</label>" +
                                        "<div class='col-md-6'>" +
                                        "<input type='text' class='form-control' id='total_pay' name='total_pay' value="+ total_cost + " autocomplete='off' required>" +
                                        "</div>" +
                                        "</div>");

                            </script>
                        @endif
                    @endforeach

                    @foreach($allvenueinfo as $venue)
                        @if($billing->venue_id == $venue->id)
                            <script type = "text/javascript" >
                                var date1 = new Date("{{ $billing->start_date }}");
                                var date2 = new Date("{{ $billing->end_date }}");

                                var price = "{{ $venue->price }}"
                                var add_pay = "{{ $billing->amount }}"

                                var Difference_In_Time = (date2.getTime() + (1000 * 3600 * 24)) - date1.getTime();

                                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                                var total_cost = price * Difference_In_Days;
                                var due_amount = total_cost - add_pay;

                                document.write("<div class='form-group row'>" +
                                        "<label for='end_date' class='col-md-4 col-form-label text-md-left'>Due Amount:</label>" +
                                        "<div class='col-md-6'>" +
                                        "<input type='text' class='form-control' value="+ due_amount + '/-'+ " autocomplete='off' readonly>" +
                                        "</div>" +
                                        "</div>");

                            </script>
                        @endif
                    @endforeach

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