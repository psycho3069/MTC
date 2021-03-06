@extends('admin.master')


@section('content')
    <div class="col-md-12">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <b><code>Sale Food</code></b>
                    <b class="pull-right total">Total: <span id="total"></span></b>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">

                                <label id="guest_list">Booking Guest<span class="required">*</span></label>

                                <button type="button" class="btn btn-sm btn-i new-guest float-right">
                                    <i class="fa fa-plus-circle"></i></button>
                                <button type="button" class="btn btn-sm btn-i guest-list float-right">List</button>

                                <select class="form-control" id="bill">
                                    <option value="">Choose One</option>
                                    @foreach( $billing as $bill )
                                        <option value="{{ $bill->id }}" {{$data['bill_id']==$bill->id?'selected':''}}>
                                            {{ $bill->guest->name }}</option>
                                    @endforeach
                                </select>

                                <label id="new_guest">Guest Name<span class="required">*</span></label>
                                <input type="text" class="form-control" id="guest_name" name="guest_name">
                                <label id="guest_contact_label">Guest Contact<span class="required">*</span></label>
                                <input type="text" class="form-control" id="guest_contact" name="guest_contact">


                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Menu Type<span class="required">*</span></label>
                                <select class="form-control" id="menu_type">
                                    <option></option>
                                    @foreach( $data['menu_type'] as $item )
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Menu<span class="required">*</span></label>
                                <select class="form-control" id="menu">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Quantity<span class="required">*</span></label>
                                <input type="text" class="form-control" id="quantity" min="1" max="100" value="1">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Discount <small>(tk.)</small><span class="required">*</span></label>
                                <input type="text" class="form-control" id="discount" value="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" id="add-button" class="btn btn-i btn-block">Add</button>
                </div>
            </div>
        </samp>
        <br>


        <samp>
            <div class="card text-left">
                <div class="card-body">
                    <form method="POST" action="{{ route('sales.store') }}">
                        {{ csrf_field() }}

                        <span class="float-left">
                            <label>Vat</label>
                            <input type="checkbox" name="vat" value="1" checked>
                        </span>
                        <span style="margin-left: 6%;">
                            <label>Service Charge</label>
                            <input type="checkbox" name="service_charge" value="1">
                        </span>

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Guest Name</th>
                                <th scope="col">Item</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="list">

                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-dark">Submit</button>
                    </form>

                </div>
            </div>
        </samp>



    </div>



@endsection

@section('script')

    <script>
        $(document).ready(function () {

            //default
            displayList('list')

            $('.guest-list').click(function () {
                displayList('list')
            });

            $('.new-guest').click(function () {
                displayList('new')
            });

            function displayList( flag){
                if( flag == 'new'){
                    $('#bill').val('')
                    $('#bill').hide()
                    $('.guest-list').show()
                    $('.new-guest').hide()
                    $('#new_guest').show()
                    $('#guest_list').hide()
                    $('#guest_contact').show()
                    $('#guest_name').show()
                    $('#guest_contact_label').show()
                }

                if ( flag == 'list'){
                    $('#bill').show()
                    $('.guest-list').hide()
                    $('.new-guest').show()
                    $('#new_guest').hide()
                    $('#guest_list').show()
                    $('#guest_contact').hide()
                    $('#guest_name').hide()
                    $('#guest_contact_label').hide()

                    // $('.list-supplier').show()
                    // $('.list-sup-btn').show()
                    // $('#supplier').data('check', 'list')
                    //
                    // $('.add-supplier').hide()
                    // $('.add-sup-btn').hide()
                }
            }

            var _token = $('input[name="_token"]').val(); var all_menu = [];

            $('#menu_type').on('change', function () {
                var menu_type = $('#menu_type').val();
                getMenu( menu_type)
                $('#total').empty()
            })


            $('#menu').on('change', function () {
                getPrice()
            })



            $('#quantity').on('change keyup', function () {
                getPrice()
            })



            function getPrice() {
                var menu_id = $('#menu').val(); var price = 0; var total = 0;
                // alert(menu_id)
                $.each(all_menu, function (key, val) {
                    if ( key == menu_id)
                        price = val['price']
                })
                total = price * $('#quantity').val()
                $('#total').html(total+' tk.')
            }

            function getMenu(menu_type){
                $.ajax({
                    type: 'POST',
                    url: '{{ route("food.menu") }}',
                    data: {_token: _token, menu_type: menu_type},
                    success: function (data) {
                        var menu = $('#menu');
                        menu.empty()
                        $.each(data['menu'], function (key, val) {
                            // console.log(val)
                            menu.append('<option value="'+key+'">'+val['name']+'- '+val['price']+'tk.'+'</option>')
                        })
                        all_menu = data['menu']
                        getPrice()
                    }
                })
            }


        })
    </script>


    <script>
        $(document).ready(function () {
            var i = 0;


            // alert(55)
            var bill_id = {!! json_encode($data['bill_id']) !!}

            $(':submit').click(function (e) {
                if( i < 1 ){
                    e.preventDefault()
                    // alert('Please add at least one item')
                    bill_id ? window.location.href = '{{ route('billing.show', $data['bill_id']) }}' : alert('Please add at least one item')

                }
            })

            $('#add-button').click(function () {

                var total = $('#total').text()
                var bill = $('#bill').val()
                var menu = $('#menu').val()
                var quantity = $('#quantity').val()
                var discount = $('#discount').val()
                var guest_name = $('#guest_name').val()
                var guest_contact = $('#guest_contact').val()

                if( !(bill || (guest_name && guest_contact)) || !menu || !quantity)
                    alert('Please Enter all fields')
                else {

                    i++

                    if( i > 0 ){
                        document.getElementById('guest_name').readOnly = true;
                        document.getElementById('guest_contact').readOnly = true;
                    }

                    if(!bill){
                        $('#list').append(
                            '<tr id="row'+i+'">' +
                            //billing hidden value '0'
                            '<input type="hidden" name="input['+i+'][billing_id]" value="'+0+'">' +
                            //guest name
                            '<td><input type="hidden" name="input['+i+'][guest_name]" value="'+guest_name+'">'+$('#guest_name').val()+'</td>' +
                            //guest contact
                            '<input type="hidden" name="input['+i+'][guest_contact]" value="'+guest_contact+'">' +

                            '<td><input type="hidden" name="input['+i+'][menu_id]" value="'+menu+'">'+$('#menu :selected').text()+'</td>' +
                            '<td><input type="hidden" name="input['+i+'][quantity]" value="'+quantity+'">'+quantity+'</td>' +
                            '<td>'+total+'</td>' +
                            '<td><input type="hidden" name="input['+i+'][discount]" value="'+discount+'">'+discount+'</td>' +
                            '<td><a class="btn btn-danger btn-sm remove" id="'+i+'">Remove</a></td>' +
                            '</tr>'
                        )
                    } else {
                        $('#list').append(
                            '<tr id="row'+i+'">' +
                            '<td><input type="hidden" name="input['+i+'][billing_id]" value="'+bill+'">'+$('#bill :selected').text()+'</td>' +
                            '<td><input type="hidden" name="input['+i+'][menu_id]" value="'+menu+'">'+$('#menu :selected').text()+'</td>' +
                            '<td><input type="hidden" name="input['+i+'][quantity]" value="'+quantity+'">'+quantity+'</td>' +
                            '<td>'+total+'</td>' +
                            '<td><input type="hidden" name="input['+i+'][discount]" value="'+discount+'">'+discount+'</td>' +
                            '<td><a class="btn btn-danger btn-sm remove" id="'+i+'">Remove</a></td>' +
                            '</tr>'
                        )
                    }
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
