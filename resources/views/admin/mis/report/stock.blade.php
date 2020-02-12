@extends('admin.master')


@section('content')
    <div class="col-md-9">
        <samp>
            <div class="card">
                <div class="card-header">
                    {{ csrf_field() }}
                    <div class="row">
                        <input type="date" class="form-control col-md-2 date" id="from" style="margin-right: 1%; margin-left: 16%;">
                        <input type="date" class="form-control col-md-2 date" id="to" style="margin-right: 1%;">
                        <select class="form-control col-md-3" id="kate_id" style="margin-right: 1%;">
                            <option value="all">All</option>
                            @foreach( $mis_head->child as $kate )
                                <option value="{{ $kate->id }}">{{ $kate->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-i btn-sm" style="width: 6%; height: 4%; margin-top: 3px;">Show</button>
                    </div>
                </div>

                <div class="card-header">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="col-md-2">Name</th>
                            <th class="col-md-1">Category</th>
                            <th>Opening</th>
                            <th>Purchase</th>
                            <th>Delivery</th>
                            <th>Closing</th>
                            <th>Total cost</th>
                        </tr>
                        </thead>
                        <tbody id="content">
                        @foreach( $data['stock'] as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['category'] }}</td>
                                <td>{{ $item['op_bl'].' '.$item['unit'] }}</td>
                                <td>{{ $item['purchase'].' '.$item['unit'] }}</td>
                                <td>{{ $item['delivery'].' '.$item['unit'] }}</td>
                                <td>{{ $item['cl_bl'].' '.$item['unit'] }}</td>
                                <td>{{ $item['cost'].' tk.' }}</td>
                            </tr>
                        @endforeach

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
                var kate_id = $('#kate_id').val()
                var mis_head_id = @json( $mis_head->id);
                var check = 0

                check = !Date.parse(from) || !Date.parse(to) ? alert(msg1) : ( Date.parse(from) > Date.parse(to) ? alert( msg2) : 1)
                if ( check == 1 )
                    check = !kate_id ? alert(msg3) : 2
                // console.log(from, to, kate_id)

                if ( check == 2){

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('report.show.stock') }}",
                        data: {_token: _token, from: from, to: to, kate_id: kate_id, mis_head_id: mis_head_id},
                        success: function (data) {
                            // console.log( data)
                            var content = $('#content'); content.empty();
                            var table = $('.table').DataTable();
                            table.clear().draw(); table.destroy();

                            if( data == 220)
                                $('#content').append('No Results Found')
                            else {
                                var i = 1;
                                $.each(data['stock'], function (key, val) {
                                    i++
                                    // console.log(val)
                                    content.append(
                                        '<tr>'+
                                        '<td>'+i+'</td>'+
                                        '<td>'+val['name']+'</td>'+
                                        '<td>'+val['category']+'</td>'+
                                        '<td>'+val['op_bl']+' '+val['unit']+'</td>'+
                                        '<td>'+val['purchase']+' '+val['unit']+'</td>'+
                                        '<td>'+val['delivery']+' '+val['unit']+'</td>'+
                                        '<td>'+val['cl_bl']+' '+val['unit']+'</td>'+
                                        '<td>'+val['cost']+' tk.'+'</td>'+
                                        '</tr>'
                                    )

                                } )
                            }
                        }
                    })
                }

            })

        })
    </script>
@endsection






@section('datatable')

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "paging": true,
                "ordering":  true,
            });
        } );
    </script>

@endsection

