@extends('admin.master')


@section('content')

    <style >
        a.dropdown-item {
            color: #fff;
        }
    </style>
    <div class="col-md-12">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <b>Day End Process</b>
                    <form action="{{ route('process.show.list') }}" method="POST">
                        {{ csrf_field() }}

                        <select id="year" class="form-horizontal">
                            @foreach( $data['years'] as $y_key => $year )
                                <option {{ $format['year'] == $y_key ? 'selected' : '' }}>{{ $y_key }}</option>
                            @endforeach
                        </select>

                        <select id="month">
                            @foreach( $data['months'] as $key => $item )
                                <option value="{{ $key }}" {{ $format['month'] == $item ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                        <select id="day" name="date_id">
                            @foreach( $data['days'] as $key => $item)
                                <option value="{{ $key }}" {{ $format['day'] == $item ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-dark btn-sm">Show</button>
                    </form>


                    <form method="POST" action="{{ route('process.store') }}">
                        {{ csrf_field() }}
                        @if( $date->status != 1 )
                            <input type="hidden" name="date_id" value="{{ $date->id }}">
                            <button type="submit" class="btn btn-light">Execute day end</button>
                        @endif
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Type</th>
                            <th scope="col">Code</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Note</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $date->vGroup as $voucherGroup )
                            <tr>
                                <td width="50">{{ $voucherGroup->type->name }}</td>
                                <td width="100">{{ $voucherGroup->code }}</td>
                                <td width="100">{{ $voucherGroup->vouchers->sum('amount') }}</td>
                                <td width="100">{{ str_limit( $voucherGroup->note, 40)  }}</td>
                                <td width="100">{{ date('d-m-Y', strtotime($voucherGroup->date->date)) }}</td>
                                <td width="100">
                                    {!! $voucherGroup->date->status ? '<span class="badge badge-success">Success</span>' : '<span class="badge badge-warning">Pending</span>' !!}
                                </td>
                                <td width="50">
                                    <a href="{{ route('vouchers.show', $voucherGroup->id) }}" class="btn btn-sm btn-i" title="View">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('vouchers.edit', $voucherGroup->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    @if( $voucherGroup->type_id != 10 && $voucherGroup->type_id != 11)
                                        <a href="" class="btn btn-sm btn-danger" data_id="{{ $voucherGroup->id }}" title="Delete" onclick="destroy( $(this).attr('data_id')); return false;">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </samp>
    </div>

@endsection




@section('script')
    <script>
        $(document).ready(function () {

            var _token = $("input[name='_token']").val()
            $('#year').on('change', function () {
                var year = $(this).val()
                $.ajax({
                    type:'POST',
                    url: '{{ route("process.year") }}',
                    data: {_token: _token, year: year},
                    success:function (data) {
                        console.log(data)
                        // console.log(data['month'])
                        var month = $('#month')
                        month.empty()
                        $.each(data['month'], function (key, val) {
                            month.append('<option value="'+key+'">'+val+'</option>')
                        })


                        var month = $('#month').val()

                        getDay(month, year)

                    }
                })

            })


            $('#month').on('change mouserover', function () {
                var year = $('#year').val()
                var month = $('#month').val()
                // alert(month)
                getDay(month, year)

            })



            function getDay(month, year) {

                $.ajax({
                    type:'POST',
                    url: '{{ route("process.year") }}',
                    data: {_token: _token, month: month, year: year},
                    success:function (data) {
                        console.log(data)
                        var day = $('#day')
                        day.empty()
                        $.each(data['day'], function (key, val) {
                            day.append('<option value="'+key+'">'+val+'</option>')
                        })
                    }
                })

            }


        })
    </script>
@endsection





@section('datatable')

    <!-- datatable -->
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
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

