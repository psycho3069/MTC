@extends('admin.master')

    @section('header_styles')
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{asset('css/room_style.css')}}" rel="stylesheet">

        <?php
        $room_id3 = 3;
        $room_id4 = 4;
        $room_id5 = 5;
        $room_id6 = 6;
        $room_id7 = 7;

        {   ?>

                    {{--For Reservation status--}}
        @foreach($reservation as $value)
            @if($value->room_id == $room_id3 && $value->end_date >= date('Y-m-d') )
                <style>
                    #room<?php echo $room_id3 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id3 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id4 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id4 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id4 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id5 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id5 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id5 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id6 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id6 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id6 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id7 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id7 ?>{
                        background: #0c4d90;
                    }
                    #room<?php echo $room_id7 ?>:hover{
                        background: #042f5d;
                    }
                </style>
            @endif
        @endforeach


        @foreach( $booking as $item )
            @if($book->room_id == $room_id3)
                @if( $book->booking_status == 1)
                    <style>
                        #room<?php echo $room_id3 ?>{
                            background: #0c4d90;
                        }
                        #room<?php echo $room_id3 ?>:hover{
                            background: #042f5d;
                        }
                    </style>
                @elseif( $book->booking_status == 2)
                    <style>
                        #room<?php echo $room_id3 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id3 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
            @endif



        @endforeach

                    {{--For Booking status--}}
        @foreach($booked as $value)
            @if($value->room_id == $room_id3 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id3 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id3 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id4 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id4 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id4 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id5 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id5 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id5 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id6 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id6 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id6 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->room_id == $room_id7 && $value->end_date >= date('Y-m-d'))
                <style>
                    #room<?php echo $room_id7 ?>{
                        background: #ff0000;
                    }
                    #room<?php echo $room_id7 ?>:hover{
                        background: #b70000;
                    }
                </style>
            @endif
        @endforeach

                {{-- for venue table --}}
        @foreach($venuereservation as $value)
            @if($value->venue_id == 51 && $value->end_date >= date('Y-m-d'))
                <style>
                    .first_room_8{
                        background: #0c4d90;
                    }
                    .first_room_8:hover {
                        background: #042f5d;
                    }
                </style>
            @endif
            @if($value->venue_id == 54 && $value->end_date >= date('Y-m-d'))
                <style>
                    .first_room_9{
                        background: #0c4d90;
                    }
                    .first_room_9:hover {
                        background: #042f5d;
                    }
                </style>
            @endif
        @endforeach
        @foreach($venuebooking as $value)
            @if($value->venue_id == 51 && $value->end_date >= date('Y-m-d'))
                <style>
                    .first_room_8{
                        background: #ff0000;
                    }
                    .first_room_8:hover {
                        background: #b70000;
                    }
                </style>
            @endif
            @if($value->venue_id == 54 && $value->end_date >= date('Y-m-d'))
                <style>
                    .first_room_9{
                        background: #ff0000;
                    }
                    .first_room_9:hover {
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
    <nav class="custom navbar navbar-expand-sm navbar-dark sticky-top" style="width: 150px; margin-top: 70px; float: left;">
        <div class="custom navbar-collapse collapse" id="navbar4">
            <ul class="custom navbar-nav nav-fill w-100" style="width: 150px;">
                <li class="custom nav-item dropdown dmenu" style="width: 150px;">
                    <a class="custom nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" style="width: 150px;">
                        Rooms
                    </a>
                    <div class="custom dropdown-menu sm-menu">
                        <a class="custom dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer')}}">Ground</a>
                        <a class="custom dropdown-item active" href="{{URL::to('/hotel_management/room/room_viewer/floor1')}}">Floor 1</a>
                        <a class="custom dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer/floor2')}}">Floor 2</a>
                        <a class="custom dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer/floor3')}}">Floor 3</a>
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

<div class="container" style="background-image: url('{{asset('img')}}/rooms/floor1.jpg'); height: 637px; width: 1000px;">
    <div class="first_room_list_1">
        <button class="first_room_1" style="background: #4c4c4c;" ></button>

    </div>
    <div class="first_room_list_2 ">
        @foreach($rooms as $room)
            @foreach($room_category as $category)
                @if($room->id == 6 && $category->id == $room->category_id)
                 <button class="first_room_2" <?php echo 'id=room'.$room_id6; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                    {{ $room->room_no }} -- {{ $category->name }}
                 </button>
                @endif
            @endforeach
        @endforeach
        <br>
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 7 && $category->id == $room->category_id)
                        <button class="first_room_3" <?php echo 'id=room'.$room_id7; ?> id="205" data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                            {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
        <br>
        <button class="first_room_4"  style="background: #4c4c4c;" >
            Prayer House
        </button>
    </div>
    <div class="first_room_list_3 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 5 && $category->id == $room->category_id)
                        <button class="first_room_5" <?php echo 'id=room'.$room_id5; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                            {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
        <br>
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 4 && $category->id == $room->category_id)
                        <button class="first_room_6" <?php echo 'id=room'.$room_id4; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                         </button>
                    @endif
                @endforeach
            @endforeach
        <br>
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 3 && $category->id == $room->category_id)
                        <button class="first_room_7" <?php echo 'id=room'.$room_id3; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <div class="first_room_list_4 ">
        @foreach($venues as $venue)
            @if($venue->id == 51)
            <button class="first_room_8" data-toggle="modal" data-target="#venueModalCenter" onclick="venuePopulateModal('<?php echo $venue->id ?>')">{{ $venue->name }}<br>{{ $venue->feature }}</button>
            @endif
        @endforeach
    </div>
    <div class="first_room_list_5 ">
        @foreach($venues as $venue)
            @if($venue->id == 54)
                <button class="first_room_9" data-toggle="modal" data-target="#venueModalCenter" onclick="venuePopulateModal('<?php echo $venue->id ?>')">{{ $venue->feature }}</button>
            @endif
        @endforeach
    </div>
    <h1 class="first stairs"> Stairs</h1>

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
                   <center><img id="image" style="width: 675px; height: 335px;" class="img-fluid" alt="Image Loading failed "></center>
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

<!-- venue Modal -->
<div class="modal fade" id="venueModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                   <center><img id="image" src="{{ asset('img/slider/img2.jpg') }}" class="img-fluid"  style="width: 675px; height: 335px;" alt="Image Loading failed "></center>
                </div>
                <br>
                <table class="table table-bordered">
                    <tr>
                        <th>Venue</th>
                        <td><input type="text" class="form-control" id="venue" readonly></td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td><input type="text" class="form-control" id="vprice" readonly></td>
                    </tr>
                    <tr>
                        <th>Feature</th>
                        <td><input type="text" class="form-control" id="feature" readonly></td>
                    </tr>
                </table>
                <div class="form-group" style="display: inline">
                    <a type="button" id="venueReserved" class="btn btn-primary">Reserve Now</a>
                    <a type="button" id="venueBooked" class="btn btn-success">Book Now</a>
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

        function venuePopulateModal(id)
        {
            $.ajax({
                url: '/venue_details/' + id + '/view',
                method: 'GET',
                success: function (data) {
                    var selected_array = [];
                    var id = ((data['view']['id']));

                    $('#venue').val((data['view']['name']));
                    $('#vprice').val((data['view']['price']));
                    $('#feature').val((data['view']['feature']));
                    $('#venueReserved').attr("href", "/training/addvenueRes/"+id)
                    $('#venueBooked').attr("href", "/training/add-booking/"+id)
                }
            })
        }
    </script>

    <?php } ?>
@endsection
