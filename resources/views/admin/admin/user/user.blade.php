@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"> <big> <strong>USERS LIST</strong> </big> </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/admin/user/adduser')}}" class="btn btn-primary">Add New User</a>

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

    <table id="user" class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>User Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
      @foreach($all_users_info as $row) 
        <tr>
            <td width="5%">{{$row->id}}</td>
            <td>{{$row->name}}</td>
            <td>{{$row->email}}</td>
            <td>
                @foreach($role_info as $row_role)
                    @if($row_role->id == $row->role_id)
                        {{$row_role->name}}
                    @endif
                @endforeach
            </td>
            <td width="15%" align="right">
              <a href="{{URL::to('edit_user/'.$row->id)}}" class="btn btn-sm btn-info">Edit</a>
              <a href="{{URL::to('delete_user/'.$row->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a>
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
    $(document).ready(function () {
        try {
            var t = $('#user').DataTable({
                "columnDefs": [{
                    "orderSequence": ["desc", "asc"],
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }]
                ,
                "order": [[0, 'desc' ]]
            } );
            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            }).draw();
            new $.fn.DataTable.FixedColumns(t, {
                leftColumns: 2,
                rightColumns: 0
            });
        }
        catch(err) {
            return true;
        }
    });
</script>

@endsection