

@extends('admin.master')


@section('content')
    <div class="col-md-6 offset-md-3">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="">Date</th>
                    <th class="">Voucher Code</th>
                    <th class="">Account head</th>
                    <th class="">Narration/Cheque Details</th>
                    <th class="">Credit Amount</th>
                    <th class="">Debit Amount</th>
                    <th class="">Balance</th>
                    <th class="">Dr/Cr</th>
                </tr>
            </thead>
            <tobody>
                @foreach( $vouchers as $voucher )
                    <tr>
                        <td>{{ $voucher->date->date }}</td>
                        <td>{{ $voucher->code }}</td>
                        <td>{{ $voucher->credit_head_id == 353 ? $voucher->debitAccount->name : $voucher->creditAccount->name }}</td>
                        <td> {{ $voucher->note }}</td>
                        <td colspan="2">
                            <div class="row">
                                <div class="col-md-6">
                                    {{ $voucher->credit_head_id == 353 ? $voucher->amount : '-' }}
                                </div>
                                <div class="col-md-6">
                                    {{ $voucher->credit_head_id != 353 ? $voucher->amount : '-' }}
                                </div>
                            </div>
                        </td>
{{--                        <td>{{ $voucher->credit_head_id == 353 ? $voucher->creditAccount->currentBalance->where('date_id', '<=', $voucher->date_id)->sum('debit') : '' }}</td>--}}
                    </tr>
                @endforeach
            </tobody>
        </table>

    </div>

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
