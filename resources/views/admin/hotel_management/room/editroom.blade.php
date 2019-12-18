@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"> <big> <strong>EDIT ROOM</strong> </big> </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/hotel_management/room/room_list')}}" class="btn btn-primary">Back</a>
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
                <form class="" action="{{ url('/updateroom',$room_info->id) }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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

									<!-- Name -->
                  <div class="form-group row">
                    <label for="room_no" class="col-md-4 col-form-label text-md-left">Name:</label>
                    <div class="col-md-6">
          						<input type="text" class="form-control" value="{{$room_info->room_no}}" id="room_no" name="room_no" required>
        						</div>
                  </div>

                  <!-- Price -->
                  <div class="form-group row">
                    <label for="price" class="col-md-4 col-form-label text-md-left">Price:</label>
                    <div class="col-md-6">
                      <input type="number" class="form-control" value="{{$room_info->price}}" id="price" name="price" required>
                    </div>
                  </div>

                  <!-- Cpacity -->
                  <div class="form-group row">
                    <label for="capacity" class="col-md-4 col-form-label text-md-left">Capacity:</label>
                    <div class="col-md-6">
                      <input type="number" class="form-control" value="{{$room_info->persons_capacity}}" id="capacity" name="capacity" required>
                    </div>
                  </div>

                  <!-- Type -->
                  <div class="form-group row">
	                  <label for="type_id"  class="col-md-4 col-form-label text-md-left">Room Category:</label>
	                  <div class="col-md-6">
	                  	<select id="type_id" name="type_id" class="form-control" required>
	                      <option>--Choose One--</option>
	                      @foreach($room_category_info_all as $row_type)
	                        <option value="{{ $row_type->id }}" @if($room_info->category_id == $row_type->id) {{ 'selected' }} @endif>{{ $row_type->name }}</option>
	                      @endforeach
	                    </select>
                      </div>
                  </div>

                  <!-- Floor -->
                  <div class="form-group row">
	                  <label for="floor_id"  class="col-md-4 col-form-label text-md-left">Floor:</label>
	                  <div class="col-md-6">
	                  	<select id="floor_id" name="floor_id" class="form-control" required>
	                      <option>--Choose One--</option>
	                      @foreach($floor_info_all as $row_floor)
	                        <option value="{{ $row_floor->id }}" @if($room_info->floor_id == $row_floor->id) {{ 'selected' }} @endif>{{ $row_floor->name }}</option>
	                      @endforeach
	                    </select>
                      </div>
                  </div>

                    <div class="form-group row">
                        <label for="image" class="col-md-4 col-form-label text-md-left">Image: <span style="opacity: .5">(700*438)</span></label>
                        <div class="col-md-6">
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                    </div>

                  <!-- Description -->
                  <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-left">Description:</label>
                    <div class="col-md-6">
                        <textarea id="description" name="description" type="text" cols="80" rows="4" placeholder="" class="form-control">{{$room_info->description}}</textarea>
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