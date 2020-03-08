

@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <form action="{{ route('report.show.daily') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-horizontal">
                <div class="col-md-2">
                    <label>Start Date</label>
                    <div>
                        <input type="date" name="start_date" value="{{ $input['start_date'] }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <label>End Date</label>
                    <div>
                        <input type="date" name="end_date" value="{{ $input['end_date'] }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label>Voucher Type</label>
                    <select name="type_id" class="form-horizontal">
                        <option value="0">All</option>
                        @foreach( $data['types'] as $type )
                            <option value="{{ $type->id }}" {!! $input['type_id'] == $type->id ? 'selected="selected"' : '' !!} >{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <button class="btn btn-dark btn-sm show">Show</button>
            </div>
        </form>

        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th class="">#</th>
                <th class="">Date</th>
                <th class="">Voucher Code</th>
                <th class="">Credit Account</th>
                <th class="">Debit Account</th>
                <th class="">Narration/Cheque Details</th>
                <th class="">Amount</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($data['vouchers']))
                @foreach( $data['vouchers'] as $voucher )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $voucher->date->date }}</td>
                        <td>{{ $voucher->code }}</td>
                        <td >{{ str_limit($voucher->creditAccount->name,5) }}  [<b>{{ $voucher->creditAccount->code }}</b>]</td>
                        <td>{{ str_limit($voucher->debitAccount->name,5) }}  [<b>{{ $voucher->debitAccount->code }}</b>]</td>

                        <td> {{ $voucher->note }}</td>
                        <td> {{ $voucher->amount }}</td>

                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>

    </div>

@endsection

@section('script')
    <script>
        $('.show').click(function (e) {
            var end_date = $('input[name="end_date"]').val()
            var start_date = $('input[name="start_date"]').val()
            // alert(start_date)
            if (  !Date.parse(start_date)){
                e.preventDefault()
                alert('Please select a date')
            }
            if ( Date.parse(start_date) > Date.parse(end_date)){
                e.preventDefault()
                alert('Please select a valid date range')
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
