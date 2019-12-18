@extends('admin.master')


@section('content')
    <div class="col-md-6 offset-md-3">

        <h1>Day end process</h1>
        @if( isset( $date->first()->vGroup ) )
            <form method="POST" action="{{ route('process.store') }}">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-light float-right">Execute day end</button>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Code</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Note</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $date->first()->vGroup as $v_group )
                        <input type="hidden" name="date_id" value="{{ $date->first()->id }}">
                        <tr>
                            <td>{{ $v_group->type->name }}</td>
                            <td>{{ $v_group->code }}</td>
                            <td>{{ $v_group->vouchers->sum('amount') }}</td>
                            <td>{{ str_limit( $v_group->note, 40)  }}</td>
                            <td>{{ $v_group->date->date }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('vouchers.show', $v_group->id) }}">View</a>
                                        <a class="dropdown-item" href="{{ route('vouchers.edit', $v_group->id) }}">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </form>
        @else
            <h3 class="text-center">No Vouchers Found</h3>
        @endif

    </div>

@endsection
