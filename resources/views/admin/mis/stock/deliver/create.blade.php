@extends('admin.master')


@section('content')
    <style>
        .required{
            color: #ff0000;
        }
    </style>
    <div class="col-md-8">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Stock <span class="unit"></span></label>
                                <input type="number" class="form-control" id="stock" value="0" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Quantity <span class="unit"></span></label>
                                <input type="text" class="form-control" id="quantity" value="0" min="0">
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

    <div class="col-md-8">
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
            var i = 0;
            var in_stock = []; var items = [];
            var _token = $("input[name='_token']").val();
            getItems()



            $(':submit').click(function (e) {
                if( i < 1 ){
                    e.preventDefault()
                    alert('Please add at least one item')
                }
            })

            $('#category').on('change', function () {
                getItems()

            })





            function getItems() {

                $('#item').val(0); $('#stock').val(0); $('#quantity').val(0);
                var stock_head_id = $('#category').val()
                in_stock = []

                $.ajax({
                    type:'POST',
                    url: '{{ route("purchase.item") }}',
                    data: { _token: _token, stock_head_id: stock_head_id },
                    success:function (data) {
                        // console.log(data)
                        var item = $('#item'); var stock = $('#stock');
                        item.empty(); stock.empty();

                        items = data['item']
                        $.each(data['item'], function (key, val) {
                            // console.log(data['stock'][key])
                            in_stock[key] = val['stock']
                            item.append('<option value="'+key+'">'+val['name']+'</option>')
                        })

                        getUnit()
                    }
                })

            }



            function getUnit() {
                var id = $('#item').val()
                $('#quantity').val(0)
                $('#stock').val(items[id]['stock'])
                $('.unit').text('('+items[id]['unit']+')')
            }




            $('#item').on('change', function () {
                getUnit()
            })




            $('#quantity').on('change keyup', function () {
                var x = parseFloat(in_stock[$('#item').val()]).toFixed(3)
                var y = parseFloat($(this).val()).toFixed(3)
                var z = parseFloat((x-y)).toFixed(3)
                $('#stock').val(z)
                $('#quantity').attr('max', z)
            })


            // console.log(in_stock)



            $('#add-button').click(function () {
                var item_id = parseInt($('#item').val())
                // alert(item_id)
                var quantity = parseFloat( $('#quantity').val() )

                var msg1 = 'Please Select an Item';
                var msg2 = 'Please Enter Some Quantity to Deliver'

                !item_id ? alert(msg1) : ( !quantity ? alert(msg2) : '')

                if( item_id && quantity )
                 {
                    i++
                    $('#list-item').append(
                        '<tr id="row'+i+'">' +
                        '<td>'+i+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][stock_id]" value="'+item_id+'">'+$('#item :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][quantity]" value="'+quantity+'">'+quantity +' '+ items[item_id]['unit'] +'</td>' +
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
