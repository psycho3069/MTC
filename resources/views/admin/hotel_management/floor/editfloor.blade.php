@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"> <big> <strong>EDIT FLOOR</strong> </big> </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/hotel_management/floor/floor_list')}}" class="btn btn-primary">Back</a>
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
                <form class="" action="{{ url('/updatefloor',$floor_info->id) }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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

									<!-- Name -->
                  <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-left">Name:</label>
                    <div class="col-md-6">
          						<input type="text" class="form-control" value="{{$floor_info->name}}" id="name" name="name" required>
        						</div>
                  </div>

                  <!-- Type -->
                  <div class="form-group row">
	                  <label for="type_id"  class="col-md-4 col-form-label text-md-left">Floor Type:</label>
	                  <div class="col-md-6">
	                  	<select id="type_id" name="type_id" class="form-control" required>
	                      <option>--Choose One--</option>
	                      @foreach($floor_type_info_all as $row_type)
	                        <option value="{{ $row_type->id }}" @if($floor_info->floor_type == $row_type->id){{ 'selected' }}@endif>{{ $row_type->name }}</option>
	                      @endforeach
	                    </select>
        						</div>
                  </div>

                  <!-- Building -->
                  <div class="form-group row">
	                  <label for="building_id"  class="col-md-4 col-form-label text-md-left">Building:</label>
	                  <div class="col-md-6">
	                  	<select id="building_id" name="building_id" class="form-control" required>
	                      <option>--Choose One--</option>
	                      @foreach($building_info_all as $row_building)
	                        <option value="{{ $row_building->id }}" @if($floor_info->building_id == $row_building->id){{ 'selected' }}@endif>{{ $row_building->name }}</option>
	                      @endforeach
	                    </select>
        						</div>
                  </div>

                  <!-- Description -->
                  <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-left">Description:</label>
                    <div class="col-md-6">
          						<textarea id="description" name="description" type="text" cols="80" rows="4" placeholder="" class="form-control">{{$floor_info->description}}</textarea>
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