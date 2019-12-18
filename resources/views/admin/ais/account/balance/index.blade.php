@extends('admin.master')


@section('content')
    <div class="col-md-6 offset-md-3">

        <form method="POST" action="{{ route('balance.store') }}">
            {{ csrf_field() }}
            <table class="table table-bordered table-hover table-primary opening-balance" id="myTable">
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
                                <input type="number" class="inputbox debit" data-type="{{ $thead->ac_head_id }}" name="debit[{{ $thead->id }}]" value="{{ old('debit[$thead->id]') ? old('debit[$thead->id]') : $thead->debit }}">
                            </td>
                            <td>
                                <input type="number" class="inputbox credit" data-type="{{ $thead->ac_head_id }}" name="credit[{{ $thead->id }}]" value="{{ $thead->credit }}">
                            </td>
                            <td>
                                <input type="number" class="inputbox amount" name="amount[{{ $thead->id }}]" value="{{ $thead->amount }}" disabled>
                            </td>
{{--                            <td></td>--}}
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-4 text-right"><label for="total" id="total" style="font-size: large">Total</label></div>
                <div class="col-md-4 text-right"><input type="text" class="inputbox total" name="total-debit" id="total-debit" style="font-size: large" disabled><p class="alert-danger"></p></div>
                <div class="col-md-4 "><input type="text" class="inputbox total" name="total-credit" id="total-credit" style="font-size: large" disabled><p class="alert-danger"></p></div>
            </div>
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
            var cr_amount = 0
            var dr_amount = 0
            // total()

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





            $('#submit').click(function (e) {
                if ( dr_amount != cr_amount ){
                    e.preventDefault();
                    $('p.error').html(' Debit and credit isn\'t equal');
                }
            })

            $('#reset').click(function () {
                $('input.inputbox').val(0);
            })





            function total() {
                var total_debit = 0;
                var total_credit = 0;
                $('input.debit').each(function () {
                    if ( !isNaN(this.value) && this.value.length !=0 ){
                        total_debit += parseFloat(this.value);
                        dr_amount = total_debit;
                    }
                });
                $('input.credit').each(function () {
                    if ( !isNaN(this.value) && this.value.length !=0 ){
                        total_credit += parseFloat(this.value);
                        cr_amount = total_credit;
                    }
                });
                $('#total-debit').val(total_debit.toFixed(2));
                $('#total-credit').val(total_credit.toFixed(2));
            }

        })
    </script>
@endsection

{{--@section('datatable')--}}

{{--    <!-- datatable -->--}}
{{--    --}}{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
{{--    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>--}}
{{--    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>--}}
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('.table').DataTable({--}}
{{--                "paging": true,--}}
{{--                "ordering":  true,--}}
{{--            });--}}
{{--        } );--}}
{{--    </script>--}}

{{--@endsection--}}

