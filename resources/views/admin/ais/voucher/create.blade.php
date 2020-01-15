@extends('admin.master')


@section('content')
    <style>
        .required{
            color: #ff0000;
        }
    </style>
    <div class="col-md-8">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    {{ $type->name }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Voucher type</label>
                                <input type="text" value="{{ $type->name }}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" name="date" id="date" value="{{ $configuration->software_start_date }}" disabled>
                                {{--                                <input type="hidden" name="date" value="{{ date('Y-m-d') }}">--}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="credit_head_id">Credit Account</label>
                                <select class="form-control" id="credit-head" name="credit_head_id">
                                    @foreach( $account['credit'] as $credit )
                                        <option value="{{ $credit->id }}">{{ $credit->name }} [ {{ $credit->code }} ]</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="debit_head_id">Debit Account</label>
                                <select class="form-control" id="debit-head" name="debit_head_id">
                                    @foreach( $account['debit'] as $debit )
                                        <option value="{{ $debit->id }}">{{ $debit->name }} [ {{ $debit->code }} ]</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount <span class="required">*</span></label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="note">Note <span class="required">*</span></label>
                                <textarea name="note" class="form-control" id="note" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" id="add-button" class="btn btn-i btn-block">Add</button>
                </div>
            </div>
        </samp>
        <br><br><br>


        <samp>
            <div class="card text-left">
                <div class="card-body">
                    <form method="POST" action="{{ route('vouchers.store') }}">
                        {{ csrf_field() }}

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Credit Account</th>
                                <th scope="col">Debit Account</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Note</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="vouchers">

                            </tbody>
                        </table>

                        <div class="form-group">
                            <label for="global_note">Global Note</label>
                            <input type="text" name="global_note" class="form-control" required>
                            {{--                        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">--}}
                            <input type="hidden" name="type_id" value="{{ $type->id }}">
                        </div>

                        <button type="submit" class="btn btn-dark">Submit</button>

                    </form>
                </div>
            </div>
        </samp>
    </div>




@endsection


@section('script')
    <script>
        $(document).ready(function () {
            var i = 0;

            $(':submit').click(function (e) {
                if( i < 1 ){
                    e.preventDefault()
                    alert('Please add at least one voucher')
                }
            })

            $('#add-button').click(function () {

                var amount = $('#amount').val()
                var note = $('#note').val()
                var date = $('#date').val()
                var credit_head_id = $('#credit-head :selected').val()
                var debit_head_id = $('#debit-head :selected').val()


                if( !note || !amount )
                    alert('Please Enter all fields')
                else {

                    i++;
                    $('#vouchers').append(
                        '<tr id="row'+i+'">' +
                        '<td><input type="hidden" name="input['+i+'][credit_head_id]" value="'+credit_head_id+'">'+$('#credit-head :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][debit_head_id]" value="'+debit_head_id+'">'+$('#debit-head :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][amount]" value="'+amount+'"><input type="hidden" name="date" value="'+date+'">'+amount+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][note]" value="'+note+'">'+note+'</td>' +
                        '<td><a class="btn btn-danger btn-sm remove" id="'+i+'">Remove</a></td>' +
                        '</tr>'
                    )

                }

            })



            $(document).on('click', '.remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
                i--
            });
        })


    </script>
@endsection
