@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><big> <strong>GROCERIES</strong> </big></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <a href="{{URL::to('/restaurant/grocery/add_grocery')}}" class="btn btn-primary">Add New Grocery</a>
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

                <table id="grocery" class="table table-hover table-bordered table-striped ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Grocery Category</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($grocery_info as $key => $grocery)
                    <tr>
                        <td width="5%">{{ ++$key }}</td>
                        <td>{{$grocery->name}}</td>
                        <td>
                            @foreach($grocery_category_info as $grocery_category)
                                @if($grocery_category->id == $grocery->grocery_category_id)
                                    {{$grocery_category->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{$grocery->description}}</td>
                        <td width="15%" align="right">
                          <a href="{{URL::to('edit_grocery/'.$grocery->id)}}" class="btn btn-sm btn-info">Edit</a>
                          <a href="{{URL::to('delete_grocery/'.$grocery->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a>
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
        $('#grocery').DataTable({
            "paging": true,
            "ordering":  true,
            "pagingType": "full_numbers"
          });
    } );
</script>

@endsection
