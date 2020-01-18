@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <samp>
            <div class="card">
                <div class="card-header">
                    <b>Create New {{ $type != 2 ? 'Account Head' : 'Transaction Head' }}</b>
                </div>
                <div class="card-body">
                    <form action="{{ route('accounts.store') }}" method="POST">
                        {{ csrf_field() }}

                        <input type="hidden" name="type" value="{{ $type }}">

                        @foreach( $data as $key => $item )
                            {{ $item->name }}
                            <p style="margin-left: 4%;">&darr;</p>
                            <input type="hidden" name="{{ $key }}" value="{{ $item->id }}">
                        @endforeach


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    <p class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                                    <p class="text-danger">{{ $errors->has('code') ? $errors->first('code') : '' }}</p>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-i btn-block">Add</button>
                    </form>
                </div>
            </div>
        </samp>

    </div>
@endsection
