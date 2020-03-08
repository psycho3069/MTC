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
                                    <label>Payment Type</label>
                                    <select class="form-control" name="payment_type" id="type">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Total Bill</label>
                                    <input type="text" class="form-control" id="total_bill" value="{{ $bill->total_bill }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Payment Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" value="0" min="0">
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
                                    <label>Total Paid</label>
                                    <input type="text" class="form-control" id="total_paid" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Due</label>
                                    <input type="number" class="form-control" id="due" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Note</label>
                            <textarea class="form-control" name="note" cols="3" rows="1"></textarea>
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



@section('script')
    <script>
        $(document).ready(function () {

            var charge = @json($charge);
            // console.log(charge)

            // $('#type').append('<option value="all">All</option>')


            $(':submit').click(function (e) {
                if(!$('#amount').val())
                    $('#amount').val(0)
            })



            if( charge['room']['total'] > 0)
                $('#type').append('<option value="room">Room</option>')

            if( charge['venue']['total'] > 0)
                $('#type').append('<option value="venue">Venue</option>')

            if( charge['food']['total'] > 0)
                $('#type').append('<option value="food">Restaurant</option>')


            var type = $('#type').val()
            getAll( type)




                $('#type').on('change selected', function () {

                    type = $('#type').val()
                    getAll( type)
            })


            $('#amount').on('change keyup', function () {
                var due = charge[type]['total'] - charge[type]['paid'] - parseInt($('#amount').val())
                $('#due').val(due)
            })



            function getAll( type) {
                var due = charge[type]['total'] - charge[type]['paid']

                $('#total_bill').val( charge[type]['total'])
                $('#total_paid').val( charge[type]['paid'])
                $('#due').val( due)
                $('#amount').attr('max', due)

            }



        })
    </script>
@endsection

