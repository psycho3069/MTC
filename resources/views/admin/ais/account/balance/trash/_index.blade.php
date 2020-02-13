@extends('admin.master')


@section('content')
    <div class="col-md-6 offset-md-3">

        <form method="POST" action="{{ route('balance.store') }}">
            {{ csrf_field() }}
            <table class="table table-striped opening-balance" id="myTable">
                <thead>
                <tr>
                    <th scope="col">Account Type</th>
                    <th scope="col">Parent</th>
                    <th scope="col">Account Head & Code</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Credit</th>
                    <th scope="col">Balance</th>
                </tr>
                </thead>

                <tbody>
                @foreach( $theads as $thead )
                    <tr>
                        <td>{{ $thead->accountHead->name }}</td>
                        <td>
                            {!!
                                 $thead->transactionable->ac_head_child_ii_id  ? $thead->transactionable->parent->parent->name.'&rarr;'.$thead->transactionable->parent->name.'&rarr;'.$thead->transactionable->name :
                                ( $thead->transactionable->ac_head_child_i_id ? $thead->transactionable->parent->name.'&rarr;'.$thead->transactionable->name : $thead->transactionable->name )
                            !!}
                        </td>
                        <td>{!! $thead->name.' ['.$thead->code.']' !!}</td>
                        <td>
                            <input type="number" class="inputbox debit" data-type="{{ $thead->ac_head_id }}" name="{{ $thead->id }}" value="{{ $thead->debit }}">
                        </td>
                        <td>
                            <input type="number" class="inputbox credit" data-type="{{ $thead->ac_head_id }}" name="{{ $thead->id }}" value="{{ $thead->credit }}">
                        </td>
                        <td>
                            <input type="number" class="inputbox amount" name="amount[{{ $thead->id }}]" value="{{ $thead->amount }}" disabled>
                        </td>
                        {{--                            <td></td>--}}
                    </tr>
                @endforeach
                <tr>
                    <td><label for="total" id="total">Total</label></td>
                    <td></td><td></td>
                    <td><input type="text" class="inputbox total" name="total-debit" id="total-debit" disabled><p class="alert-danger"></p></td>
                    <td><input type="text" class="inputbox total" name="total-credit" id="total-credit" disabled><p class="alert-danger"></p></td>
                </tr>
                </tbody>
            </table>
            <div class="offset-md-5">
                <p class="alert-danger error text-center"></p>
            </div>
            <button type="submit" id="submit" class="btn btn-light">Submit</button>
            <button type="button" id="reset" class="btn btn-danger">Reset</button>
        </form>

    </div>

@endsection


@section('script')
    <script>
        $(document).ready(function () {
            $('input').on('change', function() {
                var amount = $(this).parent().siblings().find('input.amount').val()
                if(($(this).val()==''))
                    $(this).val(0)
                // $(this).hasClass('debit') ? alert($(this).val())+' '+alert($(this).parent().next().find('input.credit').val()) : alert($(this).parent().prev().find('input.debit').val())
                if ( $(this).hasClass('debit') ){
                    var debit = $(this).val();
                    var credit = $(this).parent().next().find('input.credit').val();
                    amount = ($(this).data('type')==1) || ($(this).data('type')==4) ? ( debit - credit ) : (credit - debit);
                } else if( $(this).hasClass('credit') ) {
                    var credit = $(this).val();
                    var debit = $(this).parent().prev().find('input.debit').val();
                    amount = ($(this).data('type')==1) || ($(this).data('type')==4) ? ( debit - credit ) : (credit - debit);
                }
                $(this).parent().siblings().find('input.amount').val(amount.toFixed(2));
                total();
            });
            function total() {
                var total_debit = 0;
                var total_credit = 0;
                $('input.debit').each(function () {
                    if ( !isNaN(this.value) && this.value.length !=0 ){
                        total_debit += parseFloat(this.value);
                    }
                });
                $('input.credit').each(function () {
                    if ( !isNaN(this.value) && this.value.length !=0 ){
                        total_credit += parseFloat(this.value);
                    }
                });
                $('#total-debit').val(total_debit.toFixed(2));
                $('#total-credit').val(total_credit.toFixed(2));
            }
            var _token = $("input[name='_token']").val();
            $('#reset').click(function () {
                $('input.inputbox').val(0);
            })
            $('#submit').click(function (e) {
                e.preventDefault();
                var debit_val = new Array()
                var debit_key = new Array()
                $('.debit').each(function() {
                    debit_val.push($(this).val())
                    debit_key.push($(this).attr('name'))
                });
                var credit_val = new Array()
                var credit_key = new Array()
                $('.credit').each(function() {
                    credit_val.push($(this).val())
                    credit_key.push($(this).attr('name'))
                });
                $.ajax({
                    type:'POST',
                    url:'{{ route("balance.check") }}',
                    data:{_token:_token, debit_val:debit_val, debit_key:debit_key, credit_val: credit_val, credit_key: credit_key },
                    success:function(data){
                        // data.success ? console.log( data.success ) : $('.total').addClass('alert-danger')
                        if( data.success ){
                            window.location.href = "{{ url('accounts') }}"
                        }else{
                            $('p.error').html(data.error)
                            // alert(data.error)
                        }
                        //
                        // console.log(data)
                    }
                })
            })
        })
    </script>

@endsection
