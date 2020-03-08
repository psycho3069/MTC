@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><big> <strong>ROOMS LIST</strong> </big></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <a href="{{URL::to('/hotel_management/room/addroom')}}" class="btn btn-primary">Add New Room</a>
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

                <table id="room" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Room No:</th>
                        <th>Category</th>
                        <th>Floor Name</th>
                        <th>Building Name</th>
                        <th>Price</th>
                        <th>Capacity</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="adaptive">
                  @foreach($rooms_info as  $key => $row)
                    <tr>
                        <td width="5%">{{ ++$key }}</td>
                        <td><img src='{{ asset("/uploads/rooms_image/$row->image") }}' alt="No Image" width="90px"></td>
                        <td>{{$row->room_no}}</td>
                        <td>
                            @foreach($room_category_info as $row_category) 
                                @if($row_category->id == $row->category_id)
                                    {{$row_category->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($floor_info as $row_floor) 
                                @if($row_floor->id == $row->floor_id)
                                    {{$row_floor->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($floor_info as $row_floor) 
                                @if($row_floor->id == $row->floor_id)
                                    @foreach($building_info as $row_building) 
                                        @if($row_building->id == $row_floor->building_id)
                                            {{$row_building->name}}
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </td>
                        <td>{{$row->price}}</td>
                        <td>{{$row->persons_capacity}}</td>
                        <td>{{$row->description}}</td>
                        <td width="15%" align="right">
                          <a href="{{URL::to('editroom/'.$row->id)}}" class="btn btn-sm btn-info">Edit</a>
                          <a href="{{URL::to('deleteroom/'.$row->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a>
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
        $('#room').DataTable({
            "paging": true,
            "ordering":  true,
            "pagingType": "full_numbers"
          });
    } );
</script>

@endsection