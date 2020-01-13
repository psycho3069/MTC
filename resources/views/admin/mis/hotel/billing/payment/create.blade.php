@extends('admin.master')


@section('content')
    <div class="col-md-4">
        <samp>
            <form action="{{ route('payment.store', $bill->id) }}" method="POST">
                <div class="card">
                    <div class="card-header"><b>Payment</b></div>
                    <div class="card-body text-left">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Total Bill</label>
                                    <input type="text" class="form-control" id="total_bill" value="{{ $bill->total_bill }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Total Paid</label>
                                    <input type="text" class="form-control" id="total_paid" value="{{ $bill->total_paid }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Payment Amount</label>
                                    <input type="number" class="form-control" name="amount" value="0" min="0" max="{{ $bill->total_bill - $bill->total_paid }}" required>
                                </div>
                            </div>


                            <div class="col-md-6">
                                @if( !$bill->reserved)
                                    <div class="form-group">
                                        <label>Check-Out</label>
                                        <select class="form-control" name="checkout_status" {{ $bill->checkout_status ? 'disabled' : '' }}>
                                            <option value="0" {{ !$bill->checkout_status ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ $bill->checkout_status ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Due</label>
                                    <input type="number" class="form-control" id="due" value="{{ $bill->total_bill - $bill->total_paid }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label>Note</label>
                                    <input type="text" class="form-control" name="note">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-block">Pay</button>
                    </div>
                </div>
            </form>
        </samp>
    </div>

@endsection

