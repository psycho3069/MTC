

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
                    <small>
                        <form action="{{ route('report.cash-book') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-2" >
                                </div>
                                <div class="col-md-2">
                                    <label>Type</label>
                                    <select name="category" class="form-control" id="category">
                                        <option value="0" @if(0 == $data['category']) {{ 'Selected' }}  @endif>All</option>
                                        <option value="1" @if(1 == $data['category']) {{ 'Selected' }}  @endif>Auto</option>
                                        <option value="2" @if(2 == $data['category']) {{ 'Selected' }}  @endif>Manual</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Category</label>
                                    <select name="type_id" class="form-control" id="type">
                                        <option value="0">All</option>
                                        @foreach( $data['types'] as $item )
                                            <option value="{{ $item->id }}" class={!! $item->id >4 ? 'auto' : 'manual' !!} @if($item->id == $data['type']) {{ 'Selected' }}  @endif >{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Start Date</label>
                                    <div>
                                        <input type="date" class="form-control date" name="start_date" value="{{ $data['start_date'] }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>End Date</label>
                                    <div>
                                        <input type="date" class="form-control date" name="end_date" value="{{ $data['end_date'] }}">
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
                    <table class="table table-bordered table-hover table-primary table-chart table-responsive">
                        <thead>
                        <tr>
                            <th class="" style='width: 5%;'>Date</th>
                            <th class="" style='width: 5%;'>Voucher Code</th>
                            <th class="" style='width: 25%;'>Account head</th>
                            <th class="" style='width: 20%;'>Narration/Cheque Details</th>
                            <th class="" style='width: 15%;'>Credit Amount</th>
                            <th class="" style='width: 15%;'>Debit Amount</th>
                            <th class="" style='width: 15%;'>Balance</th>
                            {{--                    <th class="">Dr/Cr</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @if( isset($thead))
                            <tr>
                                <td></td><td></td><td>Opening balance</td><td></td>
                                <td>{{ $data['opening_credit'] }}</td>
                                <td>{{ $data['opening_debit'] }}</td>
                                <td>{{ $data['opening_bl'] }}</td>
                            </tr>
                            <tr>
                                <td></td><td></td><td>Previous balance</td><td></td>
                                <td>{{ $data['prev_credit'] }}</td>
                                <td>{{ $data['prev_debit'] }}</td>
                                <td >{{ $data['prev_bl'] }}</td>
                            </tr>
                            @foreach( $data['vouchers'] as $voucher )
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime( $voucher->date->date)) }}</td>
                                    <td>{{ $voucher->voucherGroup->code }}</td>
                                    <td>{{ $voucher->credit_head_id == $thead->id ? $voucher->debitAccount->name : $voucher->creditAccount->name }}</td>
                                    <td>{{ $voucher->note }}</td>
                                    <td>{{ $voucher->credit_head_id == $thead->id ? $voucher->amount : '' }}</td>
                                    <td>{{ $voucher->debit_head_id == $thead->id ? $voucher->amount : '' }}</td>
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
        $(document).ready(function() {
            $('.thead_id').select2({
                placeholder: 'Select an account'
            });
        });
    </script>

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
