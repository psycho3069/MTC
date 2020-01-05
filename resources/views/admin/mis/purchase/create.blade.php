@extends('admin.master')


@section('content')
<style>
        .required{
            color: #ff0000;
        }
    </style>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Purchase {{ $type_id != 3 ? 'Inventory' : 'Grocery' }} Item
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mis Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ $conf }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stock_head_id">Select a category</label>
                            <select class="form-control" id="category" required>
                                <option value="" >Choose One</option>
                                @foreach( $stock_head as $item )
                                    <option value="{{ $item->id }}">{{ $item->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Item</label>
                            <select class="form-control" id="item">
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select a supplier</label>
                            <select class="form-control" id="supplier">
                                <option></option>
                                @foreach( $data['supplier'] as $item )
                                    <option value="{{ $item->id }}">{{ $item->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select a receiver</label>
                            <select class="form-control" id="receiver">
                                <option></option>
                                @foreach( $data['receiver'] as $item )
                                    <option value="{{ $item->id }}">{{ $item->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Quantity <span class="required">*</span></label>
                            <input type="number" class="form-control" id="quantity" min="1" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total Cost</label>
                            <input type="number" class="form-control" id="amount" min="1">
                        </div>
                    </div>
                </div>

                <button type="button" id="add-button" class="btn btn-primary float-right">Add</button>
            </div>
        </div>
        <br><br>

        <div class="card">
            <div class="card-header">Purchased List</div>
            <div class="card-body purchase-list">
                <form method="POST" action="{{ route('purchase.store') }}" >
                    {{ csrf_field() }}
                    <input type="hidden" name="type_id" value="{{ $stock_head->first()->type->id }}">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Category</th>
                            <th scope="col">Item</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Receiver</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody id="vouchers">

                        </tbody>
                    </table>
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
                    alert('Please add at least one item')
                }
            })

            $('#category').on('change', function () {
                // alert($(this).val())
                var stock_head_id = $(this).val()
                var _token = $("input[name='_token']").val();


                $.ajax({
                    type:'POST',
                    url: '{{ route("purchase.item") }}',
                    data: {_token:_token, stock_head_id:stock_head_id },
                    success:function (data) {
                        // console.log(data)
                        var item = $('#item')
                        item.empty()
                        item.append('<option value="">Choose an Item</option>')
                        $.each(data, function (key, val) {
                            item.append('<option value="'+key+'">'+val+'</option>')
                        })
                    }
                })
            })



            $('#add-button').click(function () {
                var category = $('#category').val()
                var item = $('#item').val()
                var quantity = $('#quantity').val()
                var supplier = $('#supplier').val()
                var receiver = $('#receiver').val()
                var amount = $('#amount').val()
                var date = $('#date').val()

                if( !item || !quantity || !amount || !supplier || !receiver)
                    alert('Please Enter all fields')
                else {
                    i++
                    $('#vouchers').append(
                        '<tr id="row'+i+'">' +
                        '<td>'+$('#category :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][stock_id]" value="'+item+'">'+$('#item :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][quantity]" value="'+quantity+'"><input type="hidden" name="date" value="'+date+'">'+quantity+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][amount]" value="'+amount+'">'+amount+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][supplier_id]" value="'+supplier+'">'+$('#supplier :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][receiver_id]" value="'+receiver+'">'+$('#receiver :selected').text()+'</td>' +
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
