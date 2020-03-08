@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">EDIT VENUE</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/training/venue')}}" class="btn btn-primary">Back</a>
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
 
  <form class="" action="{{ url('/update_venue',$allvenueinfo->id) }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
        <label for="name" class="col-md-4 col-form-label text-md-left">Venue Name:</label>
        <div class="col-md-6">
        <input type="text" class="form-control" value="{{$allvenueinfo->name}}" id="name" name="name" required>
      </div>
      </div>

      <div class="form-group row">
        <label for="location" class="col-md-4 col-form-label text-md-left">Location:</label>
        <div class="col-md-6">
        <input type="text" class="form-control" value="{{$allvenueinfo->location}}" id="location" name="location" required>
      </div>
      </div>

      <div class="form-group row">
        <label for="price" class="col-md-4 col-form-label text-md-left">Price:</label>
        <div class="col-md-6">
        <input type="number" class="form-control" value="{{$allvenueinfo->price}}" id="price" name="price" required>
      </div>
      </div>

      <div class="form-group row">
        <label for="feature" class="col-md-4 col-form-label text-md-left">Feature:</label>
        <div class="col-md-6">
        <textarea id="feature" name="feature" cols="80" rows="4" placeholder="" class="form-control" required>{{$allvenueinfo->feature}}</textarea>
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
@endsection