@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><strong><big>Room Reservation Overview</big></strong></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                </div>
 
    <div style="padding: 0 30px 0 30px;">
      <a href="{{URL::to('/hotel_management/reservation/room_reservation_list')}}" class="btn btn-primary mb-2">BACK</a>
      <!-- <a href="{{ url('pdf/'.$reservation->id) }}" class="btn btn-success mb-2">Export PDF</a> -->

    <table id="view_room_res" class="table table-bordered">
    <tbody>
        <tr>
            <th width="30%">Guest Name</th>
            <td width="70%"><b>{{$reservation->guest_name}}</b></td>
        </tr>
        <tr>
            <th>Contact Number</th>
            <td>{{$reservation->guest_contact}}</td>
        </tr>   
        <tr>
            <th>Date / Start Date</th>
            <td>
            {{date("d-m-Y", strtotime($reservation->start_date))}}
            </td>
        </tr>   
        <tr>
            <th>End Date</th>
            <td>
            	@if($reservation->end_date != NULL)
                  {{date("d-m-Y", strtotime($reservation->end_date))}}
                @else
                  {{'Reserved for One Day'}}
                @endif
            </td>
        </tr>   
        <tr>
            <th>Room No</th>
            <td>
                @foreach($room_info as $row_room)
                    @if($row_room->id == $reservation->room_id)
                        {{$row_room->room_no}}
                    @endif
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @if($reservation->status == '1')
                  {{Config::get('constants.roomResStatus.1')}}
                @elseif($reservation->status == '2')
                  {{Config::get('constants.roomResStatus.2')}}
                @elseif($reservation->status == '3')
                  {{Config::get('constants.roomResStatus.3')}}
                @endif
            </td>
        </tr>   
       
    </tbody>
    </table>
    </div>

                </div>
        </div>
    </div>
</div>
@endsection