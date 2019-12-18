<table id="viewvenueres" class="table table-bordered">
    <tbody>
    	@foreach($notes as $row)
        <tr>
            <th width="30%">Name of Person / Organizaion</th>
            <td width="70%"><b>{{$row->name}}</b></td>
        </tr>
        <tr>
            <th>Contact Number</th>
            <td>{{$row->contact_no}}</td>
        </tr>   
        <tr>
            <th>Date / Start Date</th>
            <td>
            {{date("d-m-Y", strtotime($row->start_date))}}
            </td>
        </tr>   
        <tr>
            <th>End Date</th>
            <td>
            	 @if($row->end_date != NULL)
                  {{date("d-m-Y", strtotime($row->end_date))}}
                @else
                  {{'Reserved for One Day'}}
                @endif
            </td>
        </tr>   
        <tr>
            <th>Venue</th>
            <td>{{$row->venueName}}</td>
        </tr>   
        <tr>
            <th>Actual Price</th>
            <td>{{$row->vprice}}</td>
        </tr>   
        <tr>
            <th>Client Price</th>
            <td>{{$row->price}}</td>
        </tr>   
        <tr>
            <th>No of Attendee</th>
            <td>{{$row->no_of_attendee}}</td>
        </tr>   
        <tr>
            <th>Status</th>
            <td>
            @if($row->status == '1')
                  {{Config::get('constants.venueResStatus.1')}}
                @elseif($row->status == '2')
                  {{Config::get('constants.venueResStatus.2')}}
                @elseif($row->status == '3')
                  {{Config::get('constants.venueResStatus.3')}}
                @endif
            </td>
        </tr>   
       @endforeach
    </tbody>
</table>