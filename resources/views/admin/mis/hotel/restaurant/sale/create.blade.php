@extends('admin.master')


@section('content')
    <style>
        .required{
            color: #ff0000;
        }
    </style>
    <div class="col-md-5">
        <samp>
            <div class="card">
                <div class="card-header text-left">
                    Sale Food
                </div>
                <div class="card-body text-left">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Guest</label>
                                <select class="form-control" id="bill">
                                    <option value="">Choose One</option>
                                    @foreach( $billing as $bill )
                                        <option value="{{ $bill->id }}" {{ $data['bill_id'] == $bill->id ? 'selected' : '' }}>{{ $bill->guest->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Menu Type</label>
                                <select class="form-control" id="menu_type">
                                    {{--                                <option></option>--}}
                                    @foreach( $data['menu_type'] as $item )
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Menu</label>
                                <select class="form-control" id="menu">
                                    {{--                                <option></option>--}}
                                    @foreach( $data['menu_type'] as $type )
                                        @foreach( $type->menu as $item )
                                            <option value="{{ $item->id }}">{{ $item->name }} </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" class="form-control" id="quantity" min="1" max="100" value="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" id="add-button" class="btn btn-default btn-block">Add</button>
                </div>
            </div>
        </samp>
        <br><br>



        <samp>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('sales.store') }}">
                        {{ csrf_field() }}

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Guest Name</th>
                                <th scope="col">Item</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="list">

                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-dark float-right">Submit</button>
                    </form>

                </div>
            </div>
        </samp>



    </div>



@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var i = 0;
            // alert(55)

            $(':submit').click(function (e) {
                if( i < 1 ){
                    e.preventDefault()
                    alert('Please add at least one item')
                }
            })

            {{--$('#bill').on('change', function () {--}}
            {{--    var bill_id = $(this).val()--}}
            {{--    var _token = $("input[name='_token']").val();--}}


            {{--    $.ajax({--}}
            {{--        type:'POST',--}}
            {{--        url: '{{ route("sales.room") }}',--}}
            {{--        data: {_token:_token, bill_id:bill_id },--}}
            {{--        success:function (data) {--}}
            {{--            // console.log(data)--}}
            {{--            var item = $('#room')--}}
            {{--            item.empty()--}}
            {{--            item.append('<option value="">Choose a Room</option>')--}}
            {{--            $.each(data, function (key, val) {--}}
            {{--                item.append('<option value="'+key+'">'+val+'</option>')--}}
            {{--            })--}}
            {{--        }--}}
            {{--    })--}}
            {{--})--}}



            $('#add-button').click(function () {
                var bill = $('#bill').val()
                // var room = $('#room').val()
                var menu = $('#menu').val()
                var quantity = $('#quantity').val()

                if( !bill || !menu || !quantity)
                    alert('Please Enter all fields')
                else {
                    i++
                    $('#list').append(
                        '<tr id="row'+i+'">' +
                        '<td><input type="hidden" name="input['+i+'][billing_id]" value="'+bill+'">'+$('#bill :selected').text()+'</td>' +
                        // '<td><input type="hidden" name="input['+i+'][booking_id]" value="'+room+'">'+$('#room :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][menu_id]" value="'+menu+'">'+$('#menu :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][quantity]" value="'+quantity+'">'+quantity+'</td>' +
                        '<td><a class="btn btn-danger btn-sm remove" id="'+i+'">Remove</a></td>' +
                        '</tr>'
                    )
                }
            })


            $(document).on('click', '.remove', function(){
                var button_id = $(this).attr('id')
                $('#row'+button_id).remove()
                i--
            })


        })

    </script>
@endsection
