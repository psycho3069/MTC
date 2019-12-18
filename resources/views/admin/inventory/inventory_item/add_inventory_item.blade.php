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
                <div class="card-header"> <big> <strong>ADD NEW INVENTORY ITEM</strong> </big> </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/inventory/inventory_item/inventory_items')}}" class="btn btn-primary">BACK</a>
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
              <form class="" action="{{ url('/save_inventory_item') }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
                    <label for="name" class="col-md-4 col-form-label text-md-left">Inventory Name: <span class="required">*</span></label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>

                <div class="form-group row">
                  <label for="inventory_category_id" class="col-md-4 col-form-label text-md-left">Category Name: <span class="required">*</span></label>
                  <div class="col-md-6">
                    <select id="inventory_category_id" name="inventory_category_id" class="form-control" required>
                      <option value>--Choose One--</option>
                      @foreach($inventory_category_info as $inventory_category)
                        <option value="{{ $inventory_category->id }}">{{ $inventory_category->name }}</option>
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