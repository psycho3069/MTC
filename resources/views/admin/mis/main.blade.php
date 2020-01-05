@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <h1> List </h1>
        <a class="btn btn-light float-right" href="{{ route('mis.accounts.create', [ 'type' => $type ]) }}">Add Account for {{ strtoupper($type) }}</a>
        <br><br><br>
        <table class="table table-bordered table-dark">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Credit Account</th>
                <th scope="col">Debit Account</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $accounts as $item )
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ strtoupper($type) }}</td>
                    <td colspan="2">
                        {{ $item->creditAccount->name }} - {{ $item->debitAccount->name }} {{ $item->default ? '(Default)' : '' }}
                    </td>
                    <td>
                        <!-- Example single danger button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">(set as default)</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
