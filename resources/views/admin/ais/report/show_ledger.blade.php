

@extends('admin.master')

<style>
    .select2-selection__rendered {
        line-height: 36px !important;
    }
    .select2-container .select2-selection--single {
        height: 38px !important;
    }
    .select2-selection__arrow {
        height: 34px !important;
    }
</style>

@section('content')
    <div class="col-md-12">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <form action="{{ route('report.show.ledger') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-2">
                                <label>Select a account</label>
                                <select name="thead_id" class="form-control thead_id">
                                    @foreach( $data['theads'] as $thead )
                                        <option value="{{ $thead->id }}" {!! $input['thead_id'] == $thead->id ? 'selected="selected"' : '' !!}>{{ str_limit( $thead->name, 20) }} [{{ $thead->code }}]</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Type</label>
                                <select name="category" class="form-control" id="category">
                                    <option value="0" {!! $input['category'] == 0 ? 'selected' : '' !!}>All</option>
                                    <option value="1" {!! $input['category'] == 1 ? 'selected' : '' !!}>Auto</option>
                                    <option value="2" {!! $input['category'] == 2 ? 'selected' : '' !!}>Manual</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Category</label>
                                <select name="type_id" class="form-control" id="type">
                                    <option value="0">All</option>
                                    @foreach( $data['types'] as $item )
                                        <option value="{{ $item->id }}" class={!! $item->id >4 ? 'auto' : 'manual' !!} {!! $input['type_id'] == $item->id ? 'selected' : '' !!}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Start Date</label>
                                <div>
                                    <input type="date" class="form-control date" name="start_date" value="{{ $input['start_date'] }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label>End Date</label>
                                <div>
                                    <input type="date" class="form-control date" name="end_date" value="{{ $input['end_date'] }}">
                                </div>
                            </div>

                            <div class="col-md-1">
                                <button class="btn btn-dark btn-sm show-button" style="margin-top: 47%;">Show</button>
                            </div>

                        </div>

                        <br>
                    </form>
                </div>
                <div class="card-footer">
                    <table class="table table-bordered">
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
                                <td>{{ date('d-m-Y', strtotime( $voucher->date->date)) }}</td>
                                <td>{{ $voucher->voucherGroup->code }}</td>
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
            </div>
        </samp>

    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.thead_id').select2({
                placeholder: 'Select an account'
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            var y = $('#category').val()
            // y == 1 ? $('.auto').show() : $('.manual').show()
            y == 1 ? $('.manual').hide() : ( y == 2 ? $('.auto').hide() : '')

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
                    $('.auto').show()
                    $('.manual').show()
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
