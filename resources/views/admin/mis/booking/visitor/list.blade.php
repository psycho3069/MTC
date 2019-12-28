@extends('admin.master')


@section('content')
    <style>
        a.dropdown-item {
            color: #fff;
        }
    </style>
    <div class="col-md-7 offset-md-2">
        <br><br><br>
        <div class="card">
            <div class="card-header">
                <b>{{ $booking->room_id < 50 ? 'Room No-'.$booking->room->room_no : $booking->venue->name }} Visitors</b>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <th class="">Name</th>
                        <th class="">Contact No.</th>
                        <th class="">Address</th>
                        <th class="">Appearance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $booking->visitors as $item )
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->contact_no ? $item->contact_no : '' }}</td>
                            <td>{{ $item->address ? $item->address : '' }}</td>
                            <td>{{ $item->appearance }} Time(s)</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('datatable')

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.tablse').DataTable({
                "paging": true,
                "ordering":  true,
            });
        } );
    </script>

@endsection
