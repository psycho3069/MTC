@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><big><strong>EDIT SALARY GRADE</strong></big></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/hr_payroll/salary_grade/salary_grades')}}" class="btn btn-primary">Back</a>
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
                <form class="" action="{{ url('/update_salary_grade',$salary_grade->id) }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
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
                    <label for="name" class="col-md-4 col-form-label text-md-left">Name:</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" value="{{$salary_grade->name}}" id="name" name="name" required>
                    </div>
                </div>

                <div class="form-group row">
                  <label for="type" class="col-md-4 col-form-label text-md-left">Type:</label>
                  <div class="col-md-6">
                    <select id="type" name="type" class="form-control" required>
                      <option value>--Choose One--</option>
                      <option value="1"
                        @if($salary_grade->type == 1)
                          {{ 'Selected' }}
                        @endif
                      >{{Config::get('constants.hrSalaryGradeType.1')}}</option>
                      <option value="2"
                        @if($salary_grade->type == 2)
                          {{ 'Selected' }}
                        @endif
                      >{{Config::get('constants.hrSalaryGradeType.2')}}</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                    <label for="provident_fund" class="col-md-4 col-form-label text-md-left">Provident Fund:</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" id="provident_fund" value="{{$salary_grade->provident_fund}}" name="provident_fund" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="basic_salary" class="col-md-4 col-form-label text-md-left">Basic Salary:</label>
                    <div class="col-md-6">
                    <input type="text" class="form-control" id="basic_salary" value="{{$salary_grade->basic_salary}}" name="basic_salary">
                  </div>
                </div>

                <div class="form-group row">
                    <label for="transportation_allowance" class="col-md-4 col-form-label text-md-left">Transportation Allowance:</label>
                    <div class="col-md-6">
                    <input type="text" class="form-control" id="transportation_allowance" value="{{$salary_grade->transportation_allowance}}" name="transportation_allowance">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="dinning_allowance" class="col-md-4 col-form-label text-md-left">Dinning Allowance:</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="dinning_allowance" value="{{$salary_grade->dinning_allowance}}" name="dinning_allowance">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="other_allowance" class="col-md-4 col-form-label text-md-left">Other Allowance:</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="other_allowance" value="{{$salary_grade->other_allowance}}" name="other_allowance">
                  </div>
                </div>

                <div class="form-group row">
                    <label for="home_rent" class="col-md-4 col-form-label text-md-left">Home Rent:</label>
                    <div class="col-md-6">
                    <input type="text" class="form-control" id="home_rent" value="{{$salary_grade->home_rent}}" name="home_rent">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="gross_salary" class="col-md-4 col-form-label text-md-left">Gross Salary:</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="gross_salary" value="{{$salary_grade->gross_salary}}" name="gross_salary">
                  </div>
                </div>

                <div class="form-group row">
                    <label for="note" class="col-md-4 col-form-label text-md-left">Note:</label>
                    <div class="col-md-6">
                    <input type="text" class="form-control" id="note" value="{{$salary_grade->note}}" name="note">
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