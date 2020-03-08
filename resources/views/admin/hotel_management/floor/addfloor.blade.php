@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"> <big> <strong>ADD NEW FLOOR</strong> </big> </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/hotel_management/floor/floor_list')}}" class="btn btn-primary">BACK</a>
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
              <form class="" action="{{ url('/savefloor') }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
                    <label for="name" class="col-md-4 col-form-label text-md-left">Floor Name:</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>

                <div class="form-group row">
                  <label for="type_id" class="col-md-4 col-form-label text-md-left">Floor Type:</label>
                  <div class="col-md-6">
                    <select id="type_id" name="type_id" class="form-control" required>
                      <option value>--Choose One--</option>
                      @foreach($floor_type_info as $row)
                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="building_id" class="col-md-4 col-form-label text-md-left">Building Name:</label>
                  <div class="col-md-6">
                    <select id="building_id" name="building_id" class="form-control" required>
                      <option value>--Choose One--</option>
                      @foreach($building_info as $row)
                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-left">Description:</label>
                    <div class="col-md-6">
                    <textarea type="text" class="form-control" id="description" name="description"></textarea>
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