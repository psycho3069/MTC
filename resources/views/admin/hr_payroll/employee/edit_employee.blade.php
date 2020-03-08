@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><big><strong>EDIT EMPLOYEE</strong></big></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/hr_payroll/employee/employees')}}" class="btn btn-primary">Back</a>
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
                <form class="" action="{{ url('/update_employee',$employee->id) }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
                    <label for="name" class="col-md-4 col-form-label text-md-left">Employee Name:</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" value="{{$employee->name}}" id="name" name="name" required>
                    </div>
                </div>

                <div class="form-group row">
                      <label for="date_of_birth" class="col-md-4 col-form-label text-md-left">Date of Birth:</label>
                      <div class="col-md-6">
                      <input type="text" class="form-control datepicker" value="{{$employee->date_of_birth}}" id="date_of_birth" name="date_of_birth" autocomplete="off" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-md-4 col-form-label text-md-left">Phone No:</label>
                    <div class="col-md-6">
                      <input type="number" class="form-control" value="{{$employee->phone}}" id="phone" name="phone" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-md-4 col-form-label text-md-left">Address:</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" value="{{$employee->address}}" id="address" name="address" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="blood_group" class="col-md-4 col-form-label text-md-left">Blood Group:</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" value="{{$employee->blood_group}}" id="blood_group" name="blood_group" required>
                    </div>
                </div>

                <div class="form-group row">
                  <label for="department_id" class="col-md-4 col-form-label text-md-left">Department:</label>
                  <div class="col-md-6">
                    <select id="department_id" name="department_id" class="form-control" required>
                      <option value>--Choose One--</option>
                      @foreach($department_info as $department)
                        <option value="{{ $department->id }}"
                          @if($department->id == $employee->department_id)
                            {{ 'Selected' }}
                          @endif
                          >{{ $department->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="designation_id" class="col-md-4 col-form-label text-md-left">Designation:</label>
                  <div class="col-md-6">
                    <select id="designation_id" name="designation_id" class="form-control" required>
                      <option value>--Choose One--</option>
                      @foreach($employee_designation_info as $employee_designation)
                        <option value="{{ $employee_designation->id }}"
                          @if($employee_designation->id == $employee->designation_id)
                            {{ 'Selected' }}
                          @endif
                          >{{ $employee_designation->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="salary_grade_id" class="col-md-4 col-form-label text-md-left">Salary Grade:</label>
                  <div class="col-md-6">
                    <select id="salary_grade_id" name="salary_grade_id" class="form-control" required>
                      <option value>--Choose One--</option>
                      @foreach($salary_grade_info as $salary_grade)
                        <option value="{{ $salary_grade->id }}"
                          @if($salary_grade->id == $employee->salary_grade_id)
                            {{ 'Selected' }}
                          @endif
                          >{{ $salary_grade->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                    <label for="emergency_contact" class="col-md-4 col-form-label text-md-left">Emergency Contact:</label>
                    <div class="col-md-6">
                      <input type="number" class="form-control" value="{{$employee->emergency_contact}}" id="emergency_contact" name="emergency_contact" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="other" class="col-md-4 col-form-label text-md-left">Other:</label>
                    <div class="col-md-6">
                    <textarea type="text" class="form-control" id="other" name="other">{{$employee->other}}</textarea>
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