@extends('admin.master')

@section('content')
    <style>
        .required{
            color: #ff0000;
        }
    </style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">ADD USER</div>

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

  <!--form-->
 
  <form class="" action="{{ url('/saveuser') }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
        <label for="name" class="col-md-4 col-form-label text-md-left">{{ __('Name') }} <span class="required">*</span> </label>
        <div class="col-md-6">
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
        </div>
      </div>

      <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-left">{{ __('E-Mail Address') }} <span class="required">*</span></label>
        <div class="col-md-6">
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
      </div>

      <div class="form-group row">
        <label for="role_id" class="col-md-4 col-form-label text-md-left">{{ __('Role') }} <span class="required">*</span></label>
        <div class="col-md-6">
            <select id="role_id" name="role_id" class="form-control" required>
              <option value>--Choose One--</option>
                @foreach($role_info as $row)
                  <option value="{{ $row->id }}">{{ $row->name }}</option>
                @endforeach
            </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-left">{{ __('Password') }} <span class="required">*</span></label>
        <div class="col-md-6">
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
        </div>
      </div>

      <div class="form-group row">
        <label for="password-confirm" class="col-md-4 col-form-label text-md-left">{{ __('Confirm Password') }} <span class="required">*</span></label>
        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
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
@endsection