@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><big> <strong>INVENTORY ITEMS</strong> </big></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <a href="{{URL::to('/inventory/inventory_item/add_inventory_item')}}" class="btn btn-primary">Add New Inventory Item</a>
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

                <table id="inventory" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Inventory Category</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($inventory_item_info as $inventory) 
                    <tr>
                        <td width="5%">{{$inventory->id}}</td>
                        <td>{{$inventory->name}}</td>
                        <td>
                            @foreach($inventory_category_info as $inventory_category)
                                @if($inventory_category->id == $inventory->inventory_category_id)
                                    {{$inventory_category->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{$inventory->description}}</td>
                        <td width="15%" align="right">
                          <a href="{{URL::to('edit_inventory_item/'.$inventory->id)}}" class="btn btn-sm btn-info">Edit</a>
                          <a href="{{URL::to('delete_inventory_item/'.$inventory->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a>
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
        $('#inventory').DataTable({
            "paging": true,
            "ordering":  true,
            "pagingType": "full_numbers"
          });
    } );
</script>

@endsection
