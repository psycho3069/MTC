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
                <div class="card-header"> <big> <strong>ADD NEW EMPLOYEE</strong> </big> </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/hr_payroll/employee/employees')}}" class="btn btn-primary">BACK</a>
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
              <form class="" action="{{ url('/save_employee') }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
                    <label for="name" class="col-md-4 col-form-label text-md-left">Employee Name: <span class="required">*</span></label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>

                <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-left">Date of Birth: <span class="required">*</span></label>
                    <input type="date" class="form-control date emp-date" name="date_of_birth" value="{{ date('Y-m-d') }}">
                </div>



                <div class="form-group row">
                    <label for="phone" class="col-md-4 col-form-label text-md-left">Phone No: <span class="required">*</span></label>
                    <div class="col-md-6">
                      <input type="number" class="form-control" id="phone" name="phone" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-md-4 col-form-label text-md-left">Address: <span class="required">*</span></label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="blood_group" class="col-md-4 col-form-label text-md-left">Blood Group: <span class="required">*</span></label>
                    <div class="col-md-6">
                      <select class="form-control"id="blood_group" name="blood_group" required>
                        <option  value="A+">A+</option>
                        <option  value="A-">A-</option>
                        <option  value="B+">B+</option>
                        <option  value="B-">B-</option>
                        <option  value="AB+">AB+</option>
                        <option  value="AB-">AB-</option>
                        <option  value="O+">O+</option>
                        <option  value="O-">O-</option>
                      </select>
                    </div>
                </div>

                <div class="form-group row">
                  <label for="department_id" class="col-md-4 col-form-label text-md-left">Department: <span class="required">*</span></label>
                  <div class="col-md-6">
                    <select id="department_id" name="department_id" class="form-control" required>
                      <option value>--Choose One--</option>
                      @foreach($department_info as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="designation_id" class="col-md-4 col-form-label text-md-left">Designation: <span class="required">*</span></label>
                  <div class="col-md-6">
                    <select id="designation_id" name="designation_id" class="form-control" required>
                      <option value>--Choose One--</option>
                      @foreach($employee_designation_info as $employee_designation)
                        <option value="{{ $employee_designation->id }}">{{ $employee_designation->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="salary_grade_id" class="col-md-4 col-form-label text-md-left">Salary Grade: <span class="required">*</span></label>
                  <div class="col-md-6">
                      @if(count($salary_grade_info)>0)
                          <select id="salary_grade_id" name="salary_grade_id" class="form-control">
                              <option value>--Choose One--</option>
                            @foreach($salary_grade_info as $salary_grade)
                                <option value="{{ $salary_grade->id }}">{{ $salary_grade->name }}</option>
                            @endforeach
                      @endif
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                    <label for="emergency_contact" class="col-md-4 col-form-label text-md-left">Emergency Contact: <span class="required">*</span></label>
                    <div class="col-md-6">
                      <input type="number" class="form-control" id="emergency_contact" name="emergency_contact" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="other" class="col-md-4 col-form-label text-md-left">Other:</label>
                    <div class="col-md-6">
                    <textarea type="text" class="form-control" id="other" name="other"></textarea>
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


