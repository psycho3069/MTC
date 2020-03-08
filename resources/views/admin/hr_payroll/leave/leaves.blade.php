@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><big> <strong>LEAVES</strong> </big></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <a href="{{URL::to('/hr_payroll/leave/add_leave')}}" class="btn btn-primary">Add New Leave</a>
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
                    <table id="leaves" class="table table-bordered table-hover ">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Duration</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($leave_info as $key => $leave)
                            <tr>
                                <td width="5%">{{ ++$key }}</td>
                                <td>{{$leave->name}}</td>
                                <td>{{$leave->duration}}</td>
                                <td>
                                    @foreach($leave_category_info as $leave_category)
                                        @if($leave_category->id == $leave->leave_category_id)
                                            {{$leave_category->name}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$leave->description}}</td>
                                <td width="15%" align="right">
                                    <a href="{{URL::to('edit_leave/'.$leave->id)}}" class="btn btn-sm btn-info">Edit</a>
                                    <a href="{{URL::to('delete_leave/'.$leave->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a>
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
        $('#leaves').DataTable({
            "paging": true,
            "ordering":  true,
            "pagingType": "full_numbers"
          });
    } );
</script>

@endsection