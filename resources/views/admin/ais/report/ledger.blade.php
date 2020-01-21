

@extends('admin.master')


@section('content')
    <div class="col-md-9">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <small>
                        <form class="" action="{{ route('report.show.ledger') }}" method="POST" >
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-2" >
                                    <label>Select a account</label>
                                    <select name="thead_id" class="form-control">
                                        @if( isset($thead))
                                            <option value="{{ $thead->id }}" >{{ str_limit( $thead->name, 15) }} [{{ $thead->code }}]</option>
                                        @else
                                            @foreach( $data['theads'] as $item )
                                                <option value="{{ $item->id }}" >{{ str_limit( $item->name, 15) }} [{{ $item->code }}]</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Type</label>
                                    <select name="category" class="form-control" id="category">
                                        <option value="0">All</option>
                                        <option value="1">Auto</option>
                                        <option value="2">Manual</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Category</label>
                                    <select name="type_id" class="form-control" id="type">
                                        <option value="0">All</option>
                                        @foreach( $data['types'] as $item )
                                            <option value="{{ $item->id }}" class={!! $item->id >4 ? 'auto' : 'manual' !!} >{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Start Date</label>
                                    <div>
                                        <input type="date" name="start_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>End Date</label>
                                    <div>
                                        <input type="date" name="end_date" value="{{ date('Y-m-d') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-dark btn-sm show-button pull-right">Show</button>
                                </div>

                            </div>
                        </form>
                    </small>
                </div>
                <div class="card-footer">
                    <table class="table table-bordered table-hover table-primary table-fixed">
                        <thead>
                        <tr>
                            <th class="">Date</th>
                            <th class="">Voucher Code</th>
                            <th class="">Account head</th>
                            <th class="">Narration/Cheque Details</th>
                            <th class="">Credit Amount</th>
                            <th class="">Debit Amount</th>
                            <th class="">Balance</th>
                            {{--                    <th class="">Dr/Cr</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @if( isset($thead))
                            <tr>
                                <td></td><td></td>
                                <td>Opening balance</td>
                                <td></td><td></td><td></td>
                                <td>{{ $data['opening_bl'] }}</td>
                            </tr>
                            @foreach( $data['vouchers'] as $voucher )
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime( $voucher->date->date)) }}</td>
                                    <td>{{ $voucher->voucherGroup->code }}</td>
                                    <td>{{ $voucher->credit_head_id == $thead->id ? $voucher->debitAccount->name : $voucher->creditAccount->name }}</td>
                                    <td> {{ $voucher->note }}</td>
                                    <td class="float-right">{{ $voucher->credit_head_id == $thead->id ? $voucher->amount : '' }}</td>
                                    <td class="float-right">{{ $voucher->debit_head_id == $thead->id ? $voucher->amount : '' }}</td>
                                    <td>{{ $amount[$voucher->id] }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </samp>



    </div>

@endsection

@section('script')
    <script>
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
