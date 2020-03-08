@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><big><strong>VENUE BILLING LIST</strong></big></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
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

                <table id="room_billing" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">Name of Person / Organization</th>
                            <th width="10%">Contact No</th>
                            <th width="15%">Start Date</th>
                            <th width="15%">End Date</th>
                            <th width="15%">Venue</th>
                            <th width="5%">Advance Payment</th>
                            <th width="5%">Total Payment</th>
                            <th width="5%">Total Day</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($venue_billings as $key => $row)
                        <tr>
                            <td width="5%">{{ ++$key }}</td>
                            <td>
                                @foreach($booking_info as $row_book)
                                    @if($row_book->id == $row->venue_booking_id)
                                        {{$row_book->name}}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($booking_info as $row_book)
                                    @if($row_book->id == $row->venue_booking_id)
                                        {{$row_book->contact_no}}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($booking_info as $row_book)
                                    @if($row_book->id == $row->venue_booking_id)
                                        {{date("d-m-Y", strtotime($row_book->start_date))}}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($booking_info as $row_book)
                                    @if($row_book->id == $row->venue_booking_id)
                                        @if($row_book->end_date != NULL)
                                            {{date("d-m-Y", strtotime($row_book->end_date))}}
                                        @else
                                            {{'Reserved for One Day'}}
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($booking_info as $row_book)
                                    @if($row_book->id == $row->venue_booking_id)
                                        @foreach($allvenueinfo as $value)
                                            @if($value->id == $row_book->venue_id)
                                                {{$value->name}}
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$row->advanced_pay}}/-</td>
                            <td>{{$row->total_pay}}/-</td>
                            <td>{{$row->total_day}}</td>
                            <td width="10%" align="center">
                              <a href="{{URL::to('/training/deletebilling/'.$row->id)}}" class="" title="Delete" id="delete"><img src="{{asset('img')}}/delete.png" alt="delete" height="20px" width="20px"></a>
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
        $('#room_billing').DataTable({
            "paging": true,
            "ordering":  true,
            "pagingType": "full_numbers"
          });
    } );
</script>

@endsection