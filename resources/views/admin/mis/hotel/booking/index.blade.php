@extends('admin.master')


@section('content')
    <div class="col-md-7 offset-md-2">
        <br><br><br>
        <div class="card">
            <div class="card-header">Billing List</div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-info">
                    <thead>
                    <tr>
                        <th></th>
                        <th class="">Guest Name</th>
                        <th class="">Booking</th>
                        <th class="">Advanced Paid</th>
                        <th class="">Total Paid</th>
                        <th class="">Total Bill</th>
                        <th class="">Checkout Status</th>
                        <th class="">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $billing as $item )
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->guest->name }}</td>
                            <td>{{ $item->booking->pluck('room_id') }}</td>
                            <td>{{ $item->advance_paid }}</td>
                            <td>{{ $item->total_paid }}</td>
                            <td>{{ $item->total_bill }}</td>
                            <td>{{ $item->checking_status ? 'Yes' : 'No' }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="">View</a>
                                        <a class="dropdown-item" href="">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

