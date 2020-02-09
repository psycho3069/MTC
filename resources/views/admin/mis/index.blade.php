@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <samp>
            <div class="card text-left">
                <div class="card-header"> Configuration</div>
                <div class="card-body">
                    <p class="text-danger">{{ $errors->has('software_start_date') ? $errors->first('software_start_date') : '' }}</p>
                    <form method="POST" action="{{ route('mis.accounts.store') }}">
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
{{--                        <div class="row">--}}
{{--                            <div class="col-md-3">--}}
{{--                                <p class="config-label"><b>Hotel</b></p>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-5">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Receipt Account</label>--}}
{{--                                    <input type="hidden" name="data[{{ $type[0]->id }}][debit_head_id]" value="{{ $type[0]->debit_head_id }}">--}}
{{--                                    <select class="form-control ufat" name="data[{{ $type[0]->id }}][credit_head_id]">--}}
{{--                                        @foreach( $theads as $thead )--}}
{{--                                            <option value="{{ $thead->id }}" {!! $thead->id == $type[0]->credit_head_id ? 'selected="selected"' : '' !!}>{{ $thead->name }} [ {{ $thead->code }} ]</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row">--}}
{{--                            <div class="col-md-3">--}}
{{--                                <p class="config-label"><b>Training center</b></p>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-5">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Receipt Account</label>--}}
{{--                                    <input type="hidden" name="data[{{ $type[1]->id }}][debit_head_id]" value="{{ $type[1]->debit_head_id }}">--}}
{{--                                    <select class="form-control ufat" name="data[{{ $type[1]->id }}][credit_head_id]">--}}
{{--                                        @foreach( $theads as $thead )--}}
{{--                                            <option value="{{ $thead->id }}" {!! $thead->id == $type[1]->credit_head_id ? 'selected="selected"' : '' !!}>{{ $thead->name }} [ {{ $thead->code }} ]</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row">--}}
{{--                            <div class="col-md-3">--}}
{{--                                <p class="config-label"><b>Restaurant</b></p>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label>Receipt Account</label>--}}
{{--                                            <input type="hidden" name="data[{{ $type[2]->id }}][credit_head_id]" value="{{ $type[2]->credit_head_id }}">--}}
{{--                                            <select class="form-control ufat" name="data[{{ $type[2]->id }}][debit_head_id]">--}}
{{--                                                @foreach( $theads as $thead )--}}
{{--                                                    <option value="{{ $thead->id }}" {!! $thead->id == $type[2]->debit_head_id ? 'selected="selected"' : '' !!}>{{ $thead->name }} [ {{ $thead->code }} ]</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label>Payment Account</label>--}}
{{--                                            <input type="hidden" name="data[{{ $type[3]->id }}][debit_head_id]" value="{{ $type[3]->debit_head_id }}">--}}
{{--                                            <select class="form-control ufat" name="data[{{ $type[3]->id }}][credit_head_id]">--}}
{{--                                                @foreach( $theads as $thead )--}}
{{--                                                    <option value="{{ $thead->id }}" {!! $thead->id == $type[3]->credit_head_id ? 'selected="selected"' : '' !!}>{{ $thead->name }} [ {{ $thead->code }} ]</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div class="row">--}}
{{--                            <div class="col-md-3">--}}
{{--                                <p class="config-label"><b>Inventory</b></p>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-5">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Payment Account</label>--}}
{{--                                    <input type="hidden" name="data[{{ $type[4]->id }}][credit_head_id]" value="{{ $type[4]->credit_head_id }}">--}}
{{--                                    <select class="form-control ufat" name="data[{{ $type[4]->id }}][debit_head_id]">--}}
{{--                                        @foreach( $theads as $thead )--}}
{{--                                            <option value="{{ $thead->id }}" {!! $thead->id == $type[4]->debit_head_id ? 'selected="selected"' : '' !!}>{{ $thead->name }} [ {{ $thead->code }} ]</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="card-footer">
                            <button type="submit" class="btn btn-dark">Update</button>
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
