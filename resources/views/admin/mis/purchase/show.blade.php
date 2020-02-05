@extends('admin.master')

@section('content')
    <div class="col-md-7">
        <samp>
            <div class="card text-left">
                {{--                <div class="card-header"> <strong>All {{ ucfirst($categories->first()->category) }} Item</strong></div>--}}
                <div class="card-header">
                    <b>{{ date('d-m-Y', strtotime( $p_group->date->date )) }} Purchase</b>
                </div>

                <div class="card-body">
                    <table class="table table-hover table-bordered blue">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Cost</th>
                            <th>Supplier</th>
                            <th>Receiver</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $p_group->purchases as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->ledger->name }}</td>
                                <td class="text-right">{{ $item->currentStock->quantity_dr * $item->unit->multiply_by.' '.$item->unit->name }}</td>
                                <td class="text-right">{{ $item->amount }} tk.</td>
                                <td class="text-center">{{ $item->supplier->name }}</td>
                                <td class="text-center">{{ $item->receiver->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </samp>
    </div>
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
