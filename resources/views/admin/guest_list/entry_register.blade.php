@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"> <big> <strong>Guest List</strong> </big> </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
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

            <table id="userrole" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Guest Name</th>
                        <th>Contact No</th>
                        <th>Room No</th>
                        <th>Venue No</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hotel_booking as $hotel )
                        <tr>
                            <td>{{ $hotel->guest_name }}</td>
                            <td>{{ $hotel->guest_contact }}</td>
                            <td>{{ $hotel->room_id }}</td>
                            <td><span style="color: #f00;">No</span></td>
                            <td>
                                <a href="{{ URL::to('/checkout-room',$hotel->id) }}" class="btn btn-success btn-sm">Checkout</a>
                            </td>
                        </tr>
                    @endforeach
                    @foreach($venue_booking as $venue )
                        <tr>
                            <td>{{ $venue->name }}</td>
                            <td>{{ $venue->contact_no }}</td>
                            <td><span style="color: #f00;">No</span></td>
                            <td>{{ $venue->venue_id }}</td>
                            <td>
                                <a href="{{ URL::to('/checkout-venue',$venue->id) }}" class="btn btn-success btn-sm">Checkout</a>
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
        $('#userrole').DataTable();
    } );
</script>
@endsection