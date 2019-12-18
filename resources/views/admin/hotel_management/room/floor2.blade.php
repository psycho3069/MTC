@extends('admin.master')

    @section('header_styles')
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{asset('css/room_style.css')}}" rel="stylesheet">
        <?php
            $room_id8 = 8;
            $room_id9 = 9;
            $room_id10 = 10;
            $room_id11 = 11;
            $room_id12 = 12;
            $room_id13 = 13;
            $room_id14 = 14;
            $room_id15 = 15;
            $room_id16 = 16;
            $room_id17 = 17;
            $room_id18 = 18;
            $room_id19 = 19;
            $room_id20 = 20;
            $room_id21 = 21;
            $room_id22 = 22;
            $room_id23 = 23;
            $room_id24 = 24;

        {   ?>
                            {{--For Reservation status--}}
            @foreach($reservation as $value)
                    @if($value->room_id == $room_id8  && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id8 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id8 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id9 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id9 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id9 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id10 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id10 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id10 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id11 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id11 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id11 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif

                    @if($value->room_id == $room_id12 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id12 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id12 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id13 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id13 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id13 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id14 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id14 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id14 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id15 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id15 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id15 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id16 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id16 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id16 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id17 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id17 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id17 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id18 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id18 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id18 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id19 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id19 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id19 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id20 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id20 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id20 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id21 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id21 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id21 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id22 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id22 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id22 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id23 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id23 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id23 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
                    @if($value->room_id == $room_id24 && $value->end_date >= date('Y-m-d'))
                        <style>
                            #room<?php echo $room_id24 ?>{
                                background: #0c4d90;
                            }
                            #room<?php echo $room_id24 ?>:hover{
                                background: #042f5d;
                            }
                        </style>
                    @endif
            @endforeach
                        {{-- For Booking Status--}}
            @foreach($booking as $value)

                @if($value->room_id == $room_id8 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id8 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id8 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id9 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id9 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id9 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id10 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id10 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id10 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id11 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id11 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id11 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id12 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id12 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id12 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id13 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id13 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id13 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id14 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id14 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id14 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id15 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id15 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id15 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id16 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id16 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id16 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id17 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id17 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id17 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id18 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id18 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id18 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id19 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id19 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id19 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id20 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id20 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id20 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id21 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id21 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id21 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id22 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id22 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id22 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id23 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id23 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id23 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
                @if($value->room_id == $room_id24 && $value->end_date >= date('Y-m-d'))
                    <style>
                        #room<?php echo $room_id24 ?>{
                            background: #ff0000;
                        }
                        #room<?php echo $room_id24 ?>:hover{
                            background: #b70000;
                        }
                    </style>
                @endif

            @endforeach

    @stop

@section('content')
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
                        <a class="custom dropdown-item active" href="{{URL::to('/hotel_management/room/room_viewer/floor2')}}">Floor 2</a>
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

<div class="container" style="background-image: url('{{asset('img')}}/rooms/floor2.jpg'); height: 743px; width: 1000px;">

    <div class="second_room_list_1">
        <button class="second_room_1" style="background: #4c4c4c;" title="New Bulling Under Construction" ></button>
    </div>
    <div class="second_room_list_2 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 21 && $category->id == $room->category_id)
                        <button class="second_room_2" <?php echo 'id=room'.$room_id21; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                            {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
        <br>
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 20 && $category->id == $room->category_id)
                        <button class="second_room_3" <?php echo 'id=room'.$room_id20; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                    </button>
                    @endif
                @endforeach
            @endforeach
        <br>
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 19 && $category->id == $room->category_id)
                        <button class="second_room_4" <?php echo 'id=room'.$room_id19; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <div class="second_room_list_3 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 22 && $category->id == $room->category_id)
                        <button class="second_room_5" <?php echo 'id=room'.$room_id22; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
        </button>
                    @endif
                @endforeach
            @endforeach
        <br>
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 23 && $category->id == $room->category_id)
                        <button class="second_room_6" <?php echo 'id=room'.$room_id23; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
        </button>
                    @endif
                @endforeach
            @endforeach
        <br>
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 24 && $category->id == $room->category_id)
                            <button class="second_room_7" <?php echo 'id=room'.$room_id24; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <div class="second_room_list_4 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 18 && $category->id == $room->category_id)
                        <button class="second_room_8" <?php echo 'id=room'.$room_id18; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 17 && $category->id == $room->category_id)
                        <button class="second_room_9" <?php echo 'id=room'.$room_id17; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 16 && $category->id == $room->category_id)
                        <button class="second_room_10" <?php echo 'id=room'.$room_id16; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 15 && $category->id == $room->category_id)
                        <button class="second_room_11" <?php echo 'id=room'.$room_id15; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 14 && $category->id == $room->category_id)
                        <button class="second_room_12" <?php echo 'id=room'.$room_id14; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <div class="second_room_list_5 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 13 && $category->id == $room->category_id)
                        <button class="second_room_13" <?php echo 'id=room'.$room_id13; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 12 && $category->id == $room->category_id)
                        <button class="second_room_14" <?php echo 'id=room'.$room_id12; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 11 && $category->id == $room->category_id)
                        <button class="second_room_15" <?php echo 'id=room'.$room_id11; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 10 && $category->id == $room->category_id)
                        <button class="second_room_16" <?php echo 'id=room'.$room_id10; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 9 && $category->id == $room->category_id)
                        <button class="second_room_17" <?php echo 'id=room'.$room_id9; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <div class="second_room_list_6 ">
            @foreach($rooms as $room)
                @foreach($room_category as $category)
                    @if($room->id == 8 && $category->id == $room->category_id)
                        <button class="second_room_18" <?php echo 'id=room'.$room_id8; ?> data-toggle="modal" data-target="#exampleModalCenter" onclick="PopulateModal('<?php echo $room->id ?>')">
                        {{ $room->room_no }} -- {{ $category->name }}
                        </button>
                    @endif
                @endforeach
            @endforeach
    </div>
    <h1 class="second stairs"> Stairs</h1>

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