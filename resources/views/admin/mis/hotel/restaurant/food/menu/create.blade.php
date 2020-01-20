@extends('admin.master')


@section('content')
    <div class="col-md-9">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <b><code>Add New Menu</code></b>
                    <b class="pull-right total">Total: <span id="total"></span></b>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Menu Type</label>
                                <select class="form-control" id="menu_type">
                                    @foreach( $data['menu_types'] as $item )
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Item</label>
                                <select class="form-control" id="item">
                                    @foreach( $data['menu_items'] as $item )
                                        <option value="{{ $item->id }}">{{ $item->name.'- '.$item->price.'tk.' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" class="form-control" id="quantity" min="1" value="1">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label>Price</label>
                            <b class="no-wrap" id="sub_total" ></b>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" id="add-button" class="btn btn-i btn-block">Add</button>
                </div>
            </div>
        </samp>
        <br><br>



        <samp>
            <div class="card text-left">
                <div class="card-body">
                    <form method="POST" action="{{ route('menu.store') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="name" >
                        <input type="hidden" name="menu_type_id">

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Item</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="list">

                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" class="form-control" name="price" value="0" min="0">
                                </div>
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
            getPrice()

            var i = 0; var total = 0;

            $(':submit').click(function (e) {
                var name = $('#name').val(); var type= $('#menu_type').val();

                $('input[name="name"]').val(name)
                $('input[name="menu_type_id"]').val(type)


                if( i < 1 ){
                    e.preventDefault()
                    alert('Please add at least one item')
                }else if ( !name){
                    e.preventDefault()
                    alert('Please Enter Menu Name')
                }

            })


            $('#item').on('change', function () {
                getPrice()
            })


            $('#quantity').on('change keyup', function () {
                getPrice()
            })


            function getPrice() {
                var unit_price = itemPrice();
                var quantity = $('#quantity').val();
                var sub_total = unit_price * quantity
                $('#sub_total').text( sub_total+' tk.')
                return sub_total;
            }

            function itemPrice(){
                var price = $('#item :selected').text()
                price = parseFloat(price.split('-')[1].split('tk.')[0]).toFixed(2)
                return price;
            }

            $('#add-button').click(function () {
                var item = $('#item').val()
                var quantity = $('#quantity').val()
                var price = getPrice()
                total += price
                $('#total').text(total+' tk.')
                $('input[name="price"]').val(total)

                if( !item || !quantity )
                    alert('Please Enter all fields')
                else {
                    i++
                    $('#list').append(
                        '<tr id="row'+i+'">' +
                        '<td>'+i+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][meal_item_id]" value="'+item+'">'+$('#item :selected').text().split('-')[0]+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][quantity]" value="'+quantity+'">'+quantity+'</td>' +
                        '<td id="price'+i+'">'+price+' tk.'+'</td>' +
                        '<td><a class="btn btn-danger btn-sm remove" id="'+i+'">Remove</a></td>' +
                        '</tr>'
                    )
                }
            })



            $(document).on('click', '.remove', function(){
                var button_id = $(this).attr('id')
                var price = $('#price'+i).text().split('tk.')[0]
                price = parseFloat(price).toFixed(2)
                total -=price
                $('#total').text(total+' tk.')
                $('input[name="price"]').val(total)
                $('#row'+button_id).remove()
                i--
            })

        })
    </script>
@endsection
