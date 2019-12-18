@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><big> <strong>RECEIVERS</strong> </big></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <a href="{{URL::to('/restaurant/receiver/add_receiver')}}" class="btn btn-primary">Add New Receiver</a>
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
                    <table id="receivers" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($receiver_info as $key => $receiver)
                            <tr>
                                <td width="5%">{{ ++$key }}</td>
                                <td>
                                    @foreach($employee_info as $employee)
                                        @if($employee->id == $receiver->employee_id)
                                            {{$employee->name}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($employee_info as $employee)
                                        @if($employee->id == $receiver->employee_id)
                                            {{$employee->address}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($employee_info as $employee)
                                        @if($employee->id == $receiver->employee_id)
                                            {{$employee->phone}}
                                        @endif
                                    @endforeach
                                </td>
                                <td width="15%" align="right">
                                    <a href="{{URL::to('delete_receiver/'.$receiver->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a>
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
        $('#receivers').DataTable({
            "paging": true,
            "ordering":  true,
            "pagingType": "full_numbers"
          });
    } );
</script>

@endsection