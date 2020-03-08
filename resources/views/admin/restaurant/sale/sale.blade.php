@extends('admin.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><big> <strong>SALES</strong> </big></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <a href="{{URL::to('/restaurant/sale/add-food-sale')}}" class="btn btn-primary">Add New Sale</a>
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
                        <table id="receivers" class="table table-bordered table-hover" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">Guest Name</th>
                                <th width="15%">Contact</th>
                                <th width="10%">Room No</th>
                                <th width="10%">Menu</th>
                                <th width="10%">Category</th>
                                <th width="15%">Date</th>
                                <th width="10%">Quantity</th>
                                <th width="10%">Total Price</th>
                                <th width="5%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sales as $key => $sale)
                                <tr>
                                    <td width="5%">{{ ++$key }}</td>
                                    <td>
                                        @foreach($room_bookings as $books)
                                            @if($sale->guest_id == $books->id && $sale->booking_status == 1)
                                                {{ $books->guest_name }}
                                            @endif
                                        @endforeach
                                        @foreach($venue_bookings as $books)
                                            @if($sale->guest_id == $books->id && $sale->booking_status == 2)
                                                {{ $books->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($room_bookings as $books)
                                            @if($sale->guest_id == $books->id && $sale->booking_status == 1)
                                            {{ $books->guest_contact }}
                                            @endif
                                        @endforeach
                                        @foreach($venue_bookings as $books)
                                            @if($sale->guest_id == $books->id && $sale->booking_status == 2)
                                            {{ $books->contact_no }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($room_bookings as $books)
                                            @foreach($rooms as $room)
                                                @if($sale->guest_id == $books->id && $sale->booking_status == 1)
                                                    @if($books->room_id == $room->id)
                                                        {{ $room->room_no }}
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endforeach
                                        @foreach($venue_bookings as $books)
                                            @foreach($venues as $venue)
                                                @if($sale->guest_id == $books->id && $sale->booking_status == 2)
                                                    @if($books->venue_id == $venue->id)
                                                        {{ $venue->name }}
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($menus as $menu)
                                            @if($sale->menu_id == $menu->id)
                                                {{ $menu->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($menu_types as $type)
                                            @if($type->id == $sale->menu_type)
                                                {{ $type->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{date("d-m-Y", strtotime($sale->created_at))}}</td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>
                                        @foreach($menus as $menu)
                                            @if($sale->menu_id == $menu->id)
                                                <?php
                                                    $price = $menu->price;
                                                    $quantity = $sale->quantity;
                                                    $total = $price*$quantity;

                                                    echo $total.'/-';
                                                ?>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td width="15%" align="right">
                                        <a href="{{URL::to('/restaurant/sale/edit-food-sale/'.$sale->id)}}" class="btn btn-sm btn-info" id="edit">Edit</a>
                                        <a href="{{URL::to('deleteSale/'.$sale->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a>
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