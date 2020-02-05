@extends('admin.master')


@section('content')
    <div class="col-md-9">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <b>Deliver Item</b>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="stock_head_id">Category</label>
                                <select class="form-control" id="category" required>
                                    @foreach( $stock_head as $item )
                                        <option value="{{ $item->id }}">{{ $item->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Item</label>
                                <select class="form-control" id="item" >
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Stock <span class="unit"></span></label>
                                <input type="number" class="form-control" id="stock" value="0" disabled>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="text" class="form-control" id="quantity" value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Unit</label>
                                <select class="form-control" id="unit" >
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="button" id="add-button" class="btn btn-i btn-block">Add</button>
                </div>
            </div>
        </samp>
    </div>

    <br><br>

    <div class="col-md-9">
        <samp>
            <div class="card text-left">
                <div class="card-header"><b>Delivery List</b></div>
                <div class="card-body purchase-list">
                    <form method="POST" action="{{ route('deliver.store') }}" >
                        {{ csrf_field() }}

                        <table class="table table-primary">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="list-item">
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
            var units = @json($data['units']);
            // console.log(units)
            var i = 0;
            var items = [];
            var _token = $("input[name='_token']").val();
            getItems()



            $(':submit').click(function (e) {
                if( i < 1 ){
                    e.preventDefault()
                    alert('Please add at least one item')
                }
            })

            $('#category').on('change', function () {
                $('#item').val('');
                getItems()

            })





            function getItems() {
                $('#stock').val(0); $('#quantity').val(0);
                $('#item').empty();
                var id = $('#category').val();

                $.ajax({
                    type:'POST',
                    url: '{{ route("purchase.item") }}',
                    data: { _token: _token, id: id},
                    success:function (data) {
                        // console.log(data['item'])
                        var item = $('#item'); var stock = $('#stock');
                        item.empty(); stock.empty();
                        items = data['item']

                        $.each(data['item'], function (key, val) {
                            // console.log(data['stock'][key])
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
                $('#stock').val(items[id]['stock'])
                $('.unit').text('('+items[id]['unit']+')')
            }




            $('#item').on('change', function () {
                getUnit()
            })










            $('#add-button').click(function () {

                var item_id = parseInt($('#item').val())
                var unit_id = parseInt($('#unit').val())
                var quantity = parseFloat( $('#quantity').val() )

                var msg1 = 'Please Select an Item';
                var msg2 = 'Please Enter Some Quantity to Deliver'
                var msg3 = 'Please Select a Unit'

                !item_id ? alert(msg1) : ( !quantity ? alert(msg2) : ( !unit_id ? msg3 : ''))

                if( item_id && quantity && unit_id )
                 {
                    i++
                    $('#list-item').append(
                        '<tr id="row'+i+'">' +
                        '<td>'+i+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][stock_id]" value="'+item_id+'">'+$('#item :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][quantity]" value="'+quantity+'"><input type="hidden" name="input['+i+'][unit_id]" value="'+unit_id+'">'+quantity +' '+ $('#unit :selected').text() +'</td>' +
                        '<td><a class="btn btn-danger btn-sm remove" id="'+i+'">Remove</a></td>' +
                        '</tr>'
                    )

                    $('#quantity').val(0)
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
