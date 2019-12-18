@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"> <big> <strong>EDIT USER</strong> </big> </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/admin/user/user')}}" class="btn btn-primary">Back</a>
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

                <!---------------FORM--------------->
                <form class="" action="{{ url('/update_user',$all_users_info->id) }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
                    <label for="name" class="col-md-2 col-form-label text-md-left">Name:</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" value="{{$all_users_info->name}}" id="name" name="name" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="location" class="col-md-2 col-form-label text-md-left">Email:</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" value="{{$all_users_info->email}}" id="email" name="email" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="role" class="col-md-2 col-form-label text-md-left">{{ __('Role') }}</label>
                    <div class="col-md-8">
                        <select id="role" name="role" class="form-control" required>
                          <option value>--Choose One--</option>
                            @foreach($role_info as $row)
                              <option value="{{ $row->id }}" @if($row->id == $all_users_info->role_id) {{ 'selected' }} @endif>{{ $row->name }}</option>
                            @endforeach
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
@endsection