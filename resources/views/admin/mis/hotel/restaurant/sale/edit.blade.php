@extends('admin.master')


@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="{{ route('sales.update', $bill->id) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PATCH">

            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header"><samp>{{ $bill->guest->name }}'s Food Bill</samp></div>
                        <div class="card-body">
                            <samp>
                                @foreach( $bill->restaurant as $food )
                                    {{ $loop->iteration }}.
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Food Item</label>
                                                <input type="text" class="form-control" value="{{ $food->menu->name }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Price</label>
                                                <input type="number" class="form-control" value="{{ $food->menu->price }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Quantity</label>
                                                <input type="number" class="form-control" name="food[{{$food->id }}][quantity]" value="{{ $food->quantity }}" min="0">
                                            </div>
                                        </div>
                                        {{--                                <div class="col-md-3">--}}
                                        {{--                                    <div class="form-group">--}}
                                        {{--                                        <label>Total</label>--}}
                                        {{--                                        <input type="number" class="form-control" value="{{ $food->bill }}" disabled>--}}
                                        {{--                                    </div>--}}
                                        {{--                                </div>--}}
                                    </div>
                                @endforeach

                                <hr>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th scope="col">Item</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="add-list">

                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-dark">Update</button>
                            </samp>
                        </div>
                    </div>
                </div>


                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header"><samp>Add Sale</samp></div>
                        <div class="card-body">
                            <samp>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Menu Type</label>
                                            <select class="form-control" id="menu_type">
                                                {{--                                <option></option>--}}
                                                @foreach( $menu_type as $item )
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Menu</label>
                                            <select class="form-control" id="menu">
                                                {{--                                <option></option>--}}
                                                @foreach( $menu_type as $type )
                                                    @foreach( $type->menu as $item )
                                                        <option value="{{ $item->id }}">{{ $item->name }} </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control" id="quantity" min="1" max="100" value="1">
                                        </div>
                                    </div>
                                </div>
                            </samp>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-block btn-default pull-right" id="add-button">Add</button>
                        </div>
                    </div>
                </div>


            </div>

        </form>
    </div>
@endsection



@section('script')
    <script>
        $(document).ready(function () {
            var i = 0;
            var count = {!! json_encode(count($bill->restaurant)) !!}

            $('#add-button').click(function () {
                // alert(22)

                var menu_id = $('#menu').val()
                var quantity = $('#quantity').val()


                if( !menu_id || !quantity )
                    alert('Please Enter All Required Fields')
                else {
                    count++; i++;

                    $('#add-list').append(
                        '<tr id="row'+i+'">' +
                        '<td>'+count+'.</td>' +
                        '<td><input type="hidden" name="new_food['+i+'][menu_id]" value="'+menu_id+'">'+$('#menu :selected').text()+'</td>' +
                        '<td><input type="hidden" name="new_food['+i+'][quantity]" value="'+quantity+'">'+quantity+'</td>' +
                        '<td><a class="btn btn-danger btn-sm remove" id="'+i+'">Remove</a></td>' +
                        '</tr>'
                    )

                }

            })


            $(document).on('click', '.remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
                i--; count--;
            });

        })
    </script>
@endsection
