@extends('admin.master')


@section('content')
    <div class="col-md-8">
        <samp>
            <div class="card">
                <div class="card-header">
                    {{ csrf_field() }}
                    <div class="row">
                        <input type="date" class="form-control col-md-2 date" id="from" style="margin-right: 1%; margin-left: 16%;">
                        <input type="date" class="form-control col-md-2 date" id="to" style="margin-right: 1%;">
                        <select class="form-control col-md-3" id="kate_id" style="margin-right: 1%;">
                            @foreach( $mis_head->child as $kate )
                                <option value="{{ $kate->id }}">{{ $kate->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-i btn-sm" style="width: 6%; height: 4%; margin-top: 3px;">Show</button>
                    </div>
                </div>

                <div class="card-header">
                    <table class="table table-bordered table-hover table-info">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Opening</th>
                            <th>Purchase</th>
                            <th>Delivery</th>
                            <th>Closing</th>
                        </tr>
                        </thead>
                        <tbody id="content">

                        </tbody>
                    </table>

                </div>

                <div class="card-footer">

                </div>
            </div>
        </samp>
    </div>
@endsection




@section('script')
    <script>
        $(document).ready( function () {

            var msg1 = 'Please Enter Date'
            var msg2 = 'Please Enter a Valid Date'
            var msg3 = 'Please Select A Category'


            $('button').click(function () {
                var _token = $('input[name="_token"]').val()
                var from =  $('#from').val()
                var to =  $('#to').val()
                var kate_id = parseInt($('#kate_id').val())
                var check = 0

                check = !Date.parse(from) || !Date.parse(to) ? alert(msg1) : ( Date.parse(from) > Date.parse(to) ? alert( msg2) : 1)
                if ( check == 1 )
                    check = !kate_id ? alert(msg3) : 2
                // console.log(from, to, kate_id)

                if ( check == 2){

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('report.show.stock') }}",
                        data: {_token: _token, from: from, to: to, kate_id: kate_id},
                        success: function (data) {
                            console.log( data)
                        }
                    })
                }

            })





        })
    </script>
@endsection
