@extends('admin.master')


@section('content')
    <div class="col-md-9">
        <samp>
            <div class="card text-left">
                <div class="card-header"> Configuration</div>
                <div class="card-body">
                    <form method="POST" action="{{route('configuration.accounts')}}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <p class=""><b>Vat</b><small>( % )</small></p>
                            </div>
                            @foreach($vatSettings as $key => $setting)
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{$labels[$key]}}</label>
                                        <input type="number" name="settings[{{$setting->name}}]"
                                               class="form-control" value="{{$setting->value}}">
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="row" style="margin-top: 30px;">
                            <div class="col-md-12">
                                <label><b>Account Configuration</b></label>
                            </div>

                            @foreach( $creditAccounts as $key => $ledger )
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{$labels[$key]}}</label>
                                        <select class="form-control ufat" name="credit_accounts[{{$key}}]">
                                            @foreach( $transactionHeads as $thead )
                                                <option value="{{$thead->id}}" {{$ledger->credit_head_id==$thead->id?"selected":''}}>
                                                    {{$thead->name}} [ {{ $thead->code }} ]
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-md-12"></div>

                            @foreach( $debitAccounts as $key => $ledger )
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{$labels[$key]}}</label>
                                        <select class="form-control ufat" name="debit_accounts[{{$key}}]">
                                            @foreach( $transactionHeads as $thead )
                                                <option value="{{$thead->id}}" {{$ledger->debit_head_id==$thead->id?"selected":''}}>
                                                    {{$thead->name}} [ {{ $thead->code }} ]
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>



                        <br><br><br>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-block btn-i">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </samp>
    </div>
@endsection


@section('style')
    <style>
        .account-configuration{
            padding-top: 7px;
            padding-bottom: 10px;
        }
    </style>
@endsection


@section('script')

    <script>
        $(document).ready(function() {
            $('.ufat').select2({
                placeholder: 'Select an option'
            });
        });
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

@endsection
