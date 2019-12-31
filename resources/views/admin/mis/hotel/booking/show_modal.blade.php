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
            <div class="card-header">Billing Report</div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-info">
                    <thead>
                    <tr>
                        <th></th>
                        <th class="">Room No</th>
                        <th class="">Attendees</th>
                        <th class="">Start Date</th>
                        <th class="">End Date</th>
                        <th class="">Discount</th>
                        <th class="">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $bill->booking as $key => $item )
                        <tr>
                            <td>{{ $loop->iteration }}</td>
{{--                            <td>{{ $room[$key]->room_no }}</td>--}}
                            <td>{!! $item->room_id < 50 ? $item->room->room_no.'-'.$item->room->roomCat->name.' <small> Price('.$item->room->price.')</small>' : $item->venue->name.'-'.$item->venue->location.' <small> Price('.$item->venue->price.')</small>' !!}</td>
                            <td></td>
                            <td>{{ date('d/m/Y', strtotime( $item->start_date)) }}</td>
                            <td>{{ date('d/m/Y', strtotime( $item->end_date)) }}</td>
                            <td>{{ $item->discount }}</td>
                            <td>{{ $data['room_cost'][$key] }}</td>
{{--                            <td>{{ $item->guest->name }}</td>--}}
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="">View</a>
                                        <a class="dropdown-item" href="">Edit</a>
                                        <a class="dropdown-item" href="#visitant" data-toggle="modal" data-target="#visitant">Add Visitant</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    @endforeach
                    <tr>
                        <td></td>
                        <td>Total</td>
                        <td></td><td></td><td></td><td></td><td></td>
                        <td>{{ $data['total'] }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="visitant" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Visitant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact No.</label>
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Name">
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

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
