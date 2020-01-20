@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><big> <strong>EMPLOYEES</strong> </big></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <a href="{{URL::to('/hr_payroll/employee/add_employee')}}" class="btn btn-primary">Add New Employee</a>
                </div>

                <p class="alert-success" style="font-size: 20px; color: white; background:#149278; padding: 0 30px 0 30px;">
                    @php
                      $message=Session::get('message');
                        if($message) {
                          echo $message;
                          Session::put('message',null);
                        }
                    @endphp
                </p>

                <table id="employee" class="table table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Blood Group</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Salary Grade</th>
                        <th>Emergency Contact</th>
                        <th>Other</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($employees_info as $key => $employee)
                    <tr>
                        <td width="5%">{{ ++$key }}</td>
                        <td>{{$employee->name}}</td>
                        <td width="25%">{{ date('d-m-y', strtotime($employee->date_of_birth)) }}</td>
                        <td>{{$employee->phone}}</td>
                        <td>{{$employee->address}}</td>
                        <td>{{$employee->blood_group}}</td>
                        <td>
                            @foreach($department_info as $department)
                                @if($department->id == $employee->department_id)
                                    {{$department->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($employee_designation_info as $employee_designation)
                                @if($employee_designation->id == $employee->designation_id)
                                    {{$employee_designation->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                        	@foreach($salary_grade_info as $salary_grade)
                                @if($salary_grade->id == $employee->salary_grade_id)
                                    {{$salary_grade->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{$employee->emergency_contact}}</td>
                        <td>{{$employee->other}}</td>
                        <td width="15%" align="right">
                          <a href="{{URL::to('edit_employee/'.$employee->id)}}" class="btn btn-sm btn-info">Edit</a>
                          <a href="{{URL::to('delete_employee/'.$employee->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection

@section('datatable')

<!-- datatable -->
{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#employee').DataTable({
            "paging": true,
            "ordering":  true,
            "pagingType": "full_numbers"
          });
    } );
</script>

@endsection
