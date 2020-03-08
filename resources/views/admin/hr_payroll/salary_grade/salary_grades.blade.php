@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><big> <strong>SALARY GRADES</strong> </big></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <a href="{{URL::to('/hr_payroll/salary_grade/add_salary_grade')}}" class="btn btn-primary">Add New Salary Grade</a>
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

                <div class="table-responsive">
                    <table id="salary_grade" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Provident Fund</th>
                            <th>Basic Salary</th>
                            <th>Transportation Allowance</th>
                            <th>Dinning Allowance</th>
                            <th>Other Allowance</th>
                            <th>Home Rent</th>
                            <th>Gross Salary</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($salary_grade_info as $key => $salary_grade)
                            <tr>
                                <td width="5%">{{ ++$key }}</td>
                                <td>{{$salary_grade->name}}</td>
                                <td>
                                    @if($salary_grade->type == 1)
                                        {{Config::get('constants.hrSalaryGradeType.1')}}
                                    @elseif($salary_grade->type == 2)
                                        {{Config::get('constants.hrSalaryGradeType.2')}}
                                    @endif
                                </td>
                                <td>{{$salary_grade->provident_fund}}</td>
                                <td>{{$salary_grade->basic_salary}}</td>
                                <td>{{$salary_grade->transportation_allowance}}</td>
                                <td>{{$salary_grade->dinning_allowance}}</td>
                                <td>{{$salary_grade->other_allowance}}</td>
                                <td>{{$salary_grade->home_rent}}</td>
                                <td>{{$salary_grade->gross_salary}}</td>
                                <td>{{$salary_grade->note}}</td>
                                <td width="15%" align="right">
                                    <a href="{{URL::to('edit_salary_grade/'.$salary_grade->id)}}" class="btn btn-sm btn-info">Edit</a>
                                    <a href="{{URL::to('delete_salary_grade/'.$salary_grade->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


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
        $('#salary_grade').DataTable({
            "paging": true,
            "ordering":  true,
            "pagingType": "full_numbers"
          });
    } );
</script>

@endsection