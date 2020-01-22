@extends('admin.master')

@section('content')
    <div class="col-md-8">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    {{ $type_id != 5 ? 'Grocerie\'s' : 'Inventorie\'s' }} Purchase List
                    <code>
                        <button type="button" class="btn btn-sm btn-i" onclick='window.location="{{ route('purchase.create', ['type_id' => $type_id]) }}"'>New Purchase</button>
                    </code>
                </div>

                <div class="card-body">
                    <table class="table table-info table-hover table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Total cost</th>
                            <th>Note</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $p_groups as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime( $item->date->date)) }}</td>
                                <td>{{ $item->purchases->sum('amount') }} tk.</td>
                                <td>{{ $item->note ? $item->note : 'No notes' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-i" for="btnControl">
                                            More
                                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="{{ route('purchase.show', $item->id) }}">View</a>
                                            <a href="{{ route('purchase.edit', $item->id) }}">Edit</a>
                                        </div>
                                    </div>
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

