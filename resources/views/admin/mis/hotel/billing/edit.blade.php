@extends('admin.master')


@section('content')
    <div class="col-md-10">
        <form action="{{ route('billing.update', $bill->id) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PATCH">

            <div class="row">
                <div class="col-md-7">
                    <div class="card text-left">
                        <div class="card-header">
                            <samp>
                                {{ $bill->guest->name }}'s Bill
                                <span class="float-right">
                                    <label>Vat</label>
                                    <input type="checkbox" name="vat" value="1" {{ $bill->booking[0]->vat !=0 ? 'checked' : '' }}>
                                </span>
                            </samp>
                        </div>
                        <div class="card-body">
                            <samp>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="billing[name]" value="{{ $bill->guest->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Contact No.</label>
                                            <input type="text" class="form-control" name="billing[contact_no]" value="{{ $bill->guest->contact_no }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Org.</label>
                                            <input type="text" class="form-control" name="billing[org_name]" value="{{ $bill->guest->org_name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <input type="text" class="form-control" name="billing[designation]" value="{{ $bill->guest->designation }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Advance paid</label>
                                            <input type="number" class="form-control" name="billing[advance_paid]" value="{{ $bill->advance_paid }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Gross discount</label>
                                            <input type="number" class="form-control" name="billing[discount]" value="{{ $bill->discount }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea name="billing[note]" cols="2" rows="1" class="form-control">{{ $bill->note }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                @foreach( $bill->booking as $book )
                                    {{ $loop->iteration }}.





                                    <div class="row">
                                        <div style="width: 44%;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Check-In</label>
                                                        <input type="date" class="form-control date" name="booking[{{$book->id}}][start_date]" value="{{ $book->start_date }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Check-Out</label>
                                                        <input type="date" class="form-control date" name="booking[{{$book->id}}][end_date]" value="{{ $book->end_date }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width: 20%; margin-left: 2.5%;">
                                            <div class="form-group">
                                                <label>Room</label>
                                                <input type="text" class="form-control" value="{{ $book->room_id < 50 || $book->room_id > 100 ? $book->room->room_no.'-'.$book->room->roomCat->name : $book->venue->name }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Discount</label>
                                                <input type="number" class="form-control" name="booking[{{$book->id}}][discount]" value="{{ $data['discount'][$book->id] }}" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Visitors</label>
                                                <input type="number" class="form-control" name="booking[{{$book->id}}][no_of_visitors]" value="{{ $book->no_of_visitors }}" min="1" max="80">
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
                                            <label>Check-In*</label>
                                            <input type="date" class="form-control date check_in_date" value="{{ date('Y-m-d', strtotime(\App\Configuration::find(1)->software_start_date)) }}" id="start_date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Check-Out*</label>
                                            <input type="date" class="form-control date check_out_date" value="{{ date('Y-m-d', strtotime(\App\Configuration::find(1)->software_start_date)) }}" id="end_date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>No. Of Visitors</label>
                                            <input type="number" class="form-control" id="visitors" min="1" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-control" id="category">
                                                <option value="0">All</option>
                                                <option value="1">Room</option>
                                                <option value="2">Venue</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Room</label>
                                            <select class="form-control" id="room_id">
                                                <option></option>
                                                @foreach( $data['room'] as $item )
                                                    <option value="{{ $item->id }}" class="room">{{ $item->room_no }} - {{ $item->roomCat->name }} | <small>Price: {{ $item->price }}</small></option>
                                                @endforeach
                                                @foreach( $data['venue'] as $item )
                                                    <option value="{{ $item->id }}" class="venue">{{ $item->name }}  | Price: {{ $item->price }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Discount <small>(tk.)</small></label>
                                            <input type="number" id="discount" class="form-control" min="0" value="0">
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
            var book = {!! json_encode(count($bill->booking)) !!}

            $('#add-button').click(function () {
                // alert(22)

                var discount = $('#discount').val()
                var start_date = $('#start_date').val()
                var end_date = $('#end_date').val()
                var visitors = $('#visitors').val()
                var room_id = $('#room_id').val()

                // var date1 = new Date(start_date)
                // var date2 = new Date(end_date)
                //
                // date1 = date1.getDate()+' '+date1.getMonth() + ',' + date1.getFullYear()
                // date2 = date2.getDate()+' '+date2.getMonth() + ',' + date2.getFullYear()

                // console.log(
                //     start_date + end_date + name + contact_no
                // );




                if( !start_date || !end_date || !room_id )
                    alert('Please Enter All Required Fields')
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


                }

            })


            $(document).on('click', '.remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
                i--; book--;
            });

        })
    </script>


{{--    <script src="{{asset('js/flatpickr.min.js')}}"></script>--}}
{{--    <script src="{{asset('js/custom_datepicker.js')}}"></script>--}}

@endsection
