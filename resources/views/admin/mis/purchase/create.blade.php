@extends('admin.master')


@section('content')
<style>
        .required{
            color: #ff0000;
        }
    </style>
    <div class="col-md-5">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    Purchase {{ $type_id != 3 ? 'Inventory' : 'Grocery' }} Item
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Item</label>
                                <select class="form-control" id="item" >
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Supplier<span class="required">*</span></label>
                                <select class="form-control" id="supplier">
                                    <option></option>
                                    @foreach( $data['supplier'] as $item )
                                        <option value="{{ $item->id }}">{{ $item->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Quantity <span class="required">*</span></label>
                                <input type="number" class="form-control" id="quantity" min="1" value="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Total Cost <small>(tk)</small><span class="required">*</span></label>
                                <input type="number" class="form-control" id="amount" value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Receiver <span class="required">*</span></label>
                                <select class="form-control" id="receiver">
                                    <option></option>
                                    @foreach( $data['receiver'] as $item )
                                        <option value="{{ $item->id }}">{{ $item->name }} </option>
                                    @endforeach
                                </select>
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

    <div class="col-md-6">
        <samp>
            <div class="card text-left">
                <div class="card-header">Purchased List</div>
                <div class="card-body purchase-list">
                    <form method="POST" action="{{ route('purchase.store') }}" >
                        {{ csrf_field() }}
                        <input type="hidden" name="mis_ac_head_id" value="{{ $stock_head->first()->type->id }}">

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

                if( !item || !quantity || !amount || !supplier || !receiver)
                    alert('Please Enter all fields')
                else {
                    i++
                    $('#list-item').append(
                        '<tr id="row'+i+'">' +
                        '<td>'+i+'</td>' +
                        // '<td>'+$('#category :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][stock_id]" value="'+item+'">'+$('#item :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][quantity]" value="'+quantity+'">'+quantity+'</td>' +
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
