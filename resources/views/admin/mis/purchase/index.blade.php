@extends('admin.master')

@section('content')
    <div class="col-md-8">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    {{ $type_id != 5 ? 'Grocerie\'s' : 'Inventorie\'s' }} Purchase List
                    <code>
                        <button type="button" class="btn btn-sm btn-default" onclick='window.location="{{ route('purchase.create', ['type_id' => $type_id]) }}"'>New Purchase</button>
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
                                <td>{{ date('d M, y', strtotime($item->created_at)) }}</td>
                                <td>{{ $item->purchases->sum('amount') }} tk.</td>
                                <td>{{ $item->note ? $item->note : 'No notes' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            More
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item font-color" href="{{ route('purchase.show', $item->id) }}">View</a>
                                            <a class="dropdown-item font-color" href="{{ route('purchase.edit', $item->id) }}">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item font-color" href="">Delete</a>
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

