@extends('admin.master')


@section('content')

    <div class="col-md-8">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <div class="col-md-6">
                        <b>Purchase {{ $cat_id != 4 ? 'Inventory' : 'Grocery' }} Item</b>
                    </div>

                </div>
                <div class="card-body">
                    <p class="text-danger">{{ $errors->has('mis_head_id') ? $errors->first('mis_head_id') : '' }}</p>
                    <p class="text-danger">{{ $errors->has('input.*.*') ? $errors->first('input.*.*') : '' }}</p>
                    <p class="text-danger">{{ $errors->has('input.*.amount') ? $errors->first('input.*.amount') : '' }}</p>
                    <p class="text-danger">{{ $errors->has('input.*.quantity_dr') ? $errors->first('input.*.quantity_dr') : '' }}</p>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Select a category</label>
                                <select class="form-control" id="category">
                                    @foreach( $mis_heads as $item )
                                        <option value="{{ $item->id }}">{{ $item->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Total Cost <small>(tk)</small><span class="required">*</span></label>
                                <input type="text" class="form-control" id="amount" value="0" min="0">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Item</label>
                                <select class="form-control" id="item" >
                                    <option></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Quantity<span class="required">*</span></label>
                                <input type="text" class="form-control" id="quantity" value="0">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group list-supplier">
                                    <label>Supplier<span class="required">*</span></label>
                                    <select class="form-control" id="supplier" data-check="list">
                                        @foreach( $data['supplier'] as $item )
                                            <option value="{{ $item->id }}">{{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group add-supplier">
                                    <label>Supplier <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="sup_name">
                                </div>
                                <div class="form-group add-supplier">
                                    <label>Contact No. <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="sup_contact">
                                </div>
                                <div>
                                    <button type="button" class="btn btn-sm btn-i list-sup-btn">New</button>
                                    <button type="button" class="btn btn-sm btn-i add-sup-btn">List</button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Unit<span class="required">*</span></label>
                                        <select class="form-control" id="unit">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Receiver<span class="required">*</span></label>
                                        <select class="form-control" id="receiver">
                                            @foreach( $data['receiver'] as $item )
                                                <option value="{{ $item->id }}">{{ $item->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" id="add-button" class="btn btn-info btn-block">Add</button>
                </div>
            </div>
        </samp>
    </div>

    <br><br>

    <div class="col-md-8">
        <samp>
            <div class="card text-left">
                <div class="card-header"><b>Purchased List</b></div>
                <div class="card-body purchase-list">
                    <form method="POST" action="{{ route('purchase.store') }}" >
                        {{ csrf_field() }}
                        <input type="hidden" name="mis_head_id" value="{{ $cat_id }}">

                        <table class="table table-info">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Supplier</th>
                                <th>Receiver</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="list-item">
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label>Note</label>
                            <textarea name="note" class="form-control" cols="3" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label  style="color: #0f3e68; font-size: larger;">Cumulative Total Cost
                                    <b class="no-wrap" id="total_cost" style="color: #0000FF; font-size: larger;">0</b> Tk.
                                </label>
                            </div>
                        </div>
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
            var units = @json($data['units']);
            var i = 0;
            var items = [];
            var _token = $("input[name='_token']").val();

            getItems()

            $(':submit').click(function (e) {
                if( i < 1 ){
                    e.preventDefault()
                    alert('Please add at least one item')
                }
            });


            $('#item').on('change', function () {
                getUnit()
            });



            $('#category').on('change', function () {
                getItems()
            });


            $('.list-sup-btn').click(function () {
                displayList('hide')
            });

            $('.add-sup-btn').click(function () {
                displayList('show')
            });


            var click = 0; var add = 1;

            $('#add-button').click(function () {
                click += 1;

                var check = $('#supplier').data('check')

                if ( check == 'new'){
                    var name = $.trim( $('#sup_name').val());
                    var contact_no = $.trim( $('#sup_contact').val())

                    if( !name || !contact_no)
                        alert( 'Please Enter Supplier Info')

                    if ( name && contact_no){
                        getSupplier( name, contact_no)
                        $(document).ajaxStop(function () {
                            if ( click == add)
                                appendItems()
                        })
                    }
                }

                if( check == 'list')
                    appendItems()

            });



            function getItems(){
                $('#stock').val(0); $('#quantity').val(0);
                $('#item').empty();
                var id = $('#category').val()

                $.ajax({
                    type:'POST',
                    url: '{{ route("purchase.item") }}',
                    data: {_token: _token, id: id },
                    success:function (data) {
                        // console.log(data)
                        items = data['item'];
                        var item = $('#item'); item.empty();

                        $.each(data['item'], function (key, val) {
                            item.append('<option value="'+key+'">'+val['name']+'</option>')
                        })
                        getUnit()
                    }
                })
            }



            function getUnit() {
                var id = $('#item').val()
                var unit = $('#unit'); unit.empty();
                // console.log( items[id]['unit_type_id'])

                $.each( units, function (key, val) {
                    if ( val['unit_type_id'] == items[id]['unit_type_id'])
                        unit.append('<option value="'+val["id"]+'">'+val['name']+ '</option>')
                })

                $('#quantity').val(0)
            }



            function displayList( flag){
                if( flag == 'hide'){
                    $('.list-supplier').hide()
                    $('.list-sup-btn').hide()

                    $('.add-supplier').show()
                    $('.add-sup-btn').show()
                    $('#supplier').data('check', 'new')
                }


                if ( flag == 'show'){
                    $('.list-supplier').show()
                    $('.list-sup-btn').show()
                    $('#supplier').data('check', 'list')

                    $('.add-supplier').hide()
                    $('.add-sup-btn').hide()
                }
            }


            var total_cost = $('#total_cost').text();
            function appendItems(){
                add += 1;

                var item_id = parseInt($('#item').val())
                var quantity = parseFloat($('#quantity').val()).toFixed(3)
                var unit_id = parseInt($('#unit').val())
                var supplier = parseInt($('#supplier').val())
                var category = parseInt($('#category').val())

                var receiver = parseInt($('#receiver').val())
                var amount = parseFloat($('#amount').val()).toFixed(2)


                var msg1 = 'Please Select an Item';
                var msg2 = 'Please Enter Some Quantity to Purchase';
                var msg3 = 'Please Select a Unit';
                var msg4 = 'Please Select a Supplier';
                var msg5 = 'Please Select Enter Some Amount';

                var msg = !item_id ? msg1 : ( !quantity ? msg2 : ( !unit_id ? msg3 : ( !supplier ? msg4 : ( !amount ? msg5 : ''))))

                // msg ? alert(msg) : alert('No msg')



                // console.log('1st ->'+ supplier)
                // getSupplier()

                !item_id ? alert(msg1) : ( quantity == 0 ? alert(msg2) : '')


                if( !item_id || !quantity || !amount || !supplier || !receiver)
                    alert('Please Enter all fields')

                if( item_id && quantity > 0 && amount && supplier && receiver) {
                    supplier = $('#supplier').val()
                    console.log('2nd ->'+ supplier)

                    i++
                    $('#list-item').append(
                        '<tr id="row'+i+'">' +
                        '<td>'+i+'</td>' +
                        // '<td>'+$('#category :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][stock_id]" value="'+item_id+'">'+$('#item :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][quantity_dr]" value="'+quantity+'"> <input type="hidden" name="input['+i+'][unit_id]" value="'+unit_id+'">'+quantity+' '+ $('#unit :selected').text()+'</td>' +
                        '<td><input type="hidden" id="cost'+i+'" name="input['+i+'][amount]" value="'+amount+'">'+amount+' tk.'+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][supplier_id]" value="'+supplier+'">'+$('#supplier :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][receiver_id]" value="'+receiver+'">'+$('#receiver :selected').text()+'</td>' +
                        '<td><a class="btn btn-danger btn-sm remove" id="'+i+'">Remove</a></td>' +
                        '</tr>'
                    )

                    // CALCULATING CUMULATIVE TOTAL COST
                    var cost = $('#amount').val();
                    total_cost = parseFloat(total_cost)
                    total_cost += parseFloat(cost)
                    // console.log(total_cost)
                    $('#total_cost').text( total_cost)
                }
            }


            function getSupplier(name, contact_no) {

                if ( name && contact_no){
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('add.supplier') }}",
                        data: {_token: _token, name: name, contact_no: contact_no },
                        success: function (data) {

                            var check = $('#supplier').find('option[value="'+data["id"]+'"]')
                            displayList('show')

                            if( check.length > 0){
                                // $('#supplier option[value="'+data["id"]+'"]').attr('selected', true)
                                $('#supplier').val(data['id']).trigger('chosen:updated')
                            }
                            else{
                                $('#supplier').append('<option value="'+data["id"]+'">'+data['name']+'</option>')
                                $('#supplier').val(data['id']).trigger('chosen:updated')
                            }

                            $('#supplier').val(data['id']).attr('selected', 'selected')
                        }
                    })

                }

                // console.log('main ->'+ id)
            }


            $(document).on('click', '.remove', function(){
                var button_id = $(this).attr('id')

                var cost = $('#cost'+button_id).val()
                total_cost = parseFloat(total_cost) - cost
                // console.log(total_cost);
                $('#total_cost').text( total_cost)

                $('#row'+button_id).remove()
                i--
            })


        })

    </script>
@endsection
