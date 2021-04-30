@extends('admin.master')


@section('reports')
    <div class="col-md-12">
        <form action="{{route('billing.update', $billing->id)}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">

            <div class="row">
                <div class="col-md-7">
                    <div class="card text-left">
                        <div class="card-header">
                            <samp>
                                {{$billing->guest->name}}'s Bill
                                <span class="float-right">
                                    <label>Vat</label>
                                    <input type="checkbox" name="vat" value="1" {{$billing->getBookingVat() ? 'checked' : ''}}>
                                </span>
                            </samp>
                        </div>
                        <div class="card-body">
                            <samp>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="guest[name]"
                                                   value="{{$billing->guest->name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Contact No.</label>
                                            <input type="text" class="form-control" name="guest[contact_no]"
                                                   value="{{$billing->guest->contact_no}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Org.</label>
                                            <input type="text" class="form-control" name="guest[org_name]"
                                                   value="{{$billing->guest->org_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <input type="text" class="form-control" name="guest[designation]"
                                                   value="{{$billing->guest->designation}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Advance paid</label>
                                            <input type="number" class="form-control" name="billing[advance_paid]"
                                                   value="{{$billing->advance_paid}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Gross discount</label>
                                            <input type="number" class="form-control" name="billing[discount]"
                                                   value="{{$billing->discount}}"
                                                {{$billing->checkoutStatus()?'disabled':''}}>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea name="billing[note]" cols="2" rows="1" class="form-control">
                                                {{$billing->note}}</textarea>
                                        </div>
                                    </div>
                                </div>


                                <hr>

                                @foreach($billing->booking as $booking )
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label></label>
                                                <p>{{$loop->iteration}}. {{$roomDetails[$booking->room_id]}}</p>
                                                <input type="hidden" name="booking[{{$booking->id}}][room_id]"
                                                       value="{{$booking->room_id}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Check-In</label>
                                                <input type="date" class="form-control date"
                                                       name="booking[{{$booking->id}}][start_date]"
                                                       value="{{$booking->start_date}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Check-Out</label>
                                                <input type="date" class="form-control date"
                                                       name="booking[{{$booking->id}}][end_date]"
                                                       value="{{$booking->end_date}}">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Discount</label>
                                                <input type="number" class="form-control"
                                                       name="booking[{{$booking->id}}][discount]"
                                                       value="{{$discounts[$booking->id]}}" min="0" {{$billing->checkout_status?'disabled':''}}>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Visitors</label>
                                                <input type="number" class="form-control"
                                                       name="booking[{{$booking->id}}][no_of_visitors]"
                                                       value="{{$booking->no_of_visitors}}"
                                                       min="1" max="80">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <hr>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th scope="col">Check-In</th>
                                        <th scope="col">Check-Out</th>
                                        <th scope="col">Room no</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Visitors</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="add-list">

                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-dark">Update</button>
                            </samp>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card card-booking">
                        <div class="card-header"><samp>Add new booking</samp></div>
                        <div class="card-body">
                            <samp>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Check-In<span class="required">*</span></label>
                                            <input type="date" class="form-control date check_in_date"
                                                   value="{{$softwareDate->date}}"
                                                   id="start_date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Check-Out<span class="required">*</span></label>
                                            <input type="date" class="form-control date check_out_date"
                                                   value="{{$softwareDate->date}}"
                                                   id="end_date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Discount <small>(tk.)</small></label>
                                            <input type="number" id="discount" class="form-control" min="0" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No. Of Visitors</label>
                                            <input type="number" class="form-control" id="visitors" min="1" value="1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-control" id="category">
                                                <option value="0">All</option>
                                                <option value="1">Room</option>
                                                <option value="2">Venue</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Room</label>
                                            <select class="form-control" id="room_id">
                                                <option value="">Select a room</option>
                                                @foreach( $rooms as $room )
                                                    <option value="{{$room->id}}" class="room">
                                                        {{$room->room_no}} - {{$room->roomCat->name}} |
                                                        Price: {{$room->price}}
                                                    </option>
                                                @endforeach
                                                @foreach( $venues as $venue )
                                                    <option value="{{$venue->id}}" class="venue">
                                                        {{$venue->name}}  |
                                                        Price: {{$venue->price}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>



                                <button type="button" class="btn btn-block btn-i pull-right" id="add-button">Add</button>
                            </samp>
                        </div>
                    </div>
                </div> {{--end Booking--}}

            </div>

        </form>
    </div>
@endsection



{{--@section('style')--}}
{{--    <link href="{{asset('css/datepicker.min.css')}}" rel="stylesheet">--}}
{{--    <link href="{{asset('css/flatpickr.min.css')}}" rel="stylesheet">--}}
{{--@endsection--}}



@section('script')
    <script>
        $(document).ready(function () {

            $('.room').show()
            $('.venue').show()

            $('#category').on('change',function () {
                showRoomByCategory();
            });
        });


        function showRoomByCategory(){
            var category = $("#category").val();

            if (category == 1) {
                $('.room').show();
                $('#room_id').val('');
                $('.venue').hide();
            } else if (category == 2){
                $('.venue').show();
                $('#room_id').val('');
                $('.room').hide();
            } else{
                $('.room').show();
                $('#room_id').val('');
                $('.venue').show();
            }
        }
    </script>


    <script>
        $(document).ready(function () {
            var i = 0;
            var book = "@json(count($billing->booking))";

            $('#add-button').click(function () {
                var discount = $('#discount').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var visitors = $('#visitors').val();
                var room_id = $('#room_id').val();



                if( !start_date || !end_date || !room_id ){
                    alert('Please select a room and check date');
                }
                else {
                    book++; i++;
                    $('#add-list').append(
                        '<tr id="row'+i+'">' +
                        '<td>'+book+'.</td>' +
                        '<td><input type="hidden" name="new_booking['+i+'][start_date]" value="'+start_date+'">'+start_date+'</td>' +
                        '<td><input type="hidden" name="new_booking['+i+'][end_date]" value="'+end_date+'">'+end_date+'</td>' +
                        '<td><input type="hidden" name="new_booking['+i+'][room_id]" value="'+room_id+'">'+$('#room_id :selected').text()+'</td>' +
                        '<td><input type="hidden" name="new_booking['+i+'][discount]" value="'+discount+'">'+discount+'</td>' +
                        '<td><input type="hidden" name="new_booking['+i+'][no_of_visitors]" value="'+visitors+'">'+visitors+'</td>' +
                        '<td><a class="btn btn-danger btn-sm remove" id="'+i+'">Remove</a></td>' +
                        '</tr>'
                    )

                    $('#room_id').find('option[value="'+room_id+'"]').attr('disabled', true)
                    showRoomByCategory();

                }

            })


            $(document).on('click', '.remove', function(){
                var button_id = $(this).attr("id");
                let room_id = $('[name="new_booking['+button_id+'][room_id]"]').val();
                $('#room_id').find('option[value='+room_id+']').attr('disabled', false);
                $('#row'+button_id+'').remove();
                i--; book--;
            });

        })
    </script>


{{--    <script src="{{asset('js/flatpickr.min.js')}}"></script>--}}
{{--    <script src="{{asset('js/custom_datepicker.js')}}"></script>--}}

@endsection
