@extends('admin.master')


@section('content')
    <style>
        .required{
            color: #ff0000;
        }
    </style>
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                <b>{{ $booking->room_id < 50 ? 'Room No-'.$booking->room->room_no : $booking->venue->name }} Visitors</b>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name*</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact No.</label>
                                <input type="text" class="form-control" id="contact_no">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" id="address">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-light pull-right add-more">Add</button>
                </form>
            </div>
        </div>

        <br><br><br>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('visitor.store') }}">
                    {{ csrf_field() }}

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Name</th>
                            <th scope="col">Contact No.</th>
                            <th scope="col">Address</th>
                        </tr>
                        </thead>
                        <tbody id="visitant">

                        </tbody>
                    </table>
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    <button type="submit" class="btn btn-dark">Submit</button>

                </form>
            </div>
        </div>
    </div>




@endsection


@section('script')
    <script>
        $(document).ready(function () {
            var i = 0;

            $(':submit').click(function (e) {
                if( i < 1 ){
                    e.preventDefault()
                    alert('Please add at least one Visitor')
                }
            })

            $('.add-more').click(function () {

                var name = $('#name').val()
                var contact_no = $('#contact_no').val()
                var address = $('#address').val()

                if( !name )
                    alert('Please Enter all required fields')
                else {

                    i++;
                    $('#visitant').append(
                        '<tr id="row'+i+'">' +
                        '<td>'+i+'</td>'+
                        '<td><input type="hidden" name="input['+i+'][name]" value="'+name+'">'+name+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][contact_no]" value="'+contact_no+'">'+contact_no+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][address]" value="'+address+'">'+address+'</td>' +
                        '<td><a class="btn btn-danger btn-sm remove" id="'+i+'">Remove</a></td>' +
                        '</tr>'
                    )

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
