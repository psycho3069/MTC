@extends('admin.master')


@section('content')
    <div class="col-md-8">
    <samp>
        <div class="card text-left">
            <div class="card-header">
                Book Room
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Guest Name*</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Contact No*</label>
                            <input type="text" class="form-control" id="contact_no">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" id="address">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" class="form-control" id="org_name">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Designation</label>
                            <input type="text" class="form-control" id="designation">
                        </div>
                    </div>
                </div>


                <hr>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Check-In*</label>
                            <input type="date" class="form-control date" id="start_date" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Check-Out*</label>
                            <input type="date" class="form-control date" id="end_date" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Select Category</label>
                            <select class="form-control" id="category">
                                <option value="0">All</option>
                                <option value="1" {{ $data['selected'] <50 ? 'selected' : '' }}>Room</option>
                                <option value="2" {{ $data['selected'] >=50 ? 'selected' : '' }}>Venue</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Select a Room</label>
                            <select class="form-control" id="room_id">
                                <option></option>
                                @foreach( $data['room'] as $item )
                                    <option value="{{ $item->id }}" {{ $data['selected'] == $item->id ? 'selected' : '' }} class="room">{{ $item->room_no }} - {{ $item->roomCat->name }} | <small>Price: {{ $item->price }}</small></option>
                                @endforeach
                                @foreach( $data['venue'] as $item )
                                    <option value="{{ $item->id }}" {{ $data['selected'] == $item->id ? 'selected' : '' }} class="venue">{{ $item->name }}  | Price: {{ $item->price }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group no-wrap">
                            <label>Discount <small>(tk.)</small></label>
                            <input type="number" id="discount" class="form-control" min="0" value="0">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Visitors</label>
                            <input type="number" class="form-control" id="visitors" min="1" value="1">
                        </div>
                    </div>
                </div>


                <button type="button" id="add-button" class="btn btn-default btn-block">Add</button>

                {{--                <button type="submit" class="btn btn-primary">Submit</button>--}}
            </div>
        </div>

        <br><br><br>


        <div class="card text-left">
            <div class="card-body">
                <form method="POST" action="{{ route('booking.store') }}">
                    {{ csrf_field() }}
                @if(!$data['reserved'])
                    <span class="float-left">
                        <label>With Restaurant</label>
                        <input type="checkbox" name="check" value="1" checked>
                    </span>
                @endif

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


                    <input type="hidden" name="guest[name]" required>
                    <input type="hidden" name="guest[contact_no]" required>
                    <input type="hidden" name="guest[address]">
                    <input type="hidden" name="guest[org_name]">
                    <input type="hidden" name="guest[designation]">
                    <input type="hidden" name="billing[reserved]" value="{{ $data['reserved'] }}">

                    <div class="row">
                        @if( !$data['reserved'])
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label> Advance Amount <small>(tk.)</small></label>
                                    <input type="number" name="billing[advance_paid]" class="form-control" min="0" value="0" {{ $data['reserved'] ? 'disabled' : 'required' }}>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Gross Discount <small>(tk.)</small></label>
                                <input type="number" name="billing[discount]" value="0" min="0" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Note</label>
                                <textarea class="form-control" name="billing[note]" cols="3" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark">Submit</button>
                </form>

            </div>
        </div>


    </samp>
@endsection


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
                if( i < 1 ){
                    e.preventDefault()
                    alert('Please add at least one booking')
                }
            })

            $('#add-button').click(function () {
                var name = $('#name').val()
                var contact_no = $('#contact_no').val()
                var address = $('#address').val()
                var org_name = $('#org_name').val()
                var designation = $('#designation').val()

                var discount = $('#discount').val()
                var start_date = $('#start_date').val()
                var end_date = $('#end_date').val()
                var visitors = $('#visitors').val()
                var room_id = $('#room_id').val()

                // console.log(
                //     start_date + end_date + name + contact_no
                // );


                if( !start_date || !end_date || !name || !contact_no || !room_id )
                    alert('Please Enter All Required Fields')
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
                    )


                    $('input[name="guest[name]"]').val(name)
                    $('input[name="guest[contact_no]"]').val(contact_no)
                    $('input[name="guest[address]"]').val(address)
                    $('input[name="guest[org_name]"]').val(org_name)
                    $('input[name="guest[designation]"]').val(designation)

                    $('#room_id').find('option[value="'+room_id+'"]').attr('disabled', true)


                }

            })


            $(document).on('click', '.remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
                i--
            });

        })
    </script>





@endsection
