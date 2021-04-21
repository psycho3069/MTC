@extends('admin.master')


@section('reports')
    <div class="boxer">
        <div class="box-row"><!--Headings-->
            <div class="box"></div>
            <div class="box">Account Type</div>
            <div class="box">Mother Head</div>
            <div class="box">Account Head & Code</div>
            <div class="box">Debit</div>
            <div class="box">Credit</div>
            <div class="box">Balance</div>
        </div>

        @foreach( $data as $count => $thead)
            <div class="box-row">
                <div class="box">{{$count}}</div>
                <div class="box">{{$thead->ac_head_name}}</div>
                <div class="box">{{$thead->parent}}</div>
                <div class="box google">
                  <span class="left">
                      {{$thead->name}}
                  </span>
                    <span class="right">[{{$thead->code}}]</span>
                </div>
                <div class="box">
                    <input type="number" class="inputbox debit"
                           data-type="{{$thead->ac_head_id}}"
                           name="debit[{{$thead->id}}]"
                           value="{{old("debit.$thead->id", $thead->debit)}}">
                </div>
                <div class="box">
                    <input type="number" class="inputbox credit"
                           data-type="{{$thead->ac_head_id}}"
                           name="credit[{{$thead->id}}]"
                           value="{{old("debit.$thead->id", $thead->debit)}}">
                </div>
                <div class="box center">
                    <input type="number" class="inputbox amount"
                           name="amount[{{$thead->id}}]"
                           value="{{$thead->amount}}" disabled>
                </div>
            </div>
        @endforeach


    </div>

@endsection


@section('style')
    <style>
        .boxer {
            display: table;
            border-collapse: collapse;
            margin-left: 50px;
        }
        .boxer .box-row {
            display: table-row;
        }
        .boxer .box-row:first-child {
            font-weight:bold;
        }
        .boxer .box {
            display: table-cell;
            vertical-align: top;
            border: 1px solid black;
            padding: 5px;
            font-family:monospace;
        }
        .boxer .ebay {
            padding:5px 1.5em;
        }
        .boxer .google {
            padding:5px 1.5em;
        }
        .boxer .amazon {
            padding:5px 1.5em;
        }
        .center {
            text-align:center;
        }
        .right {
            float:right;
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var cr_amount = 0
            var dr_amount = 0
            // total()

            $(':input').on('keyup', function() {
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




            $(document).on('submit', 'form', function (e) {
                total()
                if ( dr_amount != cr_amount ){
                    e.preventDefault();
                    alert('Debit and credit isn\'t equal');
                    $('p.error').html(' Debit and credit isn\'t equal');
                } else {
                    $('p.error').empty();
                    $('p.success').html('Please wait! Your form is being submitted');
                }

            });


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


