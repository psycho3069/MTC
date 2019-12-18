@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"> <big> <strong>EDIT USER ROLE</strong> </big> </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/admin/user_role/userrole')}}" class="btn btn-primary">Back</a>
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
 
  <form class="" action="{{ url('/update_user_role',$all_userrole_info->id) }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">

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

      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" value="{{$all_userrole_info->name}}" id="name" name="name" required>
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <input type="text" class="form-control" value="{{$all_userrole_info->description}}" id="description" name="description" required>
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