@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <samp>
            <div class="card text-left">
                <div class="card-header"> Configuration</div>
                <div class="card-body">
                    <p class="text-danger">{{ $errors->has('software_start_date') ? $errors->first('software_start_date') : '' }}</p>
                    <form method="POST" action="{{ route('update.hotel') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <p class="config-label"><b>Software Date</b></p>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Select a date</label>
                                    <input type="date"  class="form-control date" name="software_start_date" value="{{ date('Y-m-d', strtotime($conf->firstWhere('name', 'software_date')->software_start_date)) }}">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-3">
                                <p class="config-label"><b>Vat</b><small>( in %)</small></p>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Food</label>
                                            <input type="number" name="conf[vat_food]" class="form-control" min="0" value="{{ $conf->firstWhere('name', 'vat_food')->value }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Service Charge</label>
                                            <input type="number" name="conf[vat_service]" class="form-control" min="0" value="{{ $conf->firstWhere('name', 'vat_service')->value }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Others</label>
                                            <input type="number" name="conf[vat_others]" class="form-control" min="0" value="{{ $conf->firstWhere('name', 'vat_others')->value }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <br><br><br>
                        <div class="row">
                            <div class="col-md-3">
                                <p class="config-label"><b>Room</b></p>
                                <p class="config-label"><b>Venue</b></p>
                                <p class="config-label"><b>Restaurant</b></p>
                                <p class="config-label"><b>Restaurant (Personal)</b></p>
                                <p class="config-label"><b>Discount</b></p>
                            </div>
                            <div class="col-md-5">
                                @foreach( $data['hotel'] as $mis_head )
                                    <div class="form-group">
                                        <label>Receipt Account</label>
                                        <input type="hidden" name="input[hotel][{{$mis_head->id}}][debit_head_id]" value="{{ 353 }}">
                                        <select class="form-control ufat" name="input[hotel][{{$mis_head->id}}][credit_head_id]">
                                            @foreach( $theads as $thead )
                                                <option value="{{ $thead->id }}" {{ $mis_head->ledger[0]->credit_head_id == $thead->id ? 'selected' : '' }}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach

                                    <div class="form-group">
                                        <label>Receipt Account</label>
                                        <input type="hidden" name="input[res][{{$data['res']->id}}][debit_head_id]" value="{{ 353 }}">
                                        <select class="form-control ufat" name="input[res][{{$data['res']->id}}][credit_head_id]">
                                            @foreach( $theads as $thead )
                                                <option value="{{ $thead->id }}" {{ $data['res']->ledger->last()->credit_head_id == $thead->id ? 'selected' : '' }}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Receipt Account</label>
                                        <input type="hidden" name="input[discount][{{$data['discount']->id}}][credit_head_id]" value="{{ 353 }}">
                                        <select class="form-control ufat" name="input[discount][{{$data['discount']->id}}][debit_head_id]">
                                            @foreach( $theads as $thead )
                                                <option value="{{ $thead->id }}" {{ $data['discount']->ledger[0]->debit_head_id == $thead->id ? 'selected' : '' }}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                            @endforeach
                                        </select>
                                    </div>


                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-block btn-i">Update</button>
                        </div>
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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

@endsection
