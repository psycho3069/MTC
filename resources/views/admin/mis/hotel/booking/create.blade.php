@extends('admin.master')


@section('content')
    <div class="col-md-9">
    <samp>
        <div class="card text-left">
            <div class="card-header">
                <b>Booking</b>
            </div>
            <div class="card-body">
                <p class="text-danger">{!! $errors->has('booking.*') ? 'Booking info is not correct! <b>Operation Unsuccessful.</b>' : '' !!}</p>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Guest Name<span class="required">*</span></label>
                            <input type="text" class="form-control" id="name" value="{{ old('guest.name') }}">
                            <p class="text-danger">{{ $errors->has('guest.name') ? 'Please Enter Guest Name' : '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Contact No<span class="required">*</span></label>
                            <input type="text" class="form-control" id="contact_no" value="{{ old('guest.contact_no') }}">
                            <p class="text-danger">{{ $errors->has('guest.contact_no') ? 'Please Enter Guest Contact' : '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" id="address" value="{{ old('guest.address') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" class="form-control" id="org_name" value="{{ old('guest.org_name') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Designation</label>
                            <input type="text" class="form-control" id="designation" value="{{ old('guest.designation') }}">
                        </div>
                    </div>
                </div>


                <hr>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Check-In<span class="required">*</span></label>
                            <input type="date" class="form-control date check_in_date"
                                   value="{{$softwareDate->date}}" id="start_date">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Check-Out<span class="required">*</span></label>
                            <input type="date" class="form-control date check_out_date"
                                   value="{{$softwareDate->date}}" id="end_date">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Room Category</label>
                            <select class="form-control" id="category">
                                <option value="0">All</option>
                                <option value="1" {{ $preSelected <50 ? 'selected' : '' }}>Room</option>
                                <option value="2" {{ $preSelected >=50 ? 'selected' : '' }}>Venue</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Room</label>
                            <select class="form-control" id="room_id">
                                <option value="">Select A Room</option>
                                @foreach( $rooms as $item )
                                    <option value="{{$item->id}}" {{$preSelected==$item->id?'selected':''}} class="room">
                                        {{$item->room_no}} - {{$item->roomCat->name}} |
                                        Price: {{$item->price}}
                                    </option>
                                @endforeach
                                @foreach( $venues as $item )
                                    <option value="{{$item->id}}" {{$preSelected==$item->id?'selected':''}}
                                    class="venue">{{ $item->name }}  | Price: {{ $item->price }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group no-wrap">
                            <label>Discount <small>(tk.)</small></label>
                            <input type="number" id="discount" class="form-control" min="0" value="0">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Visitors</label>
                            <input type="number" class="form-control" id="visitors" min="1" value="1">
                        </div>
                    </div>
                </div>
                <button type="button" id="add-button" class="btn btn-i btn-block">Add</button>
            </div>
        </div>

        <br><br><br>


        <div class="card text-left">
            <div class="card-body">
                <form method="POST" action="{{ route('booking.store') }}">
                    {{ csrf_field() }}
                    <span class="float-left">
                        <label>Vat</label>
                        <input type="checkbox" name="vat" value="1">
                    </span>
                    <span style="margin-left: 6%;">
                        <label>Restaurant</label>
                        <input type="checkbox" name="check" value="1" checked>
                    </span>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Check-In</th>
                            <th scope="col">Check-Out</th>
                            <th scope="col">Room no</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Visitors</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody id="booking">

                        </tbody>
                    </table>


                    <input type="hidden" name="guest[name]" value="{{ old('guest.name') }}">
                    <input type="hidden" name="guest[contact_no]" value="{{ old('guest.contact_no') }}">
                    <input type="hidden" name="guest[address]" value="{{ old('guest.address') }}">
                    <input type="hidden" name="guest[org_name]" value="{{ old('guest.org_name') }}">
                    <input type="hidden" name="guest[designation]" value="{{ old('guest.designation') }}">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> Advance Amount <small>(tk.)</small></label>
                                <input type="number" name="billing[advance_paid]" class="form-control" min="0" value="{{ old('billing.advance_paid') ? old('billing.advance_paid') : 0 }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Gross Discount <small>(tk.)</small></label>
                                <input type="number" class="form-control" name="billing[discount]" min="0" value="{{ old('billing.discount') ? old('billing.discount') : 0 }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Note</label>
                                <textarea class="form-control" name="billing[note]" cols="3" rows="2" value="{{ old('billing.note') }}"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>

            </div>
        </div>


    </samp>
@endsection




{{--@section('style')--}}
{{--    <link href="{{ asset('css/datepicker.min.css') }}" rel="stylesheet">--}}
{{--    <link href="{{ asset('css/flatpickr.min.css') }}" rel="stylesheet">--}}
{{--@endsection--}}


@section('script')
    <script>
        $(document).ready(function () {

            $('.room').show()
            $('.venue').show()

            $('#category').on('change',function () {
                var x = $(this).val()
                if (x == 1) {
                    $('.room').show()
                    $('#room_id').val('')
                    $('.venue').hide()
                } else if ( x == 2){
                    $('.venue').show()
                    $('#room_id').val('')
                    $('.room').hide()
                } else{
                    $('.room').show()
                    $('#room_id').val('')
                    $('.venue').show()
                }
            })
        })
    </script>


    <script>
        $(document).ready(function () {
            var i = 0;


            $(':submit').click(function (e) {
                var check = guest();

                if( check == false ){
                    e.preventDefault()
                    alert('Please Enter Guest Info Properly!')
                }

                if( i < 1 ){
                    e.preventDefault()
                    alert('Please add at least one booking')
                }
            })

            $('#add-button').click(function () {

                var discount = $('#discount').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var visitors = $('#visitors').val();
                var room_id = $('#room_id').val();

                if( !start_date || !end_date || !room_id ){
                    alert('Please select another room and check date');
                }
                else {

                    i++;
                    $('#booking').append(
                        '<tr id="row'+i+'">' +
                        '<td><input type="hidden" name="booking['+i+'][start_date]" value="'+start_date+'">'+start_date+'</td>' +
                        '<td><input type="hidden" name="booking['+i+'][end_date]" value="'+end_date+'">'+end_date+'</td>' +
                        '<td><input type="hidden" name="booking['+i+'][room_id]" value="'+room_id+'">'+$('#room_id :selected').text()+'</td>' +
                        '<td><input type="hidden" name="booking['+i+'][discount]" value="'+discount+'">'+discount+'</td>' +
                        '<td><input type="hidden" name="booking['+i+'][no_of_visitors]" value="'+visitors+'">'+visitors+'</td>' +
                        '<td><a class="btn btn-danger btn-sm remove" id="'+i+'">Remove</a></td>' +
                        '</tr>'
                    );

                    $('#room_id').find('option[value="'+room_id+'"]').attr('disabled', true);
                    $('#discount').val(0);

                }

            })


            function guest(){
                var name = $('#name').val()
                var contact_no = $('#contact_no').val()
                var address = $('#address').val()
                var org_name = $('#org_name').val()
                var designation = $('#designation').val()

                $('input[name="guest[name]"]').val(name)
                $('input[name="guest[contact_no]"]').val(contact_no)
                $('input[name="guest[address]"]').val(address)
                $('input[name="guest[org_name]"]').val(org_name)
                $('input[name="guest[designation]"]').val(designation)

                if( !name || !contact_no)
                    return false;
                return true;
            }


            $(document).on('click', '.remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
                i--
            });

        })
    </script>



    <script>
        $(document).ready(function() {
            $('.ufat').select2({
                placeholder: 'Select an option'
            });
        });
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


{{--    <script src="{{asset('js/flatpickr.min.js')}}"></script>--}}
{{--    <script src="{{asset('js/custom_datepicker.js')}}"></script>--}}

@endsection
