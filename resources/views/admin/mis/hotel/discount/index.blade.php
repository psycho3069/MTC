@extends('admin.master')


@section('content')
    <div class="col-md-10">
        <br><br><br>
        <samp>
            <div class="card text-left">
                <div class="card-header"><code><b>Discount List</b></code></div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-info">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Guest Name</th>
                            <th>Hotel</th>
                            <th>Restaurant</th>
                            <th>Gross</th>
                            <th>Total</th>
                            <th>Note</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach( $data['bill'] as $bill )
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('d-m-Y', strtotime($bill->created_at)) }}</td>
                                    <td>{{ $bill->guest->name }}</td>
                                    <td>{{ $bill->booking->sum('discount').' tk.' }}</td>
                                    <td>{{ $bill->restaurant->sum('discount').' tk.' }}</td>
                                    <td>{{ $bill->discount .' tk.'}}</td>
                                    <td>{{ $bill->discount + $bill->booking->sum('discount') + $bill->restaurant->sum('discount').' tk.' }}</td>
                                    <td>{{ $bill->note ? $bill->note : 'No Note' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-i" onclick='window.location="{{ route('billing.show', $bill->id) }}"'>View</button>
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
