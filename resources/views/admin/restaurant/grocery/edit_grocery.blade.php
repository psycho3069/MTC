@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><big><strong>EDIT GROCERY</strong></big></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/restaurant/grocery/groceries')}}" class="btn btn-primary">Back</a>
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
                <form class="" action="{{ url('/update_grocery',$grocery->id) }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
                    <label for="name">Grocery Name:</label>
                    <input type="text" class="form-control" value="{{$grocery->name}}" id="name" name="name" required>
                  </div>

                  <div class="form-group">
                    <label for="grocery_category_id">Grocery Category:</label>
                    <select id="grocery_category_id" name="grocery_category_id" class="form-control" required>
                      <option value>--Choose One--</option>
                      @foreach($grocery_category_info as $grocery_category)
                        <option value="{{ $grocery_category->id }}" 
                          @if($grocery->grocery_category_id == $grocery_category->id)
                            {{ 'Selected' }}
                          @endif
                          >{{ $grocery_category->name }}</option>
                      @endforeach
                    </select>
                  </div>



                  <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" type="text" cols="80" rows="4" placeholder="" class="form-control">{{$grocery->description}}</textarea>
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