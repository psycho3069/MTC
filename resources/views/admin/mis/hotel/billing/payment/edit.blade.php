@extends('admin.master')


@section('content')
    <div class="col-md-7">
        <form action="{{ route('payment.update', [ $payment->billing_id, $payment->id ]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PATCH">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" class="form-control" name="amount" value="{{ $payment->amount }}" min="0">
                    </div>
                    <div class="form-group">
                        <label>Note</label>
                        <input type="text" class="form-control" name="note" value="{{ $payment->note ? $payment->note : '' }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-light">Update</button>
            </div>
        </form>
    </div>

@endsection

