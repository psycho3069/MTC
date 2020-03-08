@extends('admin.master')

@section('content')
    <style>
        .required{
            color: #ff0000;
        }

        span.month {
            border: 1px solid #fff;
            margin: 2px;
            padding: 3px;
            background: #636363;
            color: #fff;
            cursor: pointer;
        }
        span.year {
            border: 1px solid #fff;
            margin: 2px;
            padding: 3px;
            background: #636363;
            color: #fff;
            cursor: pointer;
        }
        span.decade {
            border: 1px solid #fff;
            margin: 2px;
            padding: 3px;
            background: #636363;
            color: #fff;
            cursor: pointer;
        }
        span.century {
            border: 1px solid #fff;
            margin: 2px;
            padding: 3px;
            background: #636363;
            color: #fff;
            cursor: pointer;
        }
        td {
            border: 1px solid #fff;
            background: #797a80bd;
            color: #fff;
            cursor: pointer;
        }
        th.dow {
            border: 1px solid #fff;
            background: #9ed8ef;
            cursor: pointer;
        }
        th.datepicker-switch {
            cursor: pointer;
            background: #f5f0f0;
        }
    </style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"> <big> <strong>ADD NEW LEAVE</strong> </big> </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/hr_payroll/leave/leaves')}}" class="btn btn-primary">BACK</a>
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
              <form class="" action="{{ url('/save_leave') }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
                    <label for="name" class="col-md-4 col-form-label text-md-left">Leave Name: <span class="required">*</span></label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>

                <!-- <div class="form-group row">
                      <label for="duration" class="col-md-4 col-form-label text-md-left">Duration:</label>
                      <div class="col-md-6">
                      <input type="text" class="form-control" id="duration" name="duration" required>
                    </div>
                </div> -->

                <div class="form-group row">
                  <label for="start_date" class="col-md-4 col-form-label text-md-left">Date/Start Date: <span class="required">*</span></label>
                  <div class="col-md-6">
                    <input type="text" class="form-control datepicker" id="start_date" name="start_date" autocomplete="off" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="end_date" class="col-md-4 col-form-label text-md-left">End Date:</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control datepicker" id="end_date" name="end_date" autocomplete="off">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="leave_category_id" class="col-md-4 col-form-label text-md-left">Leave Category: <span class="required">*</span></label>
                  <div class="col-md-6">
                    <select id="leave_category_id" name="leave_category_id" class="form-control" required>
                      <option value>--Choose One--</option>
                      @foreach($leave_category_info as $leave_category)
                        <option value="{{ $leave_category->id }}">{{ $leave_category->name }}</option>
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