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
            <div class="card">
                <div class="card-header"><strong><big>ADD ROOM BOOKING</big></strong></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if(Auth::user())
                        <a href="{{URL::to('/hotel_management/booking/booking_list')}}" class="btn btn-primary">BACK</a>
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

                <form class="" action="{{ url('/savebooking') }}" method="post" autocomplete="off" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
                            <input class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" id="check_in_date" name="start_date" value="{{ old('start_date') }}" autocomplete="off" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="end_date" class="col-md-4 col-form-label text-md-left">End Date:</label>
                        <div class="col-md-6">
                            <input class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" id="check_out_date" autocomplete="off" value="{{ old('end_date') }}" name="end_date" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="guest_name" class="col-md-4 col-form-label text-md-left">Guest Name:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control{{ $errors->has('guest_name') ? ' is-invalid' : '' }}" id="guest_name" value="{{ old('guest_name') }}" name="guest_name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="guest_contact" class="col-md-4 col-form-label text-md-left">Contact No:</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control{{ $errors->has('guest_contact') ? ' is-invalid' : '' }}" id="guest_contact" value="{{ old('guest_contact') }}" name="guest_contact" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="room_id" class="col-md-4 col-form-label text-md-left">Room No:</label>
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
                        <label for="room_id" class="col-md-4 col-form-label text-md-left">Unit Price:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $room_info->price }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-left">Status:</label>
                        <div class="col-md-6">
                            <select id="status" name="status" class="form-control" required readonly>
                                <option value="2" selected>{{Config::get('constants.roomBookStatus.2')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="amount" class="col-md-4 col-form-label text-md-left">Amount:</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') }}" id="amount" name="amount" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="amount" class="col-md-4 col-form-label text-md-left">Payment Method:</label>
                        <div class="col-md-6">
                            <label for=""><input type="radio" name="payment_method"  id="payment_method" required checked> Bkash</label>&nbsp;&nbsp;
                            <label for=""><input type="radio" name="payment_method"  id="payment_method"> Rocket</label>&nbsp;&nbsp;
                            <label for=""><input type="radio" name="payment_method"  id="payment_method"> Debit Card </label>
                        </div>
                    </div>

                    <select name="venue_booking_id" id="venue_booking_id" style="display: none; opacity: 0;">

                    </select>

                    <!-- Button -->
                    <div class="form-group">
                        @foreach($reserve as $value)
                            @if(($room_info->id == $value->room_id && $value->end_date >= date('Y-m-d')))
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
                            @if(($room_info->id == $book->room_id && $book->end_date >= date('Y-m-d')))
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
<script>
    $(document).ready(function(){

        fetch_customer_data();

        function fetch_customer_data(query = '')
        {
            $.ajax({
                url:"{{ route('live_search.action') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#venue_booking_id').html(data.select_data);
                }
            })
        }

        $(document).on('keyup', '#guest_contact', function(){
            var query = $(this).val();
            fetch_customer_data(query);
        });
    });
</script>
@endsection
