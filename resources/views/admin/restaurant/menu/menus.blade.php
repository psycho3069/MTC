@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><big> <strong>MENUS LIST</strong> </big></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <a href="{{URL::to('/restaurant/menu/add_menu')}}" class="btn btn-primary">Add New Menu</a>
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
                    <table id="menus" class="table table-bordered table-hover table-responsive">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Item 1 Name</th>
                            <th>Item 1 Quantity</th>
                            <th>Item 2 Name</th>
                            <th>Item 2 Quantity</th>
                            <th>Item 3 Name</th>
                            <th>Item 3 Quantity</th>
                            <th>Item 4 Name</th>
                            <th>Item 4 Quantity</th>
                            <th>Item 5 Name</th>
                            <th>Item 5 Quantity</th>
                            <th>Item 6 Name</th>
                            <th>Item 6 Quantity</th>
                            <th>Item 7 Name</th>
                            <th>Item 7 Quantity</th>
                            <th>Item 8 Name</th>
                            <th>Item 8 Quantity</th>
                            <th>Item 9 Name</th>
                            <th>Item 9 Quantity</th>
                            <th>Item 10 Name</th>
                            <th>Item 10 Quantity</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="adaptive">
                        @foreach($menu_info as $key => $menu)
                            <tr>
                                <td width="5%">{{ ++$key }}</td>
                                <td>{{$menu->name}}</td>
                                <td>
                                    @foreach($menu_type_info as $menu_type)
                                        @if($menu_type->id == $menu->menu_type_id)
                                            {{$menu_type->name}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$menu->price}}</td>
                                <td>
                                    @foreach($item_info as $item_1)
                                        @if($item_1->id == $menu->item_1_id)
                                            {{ $item_1->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$menu->item_1_quantity}}</td>
                                <td>
                                    @foreach($item_info as $item_2)
                                        @if($item_2->id == $menu->item_2_id)
                                            {{ $item_2->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$menu->item_2_quantity}}</td>
                                <td>
                                    @foreach($item_info as $item_3)
                                        @if($item_3->id == $menu->item_3_id)
                                            {{ $item_3->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$menu->item_3_quantity}}</td>
                                <td>
                                    @foreach($item_info as $item_4)
                                        @if($item_4->id == $menu->item_4_id)
                                            {{ $item_4->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$menu->item_4_quantity}}</td>
                                <td>
                                    @foreach($item_info as $item_5)
                                        @if($item_5->id == $menu->item_5_id)
                                            {{ $item_5->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$menu->item_5_quantity}}</td>
                                <td>
                                    @foreach($item_info as $item_6)
                                        @if($item_6->id == $menu->item_6_id)
                                            {{ $item_6->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$menu->item_6_quantity}}</td>
                                <td>
                                    @foreach($item_info as $item_7)
                                        @if($item_7->id == $menu->item_7_id)
                                            {{ $item_7->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$menu->item_7_quantity}}</td>
                                <td>
                                    @foreach($item_info as $item_8)
                                        @if($item_8->id == $menu->item_8_id)
                                            {{ $item_8->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$menu->item_8_quantity}}</td>
                                <td>
                                    @foreach($item_info as $item_9)
                                        @if($item_9->id == $menu->item_9_id)
                                            {{ $item_9->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$menu->item_9_quantity}}</td>
                                <td>
                                    @foreach($item_info as $item_10)
                                        @if($item_10->id == $menu->item_10_id)
                                            {{ $item_10->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$menu->item_10_quantity}}</td>
                                <td width="15%" align="right">
                                    <a href="{{URL::to('edit_menu/'.$menu->id)}}" class="btn btn-sm btn-info">Edit</a>
                                    <a href="{{URL::to('delete_menu/'.$menu->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a>
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
        $('#menus').DataTable({
            "paging": true,
            "ordering":  true,
            "pagingType": "full_numbers"
          });
    } );
</script>

@endsection