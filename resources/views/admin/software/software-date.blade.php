@extends('admin.master')


@section('content')
    <div class="col-md-6 text-left">
        <div class="card">
            <div class="card-header">
                Software date
            </div>

            <div class="card-body">
                <form action="{{route('configuration.software.date')}}" method="POST">
                    @csrf

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Select a date</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="software_date" value="{{old('software_date', $configuration->date)}}">
                        </div>
                    </div>

                    <div class="text-right" style="font-size: .8rem;">
                        Software Start date:
                        @if($configuration->software_start_date)
                            {{date('d-m-Y', strtotime($configuration->software_start_date))}}
                        @endif

                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
