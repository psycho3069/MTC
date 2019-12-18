@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Venue Booking List</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/training/add-booking')}}" class="btn btn-primary">Add New</a>
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

    <table id="venueres" class="table table-bordered">
    <thead>
        <tr>
            <th class="5%">#</th>
            <th width="15%" class="">Name of Person / Organizaion</th>
            <th width="10%" class="">Contact Number</th>
            <th width="15%" class="">Start Date</th>
            <th width="15%" class="">End Date</th>
            <th width="5%" class="">Venue</th>
            <th width="25%" class="">Pay Status</th>
            <th width="10%" class="">No of Attendee</th>
            <th width="5%" class="">Action</th>
        </tr>
    </thead>
    <tbody>
      @foreach($bookings as $key => $row)
        <tr>
            <td width="5%">{{ ++$key }}</td>
            <td width="15%">{{$row->name}}</td>
            <td>{{$row->contact_no}}</td>
            <td>{{date("d-m-Y", strtotime($row->start_date))}}</td>
            <td>
                @if($row->end_date != NULL)
                  {{date("d-m-Y", strtotime($row->end_date))}}
                @else
                  {{'Booked for One Day'}}
                @endif
            </td>
            <td width="15%">{{$row->venueName}}</td>
            <td>
                @if($row->status == '1')
                    {{Config::get('constants.roomBookStatus.1')}} ({{ $row->amount }}/-)
                @elseif($row->status == '2')
                    {{Config::get('constants.roomBookStatus.2')}} ({{ $row->amount }}/-)
                @elseif($row->status == '3')
                    {{Config::get('constants.roomBookStatus.3')}} ({{ $row->amount }}/-)
                @endif
            </td>
            <td>{{$row->no_of_attendee}}</td>
            <td width="15%" align="center">
              <a href="{{URL::to('training/makebilling/'.$row->id)}}" class="" title="Bill"><img src="{{asset('img')}}/book.png" alt="edit" height="20px" width="20px"></a>
              <a href="{{URL::to('/edit_venue_book/'.$row->id)}}" class="" title="Edit"><img src="{{asset('img')}}/edit.gif" alt="edit" height="20px" width="20px"></a>
              <a href="{{URL::to('delete_venue_book/'.$row->id)}}" class="" title="Delete" id="delete"><img src="{{asset('img')}}/delete.gif" alt="delete" height="20px" width="20px"></a>
            </td>
        </tr>
      @endforeach

    </tbody>
    </table>

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
        $('#venueres').DataTable({
            "paging": true,
            "ordering":  true,
            "pagingType": "full_numbers"
          });
    } );
</script>

@endsection