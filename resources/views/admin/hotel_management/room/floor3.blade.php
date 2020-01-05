@extends('admin.master')

    @section('header_styles')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{asset('css/room_style.css')}}" rel="stylesheet">
        <?php
        $room_id25 =25 ;
        $room_id26 =26 ;
        $room_id27 =27 ;
        $room_id28 =28 ;
        $room_id29 =29 ;
        $room_id30 =30 ;
        $room_id31 =31 ;
        $room_id32 =32 ;
        $room_id33 =33 ;
        $room_id34 =34 ;
        $room_id35 =35 ;
        $room_id36 =36 ;
        $room_id37 =37 ;
        $room_id38 =38 ;
        $room_id39 =39 ;
        {   ?>
    @stop
                {{--For Reservation status--}}
        @foreach($reservation as $value)
            @if($value->room_id == $room_id25 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id25 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id25 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id26 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id26 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id26 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id27 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id27 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id27 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id28 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id28 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id28 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif

            @if($value->room_id == $room_id29 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id29 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id29 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id30 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id30 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id30 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id31 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id31 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id31 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id32 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id32 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id32 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id33 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id33 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id33 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id34 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id34 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id34 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id35 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id35 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id35 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id36 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id36 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id36 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id37 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id37 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id37 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id38 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id38 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id38 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id39 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id39 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id39 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
        @endforeach
        @foreach($booking as $value)
            @if($value->room_id == $room_id25 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id25 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id25 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id26 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id26 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id26 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id27 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id27 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id27 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id28 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id28 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id28 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif

            @if($value->room_id == $room_id29 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id29 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id29 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id30 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id30 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id30 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id31 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id31 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id31 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id32 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id32 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id32 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id33 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id33 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id33 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id34 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id34 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id34 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id35 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id35 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id35 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id36 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id36 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id36 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id37 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id37 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id37 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id38 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id38 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id38 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id39 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id39 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id39 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
        @endforeach
@section('rooms')
<style>

          main.py-4 {
              min-height: 450px !important;
              width: auto;
              background: #fff0;
          }
</style>
    {{--side menu dropdown--}}
    <nav class="custom navbar navbar-expand-sm navbar-dark" style="width: 150px; margin-top: 70px; float: left;">
        <div class="custom navbar-collapse collapse" id="navbar4">
            <ul class="custom navbar-nav nav-fill w-100" style="width: 150px;">
                <li class="custom nav-item dropdown dmenu" style="width: 150px;">
                    <a class="custom nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" style="width: 150px;">
                        Rooms
                    </a>
                    <div class="custom dropdown-menu sm-menu">
                        <a class="custom dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer')}}">Ground</a>
                        <a class="custom dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer/floor1')}}">Floor 1</a>
                        <a class="custom dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer/floor2')}}">Floor 2</a>
                        <a class="custom dropdown-item active" href="{{URL::to('/hotel_management/room/room_viewer/floor3')}}">Floor 3</a>
                        <a class="custom dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer/floor4')}}">Floor 4</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="room_status" style="float: right; margin-right: 30px; margin-top: 20px;">
        <p><button class="available" style="padding: 12px; border: 0; margin: 5px;"></button>Available</p>
        <p><button class="reserved" style="padding: 12px; border: 0; margin: 5px; background: #0c4d90;"></button>Reserved</p>
        <p><button class="booked" style="padding: 12px; border: 0; margin: 5px; background: #ff0000;"></button>Booked</p>
    </div>

    <div class="container" style="background-image: url('{{asset('img')}}/rooms/floor3.jpg'); height: 719px; width: 1000px;">
    <div class="third_room_list_1">
        <button class="third_room_1" style="background: #4c4c4c;"></button>
    </div>
    <div class="third_room_list_2 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 26 && $category->id == $room->category_id)
                        <button class="third_room_2" <?php echo 'id=room'.$room_id26; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                         </button>
                    @endif
                @endforeach
            @endforeach
        <br>
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 25 && $category->id == $room->category_id)
                        <button class="third_room_3" <?php echo 'id=room'.$room_id25; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <div class="third_room_list_3 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 27 && $category->id == $room->category_id)
                        <button class="third_room_4" <?php echo 'id=room'.$room_id27; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
        <br>
        <button class="third_room_5" style="background: #4c4c4c;">Drawing Room</button>
        <br>
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 28 && $category->id == $room->category_id)
                        <button class="third_room_6" <?php echo 'id=room'.$room_id28; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <div class="third_room_list_4 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 33 && $category->id == $room->category_id)
                        <button class="third_room_7" <?php echo 'id=room'.$room_id33; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 32 && $category->id == $room->category_id)
                        <button class="third_room_8" <?php echo 'id=room'.$room_id32; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 31 && $category->id == $room->category_id)
                        <button class="third_room_9" <?php echo 'id=room'.$room_id31; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 30 && $category->id == $room->category_id)
                        <button class="third_room_10" <?php echo 'id=room'.$room_id30; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 29 && $category->id == $room->category_id)
                        <button class="third_room_11" <?php echo 'id=room'.$room_id29; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <div class="third_room_list_5 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 39 && $category->id == $room->category_id)
                        <button class="third_room_12" <?php echo 'id=room'.$room_id39; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 38 && $category->id == $room->category_id)
                        <button class="third_room_13" <?php echo 'id=room'.$room_id38; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 37 && $category->id == $room->category_id)
                        <button class="third_room_14" <?php echo 'id=room'.$room_id37; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 36 && $category->id == $room->category_id)
                        <button class="third_room_15"  <?php echo 'id=room'.$room_id36; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }}<br>{{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 35 && $category->id == $room->category_id)
                        <button class="third_room_16" <?php echo 'id=room'.$room_id35; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }}<br>{{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <div class="third_room_list_6 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 34 && $category->id == $room->category_id)
                        <button class="third_room_17" <?php echo 'id=room'.$room_id34; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <h1 class="third stairs"> Stairs</h1>

</div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="margin-top: 185px;" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 9px 15px;">
                    <button type="button" class="modal_btn close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <style>
                    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
                        background-color: #fff;
                        opacity: 1;
                        border: 0;
                    }
                    .form-control:focus {
                        border-color: #66afe9;
                        outline: 0;
                        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
                        box-shadow: inset 0 1px 1px rgb(255, 255, 255), 0 0 8px rgb(255, 255, 255);
                    }
                </style>
                <div class="modal-body">
                    <div class="image" style="width: 100%;">
                        <center><img id="image" class="img-fluid"  style="width: 675px; height: 335px;" alt="Image Loading failed "></center>
                    </div>
                    <br>
                    <table class="table table-bordered">
                        <style>
                            th {
                                font-size: 14px;
                            }
                        </style>
                        <tr>
                            <th>Room No</th>
                            <td><input type="text" class="form-control" id="room_no" readonly></td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td><input type="text" class="form-control" id="price" readonly></td>
                        </tr>
                        <tr>
                            <th>Persons Capacity</th>
                            <td><input type="text" class="form-control" id="capacity" readonly></td>
                        </tr>
                    </table>
                    <div class="form-group" style="display: inline">
                        <a type="button" id="reserved" class="btn btn-primary">Reserve Now</a>
                        <a type="button" id="booked" class="btn btn-success">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        function PopulateModal(id)
        {
            $.ajax({
                url: '/room_viewer/' + id + '/view',
                method: 'GET',
                success: function (data) {
                    var selected_array = [];
                    var id = ((data['view']['id']));
                    var image = ((data['view']['image']));

                    $('#room_no').val((data['view']['room_no']));
                    $('#price').val((data['view']['price']));
                    $('#capacity').val((data['view']['persons_capacity']));
                    $('#reserved').attr("href", "/addreservation/"+id)
                    $('#booked').attr("href", "/addbooking/"+id)
                    $('#image').attr("src", "/uploads/rooms_image/"+image)
                }
            })
        }
    </script>

    <?php } ?>
@endsection
