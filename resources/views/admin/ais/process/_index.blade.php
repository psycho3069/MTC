@extends('admin.master')


@section('content')
    <div class="col-md-6 offset-md-3">

        <h1>Day end process</h1>
        <form method="POST" action="{{ route('process.store') }}">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-light float-right">Execute day end</button>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Type</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Note</th>
                    <th scope="col">Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $vouchers as $voucher )
                    <input type="hidden" name="voucher_id[]" value="{{ $voucher->id }}">
                    <tr>
                        <td>{{ $voucher->code }}</td>
                        <td>{{ $voucher->type->name }}</td>
                        <td>{{ $voucher->amount }}</td>
                        <td>{{ str_limit( $voucher->note, 40)  }}</td>
                        <td>{{ $voucher->date }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        </form>


    </div>

@endsection
