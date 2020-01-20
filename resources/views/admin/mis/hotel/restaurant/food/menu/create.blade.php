@extends('admin.master')


@section('content')
    <div class="col-md-8">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" class="form-control" id="quantity" min="1" value="1">
                            </div>
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
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="list">

                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" class="form-control" name="price" value="0" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Total Cost</label>
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

            var i = 0;

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

            $('#add-button').click(function () {
                var item = $('#item').val()
                var quantity = $('#quantity').val()

                if( !item || !quantity )
                    alert('Please Enter all fields')
                else {
                    i++
                    $('#list').append(
                        '<tr id="row'+i+'">' +
                        '<td>'+i+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][meal_item_id]" value="'+item+'">'+$('#item :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][quantity]" value="'+quantity+'">'+quantity+'</td>' +
                        // '<td><input type="hidden" name="input['+i+'][amount]" value="'+amount+'">'+amount+'</td>' +
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
