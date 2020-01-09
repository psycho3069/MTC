@extends('admin.master')


@section('content')
    <style>
        .required{
            color: #ff0000;
        }
    </style>
    <div class="col-md-6">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    Deliver Item
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="stock_head_id">Category</label>
                                <select class="form-control" id="category" required>
                                    <option value="" >Choose One</option>
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
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" class="form-control" id="stock" value="0" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" class="form-control" id="quantity" value="0" min="0">
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

    <div class="col-md-6">
        <samp>
            <div class="card text-left">
                <div class="card-header">Delivery List</div>
                <div class="card-body purchase-list">
                    <form method="POST" action="{{ route('deliver.store') }}" >
                        {{ csrf_field() }}

                        <table class="table table-info">
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
            var in_stock = []

            $(':submit').click(function (e) {
                if( i < 1 ){
                    e.preventDefault()
                    alert('Please add at least one item')
                }
            })

            $('#category').on('change', function () {
                // alert($(this).val())
                $('#item').val(0); $('#stock').val(0); $('#quantity').val(0);

                in_stock = []
                var stock_head_id = $(this).val()
                var _token = $("input[name='_token']").val();


                $.ajax({
                    type:'POST',
                    url: '{{ route("purchase.item") }}',
                    data: {_token:_token, stock_head_id:stock_head_id },
                    success:function (data) {
                        // console.log(data)
                        var item = $('#item'); var stock = $('#stock');
                        item.empty(); stock.empty();

                        item.append('<option value="">Choose an Item</option>')
                        $.each(data['item'], function (key, val) {
                            // console.log(data['stock'][key])
                            in_stock[key] = data['stock'][key]
                            item.append('<option value="'+key+'">'+val+'</option>')
                        })
                    }
                })
            })




            $('#item').on('change', function () {
                $('#quantity').val(0);

                var x = in_stock[$(this).val()]
                $('#stock').val(x)
                $('#quantity').val(0)
            })




            $('#quantity').on('change', function () {
                var x = parseFloat(in_stock[$('#item').val()])
                var y = parseFloat($(this).val())
                $('#quantity').attr('max', x)
                $('#stock').val(x-y)
            })


            // console.log(in_stock)



            $('#add-button').click(function () {
                var item = $('#item').val()
                var quantity = $('#quantity').val()

                // console.log(note)

                if( !item || !quantity )
                    alert('Please Enter all fields')
                else {
                    i++
                    $('#list-item').append(
                        '<tr id="row'+i+'">' +
                        '<td>'+i+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][stock_id]" value="'+item+'">'+$('#item :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][quantity]" value="'+quantity+'">'+quantity+'</td>' +
                        '<td><a class="btn btn-danger btn-sm remove" id="'+i+'">Remove</a></td>' +
                        '</tr>'
                    )

                    $('#quantity').val('')
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
