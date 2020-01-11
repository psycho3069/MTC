@extends('admin.master')


@section('content')

    <style >
        a.dropdown-item {
            color: #fff;
        }
    </style>
    <div class="col-md-8">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <b>Day End Process</b>
                    <form action="{{ route('process.show.list') }}" method="POST" class="pull-right">
                        {{ csrf_field() }}

                        <select id="year" class="form-horizontal">
                            @foreach( $years as $y_key => $year )
                                <option value="{{ $y_key }}">{{ $y_key }}</option>
                            @endforeach
                        </select>

                        <select id="month"></select>
                        <select id="day" name="date_id"></select>
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

                        $.ajax({
                            type:'POST',
                            url: '{{ route("process.year") }}',
                            data: {_token: _token, month: month, year: year},
                            success:function (data) {
                                // console.log(data['day'])
                                var day = $('#day')
                                day.empty()
                                $.each(data['day'], function (key, val) {
                                    day.append('<option value="'+key+'">'+val+'</option>')
                                })
                            }
                        })
                    }
                })

            })


            $('#month').on('change mouserover', function () {
                var year = $('#year').val()
                var month = $('#month').val()

                $.ajax({
                    type:'POST',
                    url: '{{ route("process.year") }}',
                    data: {_token: _token, month: month, year: year},
                    success:function (data) {
                        // console.log(data['day'])
                        var day = $('#day')
                        day.empty()
                        $.each(data['day'], function (key, val) {
                            day.append('<option value="'+key+'">'+val+'</option>')
                        })
                    }
                })

            })

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

