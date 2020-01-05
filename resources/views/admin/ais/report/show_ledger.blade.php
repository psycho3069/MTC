

@extends('admin.master')


@section('content')
    <div class="col-md-7">
        <form action="{{ route('report.show.ledger') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-4">
                    <label>Select a account</label>
                    <select name="thead_id" class="form-control">
                        @foreach( $data['theads'] as $thead )
                            <option value="{{ $thead->id }}" {!! $input['thead_id'] == $thead->id ? 'selected="selected"' : '' !!}>{{ str_limit( $thead->name, 8) }} [{{ $thead->code }}]</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Type</label>
                    <select name="category" class="form-control" id="category">
                        <option value="0" {!! $input['category'] == 0 ? 'selected="selected"' : '' !!}>All</option>
                        <option value="1" {!! $input['category'] == 1 ? 'selected="selected"' : '' !!}>Auto</option>
                        <option value="2" {!! $input['category'] == 2 ? 'selected="selected"' : '' !!}>Manual</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Category</label>
                    <select name="type_id" class="form-control" id="type">
                        <option value="0">All</option>
                        @foreach( $data['types'] as $item )
                            <option value="{{ $item->id }}" class={!! $item->id >4 ? 'auto' : 'manual' !!} {!! $input['type_id'] == $item->id ? 'selected="selected"' : '' !!}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Start Date</label>
                    <div>
                        <input type="date" name="start_date" class="form-control" value="{{ $input['start_date'] }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <label>End Date</label>
                    <div>
                        <input type="date" name="end_date" value="{{ $input['end_date'] }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-dark btn-sm show-button">Show</button>

                </div>

            </div>

            <br>
        </form>
        <br><br><br>
        <table class="table table-bordered table-hover table-primary">
            <thead>
            <tr>
                <th class="">Date</th>
                <th class="">Voucher Code</th>
                <th class="">Account head</th>
                <th class="">Narration/Cheque Details</th>
                <th class="">Credit Amount</th>
                <th class="">Debit Amount</th>
                <th class="">Balance</th>
{{--                <th class="">Dr/Cr</th>--}}
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td><td></td>
                    <td>Opening balance</td>
                    <td></td><td></td><td></td>
                    <td>{{ $data['opening_bl'] }}</td>
                </tr>
                <tr>
                    <td></td><td></td>
                    <td>Previous balance</td>
                    <td></td><td></td><td></td>
                    <td >{{ $data['prev_bl'] }}</td>

                </tr>
                @foreach( $data['vouchers'] as $voucher )
                    <tr>
                        <td>{{ $voucher->date->date }}</td>
                        <td>{{ $voucher->code }}</td>
                        <td>{{ $voucher->credit_head_id == $input['thead_id'] ? $voucher->debitAccount->name : $voucher->creditAccount->name }}</td>
                        <td> {{ $voucher->note }}</td>
                        <td>{{ $voucher->credit_head_id == $input['thead_id'] ? $voucher->amount : '-' }}</td>
                        <td>{{ $voucher->debit_head_id == $input['thead_id'] ? $voucher->amount : '-' }}</td>
                        <td>
{{--                            <small>Prev. bl</small>--}}
{{--                            <p>{{ isset($data['prev_bl'][$voucher->id]) ? $data['prev_bl'][$voucher->id] : '' }}</p>--}}
                            {{ $amount[$voucher->id] }}
{{--                            {{ $current_bl->where('thead_id', $data['thead_id'])->where('date_id', $voucher->date_id)->sum('credit') - $current_bl->where('thead_id', $data['thead_id'])->sum('debit')}}--}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var y = $('#category').val()
            y == 1 ? $('.auto').show() : $('.manual').show()

            $('#category').on('change',function () {
                var x = $(this).val()
                if (x == 1) {
                    $('.auto').show()
                    $('#type').val(0)
                    $('.manual').hide()
                } else if ( x == 2){
                    $('.manual').show()
                    $('#type').val(0)
                    $('.auto').hide()
                } else {
                    $('#type').val(0)
                    $('.auto').hide()
                    $('.manual').hide()
                }

            })
            $('.show-button').click(function (e) {
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
