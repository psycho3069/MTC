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
                    {{ $data['type']->name }}
                </div>

                <div class="card-body">
                    <p class="text-danger">{{ $errors->has('input.*.amount') ? $errors->first('input.*.amount') : '' }}</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Voucher type</label>
                                <input type="text" value="{{ $data['type']->name }}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" class="form-control" value="{{ date('d-m-Y', strtotime( $data['date'])) }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="credit_head_id">Credit Account</label>
                                <select class="form-control ufat" id="credit-head" name="credit_head_id">
                                    @foreach( $account['credit'] as $credit )
                                        <option value="{{ $credit->id }}">{{ $credit->name }} [ {{ $credit->code }} ]</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="debit_head_id">Debit Account</label>
                                <select class="form-control ufat" id="debit-head" name="debit_head_id">
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
                                <input type="text" class="form-control" id="amount" name="amount" required>
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
                        <input type="hidden" name="type_id" value="{{ $data['type']->id }}">
                        <input type="hidden" name="date" value="{{ $data['date'] }}">

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
                            <input type="text" name="global_note" class="form-control">
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
        $(document).ready(function() {
            $('.ufat').select2({
                placeholder: 'Select an option'
            });
        });
    </script>

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
                var credit_head_id = $('#credit-head :selected').val()
                var debit_head_id = $('#debit-head :selected').val()


                if( !amount )
                    alert('Please Enter all fields')
                else {

                    i++;
                    $('#vouchers').append(
                        '<tr id="row'+i+'">' +
                        '<td><input type="hidden" name="input['+i+'][credit_head_id]" value="'+credit_head_id+'">'+$('#credit-head :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][debit_head_id]" value="'+debit_head_id+'">'+$('#debit-head :selected').text()+'</td>' +
                        '<td><input type="hidden" name="input['+i+'][amount]" value="'+amount+'">'+amount+'</td>' +
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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

@endsection
