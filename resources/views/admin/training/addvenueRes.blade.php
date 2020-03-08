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
                <div class="card-header">ADD VENUE RESERVATION</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/training/venueRes')}}" class="btn btn-primary">BACK</a>
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

  <form class="" action="{{ url('/savevenueRes') }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
          <label for="start_date" class="col-md-4 col-form-label text-md-left">Start Date<span class="required">*</span></label>
          <div class="col-md-6">
              <input class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" id="check_in_date" name="start_date" value="{{ old('start_date') }}" autocomplete="off" required>
          </div>
      </div>

      <div class="form-group row">
          <label for="end_date" class="col-md-4 col-form-label text-md-left">End Date<span class="required">*</span></label>
          <div class="col-md-6">
              <input class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" id="check_out_date" value="{{ old('end_date') }}" name="end_date" autocomplete="off">
          </div>
      </div>

      <div class="form-group row">
          <label for="org_name" class="col-md-4 col-form-label text-md-left">Organization Name</label>
          <div class="col-md-6">
              <input type="text" class="form-control{{ $errors->has('org_name') ? ' is-invalid' : '' }}" id="org_name" value="{{ old('org_name') }}" name="org_name">
          </div>
      </div>

      <div class="form-group row">
          <label for="name" class="col-md-4 col-form-label text-md-left">Person Name<span class="required">*</span></label>
          <div class="col-md-6">
              <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" value="{{ old('name') }}" name="name">
          </div>
      </div>

      <div class="form-group row">
          <label for="Designation" class="col-md-4 col-form-label text-md-left">Designation</label>
          <div class="col-md-6">
              <input type="text" class="form-control{{ $errors->has('Designation') ? ' is-invalid' : '' }}" id="Designation" value="{{ old('Designation') }}" name="Designation" required>
          </div>
      </div>

      <div class="form-group row">
        <label for="contact_no" class="col-md-4 col-form-label text-md-left">Contact No</label>
        <div class="col-md-6">
        <input type="text" class="form-control{{ $errors->has('contact_no') ? ' is-invalid' : '' }}" value="{{ old('contact_no') }}" id="contact_no" name="contact_no" required>
      </div>
      </div>

      <div class="form-group row">
        <label for="venue_id" class="col-md-4 col-form-label text-md-left">Venue</label>
        <div class="col-md-6">
          <select id="venue_id" name="venue_id" class="form-control dynamic" data-dependent="actual_price" required>
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
        <label for="price" class="col-md-4 col-form-label text-md-left">Client Price</label>
        <div class="col-md-6">
        <input type="text" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" id="price" value="{{ old('price') }}" name="price" required>
      </div>
      </div>

      <div class="form-group row">
        <label for="no_of_attendee" class="col-md-4 col-form-label text-md-left">No. of Attendee</label>
        <div class="col-md-6">
        <input type="text" class="form-control{{ $errors->has('no_of_attendee') ? ' is-invalid' : '' }}" value="{{ old('no_of_attendee') }}" id="no_of_attendee" name="no_of_attendee" required>
      </div>
      </div>

      <div class="form-group row">
        <label for="status" class="col-md-4 col-form-label text-md-left">Status</label>
        <div class="col-md-6">
        <select id="status" name="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" required>
          <option value>--Choose One--</option>
            <option value="1">{{Config::get('constants.venueResStatus.1')}}</option>
        </select>
      </div>
      </div>


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
