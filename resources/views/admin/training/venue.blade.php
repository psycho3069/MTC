@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">VENUE LIST</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <a href="{{URL::to('/training/addvenue')}}" class="btn btn-primary">Add New</a>

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

                <table id="venue" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Price per session</th>
                        <th>Feature</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($allvenueinfo as $key => $row)
                    <tr>
                        <td width="5%">{{ ++$key }}</td>
                        <td>{{$row->name}}</td>
                        <td>{{$row->location}}</td>
                        <td>{{$row->price}}</td>
                        <td>{{$row->feature}}</td>
                        <td width="15%" align="right">
                          <a href="{{URL::to('edit_venue/'.$row->id)}}" class="btn btn-sm btn-info">Edit</a>
                          <a href="{{URL::to('delete_venue/'.$row->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a>
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
        $('#venue').DataTable({
            "paging": true,
            "ordering":  true,
            "pagingType": "full_numbers"
          });
    } );
</script>

@endsection