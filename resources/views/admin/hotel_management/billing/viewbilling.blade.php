@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><strong><big>Room Billing Overview</big></strong></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                </div>
 
    <div style="padding: 0 30px 0 30px;">
      <a href="{{URL::to('/hotel_management/billing/billing_list')}}" class="btn btn-primary mb-2">BACK</a>
      <!-- <a href="{{ url('pdf/'.$billing->id) }}" class="btn btn-success mb-2">Export PDF</a> -->

    <table id="view_room_booking" class="table table-bordered">
    <tbody>
        <tr>
            <th width="30%">Guest Name</th>
            <td width="70%">
                <b>
                    @foreach($booking_info as $row_book)
                        @if($row_book->id == $billing->booking_id)
                            {{$row_book->guest_name}}
                        @endif
                    @endforeach
                </b>
            </td>
        </tr>
        <tr>
            <th>Contact Number</th>
            <td>
                @foreach($booking_info as $row_book)
                    @if($row_book->id == $billing->booking_id)
                        {{$row_book->guest_contact}}
                    @endif
                @endforeach
            </td>
        </tr>   
        <tr>
            <th>Date / Start Date</th>
            <td>
                @foreach($booking_info as $row_book)
                    @if($row_book->id == $billing->booking_id)
                        {{date("d-m-Y", strtotime($row_book->start_date))}}
                    @endif
                @endforeach
            
            </td>
        </tr>   
        <tr>
            <th>End Date</th>
            <td>
                @foreach($booking_info as $row_book)
                    @if($row_book->id == $billing->booking_id)
                        @if($row_book->end_date != NULL)
                          {{date("d-m-Y", strtotime($row_book->end_date))}}
                        @else
                          {{'Booked for One Day'}}
                        @endif
                    @endif
                @endforeach
            	
            </td>
        </tr>   
        <tr>
            <th>Total Day</th>
            <td>
                {{ $billing->total_day }}
            </td>
        </tr>
        <tr>
            <th class="">Room No</th>
            <td>
                @foreach($booking_info as $row_book)
                    @if($row_book->id == $billing->booking_id)
                        @foreach($room_info as $row_room)
                            @if($row_room->id == $row_book->room_id)
                                {{$row_room->room_no}}
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @foreach($booking_info as $row_book)
                    @if($row_book->id == $billing->booking_id)
                        @if($row_book->status == '1')
                            {{Config::get('constants.roomBookStatus.1')}}
                        @elseif($row_book->status == '2')
                            {{Config::get('constants.roomBookStatus.2')}}
                        @elseif($row_book->status == '3')
                            {{Config::get('constants.roomBookStatus.3')}}
                        @endif
                    @endif

                @endforeach
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