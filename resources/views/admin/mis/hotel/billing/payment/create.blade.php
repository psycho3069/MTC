@extends('admin.master')


@section('content')
    <div class="col-md-7 offset-md-4">
        <form action="{{ route('payment.store', $bill->id) }}" method="POST">
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Total Bill</label>
                        <input type="text" class="form-control" id="total_bill" value="{{ $data['total'] }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Total Paid</label>
                        <input type="text" class="form-control" id="total_paid" value="{{ $bill->total_paid }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Payment Amount</label>
                        <input type="number" class="form-control" name="amount" min="0" max="{{ $data['due'] }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-light form-control">Submit</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <br><br>
                    <div class="form-group">
                        <label>Due</label>
                        <input type="number" class="form-control" id="due" value="{{ $data['due'] }}" disabled>
                    </div>

                    <br>
                    <div class="form-group">
                        <label>Note</label>
                        <input type="text" class="form-control" name="note">
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

