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
                <div class="card-header">ADD VENUE BOOK</div>

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

  <form class="" id="validate" action="{{ url('/training/store_booking') }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
    @csrf
      <input type="hidden" name="mis_ac_head_id" value="2">

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
          <label for="start_date" class="col-md-4 col-form-label text-md-left">Start Date</label>
          <div class="col-md-6">
              <input class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" id="check_in_date" name="start_date" value="{{ old('start_date') }}" autocomplete="off" required>
              @if ($errors->has('start_date'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('start_date') }}</strong>
                </span>
              @endif
          </div>
      </div>

      <div class="form-group row">
          <label for="end_date" class="col-md-4 col-form-label text-md-left">End Date</label>
          <div class="col-md-6">
              <input class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" id="check_out_date" value="{{ old('end_date') }}" name="end_date" autocomplete="off" required>
              @if ($errors->has('date'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('date') }}</strong>
                  </span>
              @endif
          </div>
      </div>

      <div class="form-group row">
          <label for="name" class="col-md-4 col-form-label text-md-left">Organization Name</label>
          <div class="col-md-6">
              <input type="text" class="form-control{{ $errors->has('org_name') ? ' is-invalid' : '' }}" id="name" value="{{ old('org_name') }}" name="org_name">
              @if ($errors->has('org_name'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('org_name') }}</strong>
                </span>
              @endif
          </div>
      </div>

      <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-left">Person Name<span class="required">*</span></label>
        <div class="col-md-6">
            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" value="{{ old('name') }}" name="name" required>
              @if ($errors->has('name'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
        </div>
      </div>

      <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-left">Designation</label>
        <div class="col-md-6">
            <input type="text" class="form-control{{ $errors->has('designation') ? ' is-invalid' : '' }}" id="name" value="{{ old('designation') }}" name="designation">
              @if ($errors->has('designation'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('designation') }}</strong>
                </span>
              @endif
        </div>
      </div>

      <div class="form-group row">
        <label for="contact_no" class="col-md-4 col-form-label text-md-left">Contact No</label>
        <div class="col-md-6">
        <input type="number" class="form-control{{ $errors->has('contact_no') ? ' is-invalid' : '' }}" id="contact_no" value="{{ old('contact_no') }}" name="contact_no" required>
        @if ($errors->has('contact_no'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('contact_no') }}</strong>
            </span>
        @endif
      </div>
      </div>

      <div class="form-group row">
        <label for="venue_id" class="col-md-4 col-form-label text-md-left">Venue</label>
        <div class="col-md-6">
          <select id="venue_id" name="venue_id" class="form-control dynamic" data-dependent="actual_price" readonly required>
              <option value="{{ $allvenueinfo->id }}">{{ $allvenueinfo->name }}</option>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="actual_price" class="col-md-4 col-form-label text-md-left">Actual Price</label>
        <div class="col-md-6">
        <input type="text" name="actual_price" value="{{ $allvenueinfo->price }}" id="actual_price" class="form-control" readonly>
      </div>
      </div>

      <div class="form-group row">
          <label for="status" class="col-md-4 col-form-label text-md-left">Status</label>
          <div class="col-md-6">
              <select id="status" name="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" required readonly>
                  <option value="2">{{Config::get('constants.roomBookStatus.2')}}</option>
              </select>
              @if ($errors->has('status'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('status') }}</strong>
                  </span>
              @endif
          </div>
      </div>

      <div class="form-group row">
        <label for="amount" class="col-md-4 col-form-label text-md-left">Amount</label>
        <div class="col-md-6">
        <input type="number" class="form-control" id="amount" name="amount" value="0" required>
      </div>
      </div>

      <div class="form-group row">
        <label for="no_of_attendee" class="col-md-4 col-form-label text-md-left">No. of Attendee</label>
        <div class="col-md-6">
        <input type="text" class="form-control{{ $errors->has('no_of_attendee') ? ' is-invalid' : '' }}" id="no_of_attendee" name="no_of_attendee" value="{{ old('no_of_attendee') }}" required>
            @if ($errors->has('no_of_attendee'))
                <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('no_of_attendee') }}</strong>
            </span>
            @endif
      </div>
      </div>

      <select name="room_booking_id" id="room_booking_id" style="display: none; opacity: 0;">

      </select>

        <!-- Button -->
      <div class="form-group">
          @foreach($reserve as $value)
              @if($allvenueinfo->id == $value->venue_id && $value->end_date >= date('Y-m-d'))
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
              @if($allvenueinfo->id == $book->venue_id && $book->end_date >= date('Y-m-d'))
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
@endsection

@section('customscript')
    <script src="{{asset('js/flatpickr.min.js')}}"></script>
    <script src="{{asset('js/custom_datepicker.js')}}"></script>

    <script>
$(document).ready(function(){

         $('.dynamic').change(function(){
          if($(this).val() != '')
          {
           var select = $(this).attr("id");
           var value = $(this).val();
           var dependent = $(this).data('dependent');
           var _token = $('input[name="_token"]').val();
           $.ajax({
            url:"{{ route('dynamicdependent.fetch') }}",
            method:"GET",
            data:{select:select, value:value, _token:_token, dependent:dependent},
            success:function(result)
            {
             $('#'+dependent).val(result);
            }

           })
          }
         });
             $('#venue_id').change(function(){
              $('#actual_price').val('');
             });
        });

    </script>
@endsection
