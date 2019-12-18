@extends('admin.master')


@section('content')
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header"> Configuration</div>
            <div class="card-body">
                <form method="POST" action="{{ route('mis.accounts.store') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3">
                            <p class="config-label"><b>Software Start Date</b></p>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Select a date</label>
                                <input type="date" name="software_start_date" class="form-control" value="{{ $configuration->software_start_date }}" disabled>
                            </div>
                        </div>
                    </div>

                    <br><br><br>
                    <div class="row">
                        <div class="col-md-3">
                            <p class="config-label"><b>Hotel</b></p>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Receipt Account</label>
                                <input type="hidden" name="data[{{ $type[0]->id }}][debit_head_id]" value="{{ $type[0]->debit_head_id }}">
                                <select class="form-control" name="data[{{ $type[0]->id }}][credit_head_id]">
                                    @foreach( $theads as $thead )
                                        <option value="{{ $thead->id }}" {!! $thead->id == $type[0]->credit_head_id ? 'selected="selected"' : '' !!}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <p class="config-label"><b>Training center</b></p>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Receipt Account</label>
                                <input type="hidden" name="data[{{ $type[1]->id }}][debit_head_id]" value="{{ $type[1]->debit_head_id }}">
                                <select class="form-control" name="data[{{ $type[1]->id }}][credit_head_id]">
                                    @foreach( $theads as $thead )
                                        <option value="{{ $thead->id }}" {!! $thead->id == $type[1]->credit_head_id ? 'selected="selected"' : '' !!}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <p class="config-label"><b>Restaurant</b></p>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Receipt Account</label>
                                        <input type="hidden" name="data[{{ $type[2]->id }}][credit_head_id]" value="{{ $type[2]->credit_head_id }}">
                                        <select class="form-control" name="data[{{ $type[2]->id }}][debit_head_id]">
                                            @foreach( $theads as $thead )
                                                <option value="{{ $thead->id }}" {!! $thead->id == $type[2]->debit_head_id ? 'selected="selected"' : '' !!}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Payment Account</label>
                                        <input type="hidden" name="data[{{ $type[3]->id }}][debit_head_id]" value="{{ $type[3]->debit_head_id }}">
                                        <select class="form-control" name="data[{{ $type[3]->id }}][credit_head_id]">
                                            @foreach( $theads as $thead )
                                                <option value="{{ $thead->id }}" {!! $thead->id == $type[3]->credit_head_id ? 'selected="selected"' : '' !!}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <p class="config-label"><b>Inventory</b></p>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Payment Account</label>
                                <input type="hidden" name="data[{{ $type[4]->id }}][credit_head_id]" value="{{ $type[4]->credit_head_id }}">
                                <select class="form-control" name="data[{{ $type[4]->id }}][debit_head_id]">
                                    @foreach( $theads as $thead )
                                        <option value="{{ $thead->id }}" {!! $thead->id == $type[4]->debit_head_id ? 'selected="selected"' : '' !!}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
