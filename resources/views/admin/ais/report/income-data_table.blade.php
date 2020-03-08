@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="">Income</th>
                    <th class="">Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $heads as $head )
                    @foreach( $head->theads as $thead )
                        <tr>
                            <td>{{ $thead->name }} <b>[{{ $thead->code }}]</b></td>
                            <td>{{ $all_bl->where('thead_id',  $thead->id)->sum('credit') - $all_bl->where('thead_id',  $thead->id)->sum('debit') }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
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
