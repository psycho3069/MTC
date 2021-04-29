@extends('admin.master')


@section('content')
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">{{ $bill->guest->name }}</div>
            <div class="card-body">
                <samp>
                    <form action="{{ route('payment.store', $bill->id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="checkout_status" value="1">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Bill</label>
                                    <input type="number" class="form-control" id="total_bill" value="{{ $bill->total_bill }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Paid</label>
                                    <input type="number" class="form-control" id="total_paid" value="{{ $bill->total_paid }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Due</label>
                                    <input type="number" class="form-control" id="due" value="{{ $bill->total_bill - $bill->total_paid - $bill->discount }}" disabled>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Payment Amount</label>
                                    <input type="number" class="form-control" id="amount" value="{{ $bill->total_bill - $bill->total_paid }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input type="number" step="0.01" class="form-control" name="discount" id="discount" min="0" value="{{ $bill->discount }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Note</label>
                                    <input type="text" class="form-control" name="note">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info form-control">Checkout</button>
                        </div>
                    </form>
                </samp>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        $(document).ready(function () {
            var total_bill = parseFloat($('#total_bill').val())
            var due = parseFloat($('#due').val())
            var amount = parseFloat($('#amount').val())
            var discount = parseFloat($('#discount').val())

            $('#discount').on('change keyup', function () {
                var val = parseFloat($(this).val()) - discount
                // $('#total_bill').val(total_bill-val)
                $('#due').val(due-val)
                $('#amount').val(amount-val)

            })

        })
    </script>
@endsection

