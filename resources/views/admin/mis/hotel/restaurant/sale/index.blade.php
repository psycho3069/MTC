@extends('admin.master')


@section('content')
    <div class="col-md-7 offset-md-2">
        <br><br><br>
        <samp>
            <div class="card">
                <div class="card-header">
                    Food Sales
                    <button type="button" class="btn btn-info float-right" onclick='window.location="{{ route('sales.create') }}"'>Add Sales</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-info">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Guest Name</th>
                            <th>Total Bill</th>
                            <th>Checkout</th>
                            <th class="">Action</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $billing as $bill )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('sales.show', $bill->id) }}">{{ $bill->guest->name }}</a></td>
                                <td class="text-center"><code>{{ $data[$bill->id]['bill'] }} tk.</code></td>
                                <td class="text-center"><code>{{ $bill->checkout_status ? 'Yes' : 'No' }}</code></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Bill
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item font-color" href="{{ route('billing.show', $bill->id) }}">View</a>
                                            <a class="dropdown-item font-color" href="{{ route('sales.edit', $bill->id) }}">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item font-color" href="#">Delete</a>
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

