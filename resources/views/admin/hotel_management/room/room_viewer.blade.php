@extends('admin.master')

    @section('header_styles')
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{asset('css/room_style.css')}}" rel="stylesheet">
        <style>
            .room_1,.room_3,.room_4,.room_5,.room_6,.room_9,.room_10,.room_11 {
                background: #6b6b6b;
                color: #fff;
            }
            .room_1:hover,.room_3:hover,.room_4:hover,.room_5:hover,.room_6:hover,.room_9:hover,.room_10:hover,.room_11:hover {
                background: #4c4c4c;
                color: #fff;
            }
        </style>

        @foreach($booking as $book)
            @if($book->room_id == 55)
                @if( $book->booking_status == 1)
                    <style>
                        .room_2{
                            background: #0c4d90;
                        }
                        .room_2:hover{
                            background: #042f5d;
                        }
                    </style>
                @elseif( $book->booking_status == 2)
                    <style>
                        .room_2{
                            background: #ff0000;
                        }
                        .room_2:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
            @endif



            @if($book->room_id == 56)
                @if( $book->booking_status == 1)
                    <style>
                        .room_7{
                            background: #0c4d90;
                        }
                        .room_7:hover{
                            background: #042f5d;
                        }
                    </style>
                @endif

                @if($book->booking_status == 2)
                    <style>
                        .room_7{
                            background: #ff0000;
                        }
                        .room_7:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
            @endif


            @if($book->room_id == 57)
                @if( $book->booking_status == 1)
                    <style>
                        .room_8{
                            background: #0c4d90;
                        }
                        .room_8:hover{
                            background: #042f5d;
                        }
                    </style>
                @endif

                @if($book->booking_status == 2)
                    <style>
                        .room_8{
                            background: #ff0000;
                        }
                        .room_8:hover{
                            background: #b70000;
                        }
                    </style>
                @endif
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
    <div class="custom_side_nav">
        <nav class="custom navbar navbar-expand-sm navbar-dark" style="width: 150px; margin-top: 70px; float: left;">
            <div class="custom navbar-collapse collapse" id="navbar4">
                <ul class="custom navbar-nav nav-fill w-100" style="width: 150px;">
                    <li class="custom nav-item dropdown dmenu" style="width: 150px;">
                        <a class="custom nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" style="width: 150px;">
                            Rooms
                        </a>
                        <div class="custom dropdown-menu sm-menu">
                            <a class="custom dropdown-item active" href="{{URL::to('/hotel_management/room/room_viewer')}}">Ground</a>
                            <a class="custom dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer/floor1')}}">Floor 1</a>
                            <a class="custom dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer/floor2')}}">Floor 2</a>
                            <a class="custom dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer/floor3')}}">Floor 3</a>
                            <a class="custom dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer/floor4')}}">Floor 4</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="room_status" style="float: right; margin-right: 30px; margin-top: 20px;">
        <p><button class="available" style="padding: 12px; border: 0; margin: 5px; background: #1c8c00;"></button>Available</p>
        <p><button class="reserved" style="padding: 12px; border: 0; margin: 5px; background: #0c4d90;"></button>Reserved</p>
        <p><button class="booked" style="padding: 12px; border: 0; margin: 5px; background: #ff0000;"></button>Booked</p>
    </div>

<div class="container" style="background-image: url('{{asset('img')}}/rooms/ground.jpg'); height: 589px; width: 1000px;">
    <div class="room_list_1">
        <button class="room_1" data-toggle="modal" >New Bulling Under Construction</button>
        @foreach($venues as $venue)
            @if($venue->id == 55)
                <button class="room_2" data-toggle="modal" data-target="#venueModalCenter" onclick="venuePopulateModal('<?php echo $venue->id ?>')">{{ $venue->feature }}</button>
            @endif
        @endforeach
        <button class="room_3" data-toggle="modal" >Wash Room</button>
    </div>
    <div class="room_list_2 ">
        <button class="room_4" data-toggle="modal" >Wash Room</button>
        <br>
        <button class="room_5" data-toggle="modal" >Staff Residence</button>
        <br>
        <button class="room_6" data-toggle="modal" >Wash Room</button>
    </div>
    <div class="room_list_3 ">
        @foreach($venues as $venue)
            @if($venue->id == 56)
                <button class="room_7" data-toggle="modal" data-target="#venueModalCenter" onclick="venuePopulateModal('<?php echo $venue->id ?>')" >{{ $venue->feature }}</button>
            @endif
        @endforeach
        <br>
        @foreach($venues as $venue)
            @if($venue->id == 57)
            <button class="room_8" data-toggle="modal" data-toggle="modal" data-target="#venueModalCenter" onclick="venuePopulateModal('<?php echo $venue->id ?>')">{{ $venue->name }} <br>{{ $venue->feature }}</button>
            @endif
        @endforeach
        <button class="room_9" data-toggle="modal" >Reception</button>
    </div>
    <div class="room_list_4 ">
        <button class="room_10" data-toggle="modal" >Store Room</button>
    </div>
    <div class="room_list_5 ">
        <button class="room_11" data-toggle="modal" >Office</button>
    </div>
    <h1 class="entrance">Entrance</h1>
    <h1 class=" stairs"> Stairs</h1>
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
                    <div class="image" style="">
                        <center><img id="image" src="{{ asset('img/slider/img2.jpg') }}" alt="Image Loading failed " style="width: 675px; height: 335px;"></center>
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
                    // $('#venueReserved').attr("href", "/training/addvenueRes/"+id)
                    // $('#venueBooked').attr("href", "/training/add-booking/"+id)
                    $('#venueReserved').attr("href", "/booking/create?room_id="+id+"&res="+1)
                    $('#venueBooked').attr("href", "/booking/create?room_id="+id)
                }
            })
        }
    </script>
@endsection
