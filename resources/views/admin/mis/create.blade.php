@extends('admin.master')


@section('content')
<style>
        .required{
            color: #ff0000;
        }
    </style>
    <div class="col-md-6">
        <h1>Create New Account for {{ strtoupper($type) }}</h1>


        <form action="{{ route('mis.accounts.store') }}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="type" value="{{ $type }}">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="default">Set As Default Account</label>
                        <select class="form-control" name="default">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="credit_head_id">Credit Account</label>
                        <select class="form-control" id="credit-head" name="credit_head_id">
                            @foreach( $theads as $credit )
                                <option value="{{ $credit->id }}">{{ $credit->name }} [ {{ $credit->code }} ]</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="debit_head_id">Debit Account</label>
                        <select class="form-control" id="debit-head" name="debit_head_id">
                            @foreach( $theads as $debit )
                                <option value="{{ $debit->id }}">{{ $debit->name }} [ {{ $debit->code }} ]</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
