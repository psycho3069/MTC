@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <h1>Create New {{ $type != 2 ? 'Account' : 'Transaction Head' }}</h1>


        <form action="{{ route('accounts.store') }}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="type" value="{{ $type }}">

            @foreach( $data as $key => $item )
                {{ $item->name }}
                <p style="margin-left: 4%;">&darr;</p>
                <input type="hidden" name="{{ $key }}" value="{{ $item->id }}">
            @endforeach


            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                </div>
{{--                <div class="col-md-4">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="amount">Amount</label>--}}
{{--                        <input type="number" name="amount" class="form-control" required>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
