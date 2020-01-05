@extends('admin.master')

    @section('header_styles')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{asset('css/room_style.css')}}" rel="stylesheet">
        <?php
        $room_id40 = 40;
        $room_id41 = 41;
        $room_id42 = 42;
        $room_id43 = 43;
        $room_id44 = 44;
        $room_id45 = 45;

        {   ?>
        @foreach($reservation as $value)
            @if($value->room_id == $room_id40 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id40 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id40 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id41 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id41 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id41 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id42 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id42 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id42 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id43 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id43 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id43 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif

            @if($value->room_id == $room_id44 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id44 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id44 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id45 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id45 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id45 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
        @endforeach
        @foreach($booking as $value)
            @if($value->room_id == $room_id40 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id40 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id40 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id41 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id41 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id41 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id42 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id42 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id42 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id43 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id43 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id43 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif

            @if($value->room_id == $room_id44 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id44 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id44 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id45 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id45 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id45 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
        @endforeach

                {{-- for venue table --}}
        @foreach($venuereservation as $value)
            @if($value->venue_id == 53 && $value->end_date >= date('Y-m-d'))
                <style>
                    .four_room_7{
                        background: #0c4d90;
                    }
                    .four_room_7:hover {
                        background: #042f5d;
                    }
                </style>
            @endif
        @endforeach
        @foreach($venuebooking as $value)
            @if($value->venue_id == 53 && $value->end_date >= date('Y-m-d'))
                <style>
                    .four_room_7{
                        background: #ff0000;
                    }
                    .four_room_7:hover {
                        background: #b70000;
                    }
                </style>
            @endif
        @endforeach
    @stop

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
                        <a class="custom dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer/floor3')}}">Floor 3</a>
                        <a class="custom dropdown-item active" href="{{URL::to('/hotel_management/room/room_viewer/floor4')}}">Floor 4</a>
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

<div class="container" style="background-image: url('{{asset('img')}}/rooms/floor4.jpg'); height: 662px; width: 1000px;">
    <div class="four_room_list_1">
        <button class="four_room_1" style="background: #4c4c4c;"></button>
    </div>
    <div class="four_room_list_2 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 43 && $category->id == $room->category_id)
                        <button class="four_room_2" <?php echo 'id=room'.$room_id43; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
        <br>
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 42 && $category->id == $room->category_id)
                        <button class="four_room_3" <?php echo 'id=room'.$room_id42; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <div class="four_room_list_3 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 45 && $category->id == $room->category_id)
                        <button class="four_room_4" <?php echo 'id=room'.$room_id45; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }}<br>{{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
        <br>
        <button class="four_room_5" style="background: #4c4c4c;">Drawing Room</button>
        <br>
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 44 && $category->id == $room->category_id)
                        <button class="four_room_6" <?php echo 'id=room'.$room_id44; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }}<br>{{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <div class="four_room_list_4 ">
            @foreach($venues as $venue)
                @if($venue->id == 53)
                    <button class="four_room_7" data-toggle="modal" data-target="#venueModalCenter">
                    {{ $venue->name }}<br>{{ $venue->feature }}
                    </button>
                @endif
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 41 && $category->id == $room->category_id)
                        <button class="four_room_8" <?php echo 'id=room'.$room_id41; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        <p>{{ $room->room_no }} -- {{ $category->name }}</p>
                        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <div class="four_room_list_5 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 40 && $category->id == $room->category_id)
                        <button class="four_room_9" <?php echo 'id=room'.$room_id40; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <h1 class="four stairs"> Stairs</h1>

</div>


    <!-- Venue Modal -->
    <div class="modal fade" id="venueModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="margin-top: 185px;" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 9px 15px;">
                    <button type="button" class="modal_btn close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="image" style="width: 100%;">
                        <center><img src="{{ asset('img/slider/img2.jpg') }}" class="img-fluid" style="width: 675px; height: 335px;" alt=""></center>
                    </div>
                    @foreach($venues as $venue)
                        @if($venue->id == 53)

                            <table class="table table-bordered">
                                <tr>
                                    <th>Venue</th>
                                    <td>{{ $venue->name }}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>{{ $venue->price }}/-</td>
                                </tr>
                                <tr>
                                    <th>Feature</th>
                                    <td>{{ $venue->feature }}</td>
                                </tr>
                            </table>

                        <div class="form-group" STYLE="display: inline">
                            <a href="{{ URL::to('/training/addvenueRes',$venue->id) }}" type="button" class="btn btn-primary">Reserve Now</a>
                            <a href="{{ URL::to('/training/add-booking',$venue->id) }}" type="button" class="btn btn-success">Book Now</a>
                        </div>

                        @endif
                    @endforeach
                </div>
            </div>
        </div>
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
                        <center><img id="image" class="img-fluid" style="width: 675px; height: 335px;" alt="Image Loading failed "></center>
                    </div>
                    <br>
                    <table class="table table-bordered">
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
