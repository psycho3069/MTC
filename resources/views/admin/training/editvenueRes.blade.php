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
                <div class="card-header">EDIT VENUE RESERVATION</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/training/venueRes')}}" class="btn btn-primary">Back</a>
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
 
  <form class="" action="{{ url('/update_venueres',$allvenueresinfo->id) }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
    {{ csrf_field() }}    

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
              <input class="form-control" value="{{$allvenueresinfo->start_date}}" id="check_in_date" name="start_date" autocomplete="off" required>
          </div>
      </div>

      <div class="form-group row">
          <label for="end_date" class="col-md-4 col-form-label text-md-left">End Date:</label>
          <div class="col-md-6">
              <input class="form-control" value="{{$allvenueresinfo->end_date}}" id="check_out_date" name="end_date" autocomplete="off">
          </div>
      </div>

      <div class="form-group row">
          <label for="org_name" class="col-md-4 col-form-label text-md-left">Org Name:</label>
          <div class="col-md-6">
              <input type="text" class="form-control" value="{{$allvenueresinfo->org_name}}" id="org_name" name="org_name" required>
          </div>
      </div>

      <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-left">Persion Name:</label>
        <div class="col-md-6">
        <input type="text" class="form-control" value="{{$allvenueresinfo->name}}" id="name" name="name" required>
      </div>
      </div>

      <div class="form-group row">
        <label for="contact_no" class="col-md-4 col-form-label text-md-left">Contact No:</label>
        <div class="col-md-6">
        <input type="text" class="form-control" value="{{$allvenueresinfo->contact_no}}" id="contact_no" name="contact_no" required>
      </div>
      </div>

      <div class="form-group row">
        <label for="venue_id" class="col-md-4 col-form-label text-md-left">Venue:</label>
        <div class="col-md-6">
        <select id="venue_id" name="venue_id" class="form-control dynamic" data-dependent="actual_price" required>
          <option value>--Choose One--</option>
          @foreach($allvenueinfo as $row)
            <option value="{{ $row->id }}"
             @if($row->id == $allvenueresinfo->venue_id)
               {{'Selected'}}
             @endif
            >{{ $row->name }}</option>
          @endforeach
        </select>
      </div>
      </div>

      <div class="form-group row">
        <label for="actual_price" class="col-md-4 col-form-label text-md-left">Actual Price:</label>
        <div class="col-md-6">
          @foreach($allvenueinfo as $row)
            @if($row->id == $allvenueresinfo->venue_id)
              @php
               $actual_price = $row->price;
               echo '<input type="text" name="actual_price" value="'.$actual_price.'" id="actual_price" class="form-control" readonly>';
               @endphp
            @endif
          @endforeach
      </div>
      </div>

      <div class="form-group row">
        <label for="price" class="col-md-4 col-form-label text-md-left">Client Price:</label>
        <div class="col-md-6">
        <input type="text" class="form-control" value="{{$allvenueresinfo->price}}" id="price" name="price" required>
      </div>
      </div>

      <div class="form-group row">
        <label for="no_of_attendee" class="col-md-4 col-form-label text-md-left">No. of Attendee:</label>
        <div class="col-md-6">
        <input type="text" class="form-control" value="{{$allvenueresinfo->no_of_attendee}}" id="no_of_attendee" name="no_of_attendee" required>
      </div>
      </div>

      <div class="form-group row">
        <label for="status" class="col-md-4 col-form-label text-md-left">Status:</label>
        <div class="col-md-6">
        <select id="status" name="status" class="form-control" required>
          <option value>--Choose One--</option>
            <option value="1"
            @if($allvenueresinfo->status == '1')
               {{'Selected'}}
             @endif
             >{{Config::get('constants.venueResStatus.1')}}</option>
            <option value="2"
            @if($allvenueresinfo->status == '2')
               {{'Selected'}}
             @endif
             >{{Config::get('constants.venueResStatus.2')}}</option>
             <option value="3"
             @if($allvenueresinfo->status == '3')
               {{'Selected'}}
             @endif
             >{{Config::get('constants.venueResStatus.3')}}</option>
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

@section('customscript')
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