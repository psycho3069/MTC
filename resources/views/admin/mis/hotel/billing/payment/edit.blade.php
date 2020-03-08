@extends('admin.master')


@section('content')
    <div class="col-md-5">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    Update Payment of <b>{{ $payment->bill->guest->name }}</b>
                </div>

                <form action="{{ route('payment.update', [ $payment->billing_id, $payment->id ]) }}" method="POST">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PATCH">

                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" class="form-control" name="amount" value="{{ $payment->amount }}" min="0">
                        </div>
                        <div class="form-group">
                            <label>Note</label>
                            <textarea name="note" class="form-control" cols="3" rows="1">{{ $payment->note ? $payment->note : '' }}</textarea>
                            {{--                                    <input type="text" class="form-control" name="note" value="">--}}
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-i">Update</button>
                        </div>
                    </div>


                </form>





            </div>
        </samp>
    </div>

@endsection

