@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">View Venue Reservation</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                </div>
 
    <div style="padding: 0 30px 0 30px;">
      <a href="{{URL::to('/training/venueRes')}}" class="btn btn-primary mb-2">BACK</a>
      <a href="{{ url('pdf/'.$allvenueresinfo->id) }}" class="btn btn-success mb-2">Export PDF</a>

    <table id="viewvenueres" class="table table-bordered">
    <tbody>
        <tr>
            <th width="30%">Name of Person / Organizaion</th>
            <td width="70%"><b>{{$allvenueresinfo->name}}</b></td>
        </tr>
        <tr>
            <th>Contact Number</th>
            <td>{{$allvenueresinfo->contact_no}}</td>
        </tr>   
        <tr>
            <th>Date / Start Date</th>
            <td>
            {{date("d-m-Y", strtotime($allvenueresinfo->start_date))}}
            </td>
        </tr>   
        <tr>
            <th>End Date</th>
            <td>
            	 @if($allvenueresinfo->end_date != NULL)
                  {{date("d-m-Y", strtotime($allvenueresinfo->end_date))}}
                @else
                  {{'Reserved for One Day'}}
                @endif
            </td>
        </tr>   
        <tr>
            <th>Venue</th>
            <td>{{$allvenueresinfo->venueName}}</td>
        </tr>   
        <tr>
            <th>Actual Price</th>
            <td>{{$allvenueresinfo->vprice}}</td>
        </tr>   
        <tr>
            <th>Client Price</th>
            <td>{{$allvenueresinfo->price}}</td>
        </tr>   
        <tr>
            <th>No of Attendee</th>
            <td>{{$allvenueresinfo->no_of_attendee}}</td>
        </tr>   
        <tr>
            <th>Status</th>
            <td>
            @if($allvenueresinfo->status == '1')
                  {{Config::get('constants.venueResStatus.1')}}
                @elseif($allvenueresinfo->status == '2')
                  {{Config::get('constants.venueResStatus.2')}}
                @elseif($allvenueresinfo->status == '3')
                  {{Config::get('constants.venueResStatus.3')}}
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