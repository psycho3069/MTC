@extends('admin.master')


@section('content')
    <div class="col-md-12">
        {{ csrf_field() }}
        <br><br><br>

        <div class="card text-left">

            <div class="card-header"><code><b>{{ $data['checkout'] ? 'Checkout' : 'Billing' }} List</b></code></div>
            <div class="card-body">
                <samp>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="">Date</th>
                            <th class="">Guest Name</th>
                            <th class="">Organization</th>
                            <th class="no-wrap">Total Bill</th>
                            <th class="no-wrap">Total Paid</th>
                            <th class="">Due</th>
                            <th class="">Discount</th>
                            <th class="">Checkout</th>
                            <th class="">Action</th>
                            <th class="">Payments</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $billing as $bill )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="no-wrap">{{ !$bill->date ? $bill->id : date('d-m-Y', strtotime( $bill->date->date)) }}</td>
                                <td><a href="{{ route('billing.show', $bill->id) }}">{{ $bill->guest->name }}</a></td>
                                <td><code>{{ $bill->guest->org_name ? $bill->guest->org_name : 'Not Found' }}</code></td>
                                <td>{{ $bill->total_bill }}</td>
                                <td>{{ $bill->total_paid }}</td>
                                <td>{{ $bill->total_bill - $bill->total_paid }}</td>
                                <td>{{ $bill->discount }}</td>
                                <td><b>{!! $bill->checkout_status ? '<span class="badge badge-success">YES</span>' : '<span class="badge badge-danger">NO</span>' !!}</b></td>
                                <td>
                                    <a href="{{ route('billing.show', $bill->id) }}" class="btn btn-sm btn-i" title="View">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('billing.edit', $bill->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a href="" class="btn btn-sm btn-danger" data_id="{{ $bill->id }}" title="Delete" onclick="destroy( $(this).attr('data_id')); return false;">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-i" for="btnControl">
                                            Payment
                                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="{{ route('payment.create', $bill->id) }}">Make Payment</a>
                                            <a href="{{ route('payment.index', $bill->id) }}">All Payments</a>
                                            @if( !$bill->checkout_status)
                                                <a href="{{ route('payment.create', [$bill->id, 'co' => 1]) }}">Checkout</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </samp>
            </div>
        </div>

    </div>

@endsection

@section('style')
    <style>
        .btn-sm{
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
            line-height: .5;
            border-radius: 0.2rem;
        }
    </style>
@endsection

@section('script')
    <script>
        var _token = $('input[name="_token"]').val()

        function destroy(id) {
            var check = confirm('Are you sure want Delete this?')


            if( check){
                $.ajax({
                    type: 'DELETE',
                    url: 'billing/'+id,
                    data:{ _token: _token },
                    success:function (data) {
                        // console.log( data)
                        window.location.href = "{{ route('vouchers.index') }}";
                    }
                })
            }


        }
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
