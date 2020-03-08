@extends('admin.master')

@section('header_styles')
    <link href="{{asset('css/datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/flatpickr.min.css')}}" rel="stylesheet">
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">ADD VENUE BOOK</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a href="{{URL::to('/training/venueRes')}}" class="btn btn-primary">BACK</a>
                    </div>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger" style="padding: 0 30px 0 30px;">
                            Upload Validation Error<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif

                                <!--form-->

                        <form class="" action="{{ url('/training/store_booking') }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
                            @csrf
                            <input type="hidden" name="mis_ac_head_id" value="2">

                            <p class="alert-success" style="font-size: 20px; color: white; background:#149278; padding: 0 30px 0 30px;">
                                @php
                                $message=Session::get('message');
                                if($message) {
                                echo $message;
                                Session::put('message',null);
                                }
                                @endphp

                            </p>

                            <div class="form-group row">
                                <label for="start_date" class="col-md-4 col-form-label text-md-left">Start Date:</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="check_in_date" name="start_date" value="{{ $reservationInfo->start_date }}" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="end_date" class="col-md-4 col-form-label text-md-left">End Date:</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="check_out_date" value="{{ $reservationInfo->end_date }}" name="end_date" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-left">Person/Organization Name:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name" value="{{ $reservationInfo->name }}" name="name" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contact_no" class="col-md-4 col-form-label text-md-left">Contact No:</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="contact_no" value="{{ $reservationInfo->contact_no }}" name="contact_no" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="venue_id" class="col-md-4 col-form-label text-md-left">Venue:</label>
                                <div class="col-md-6">
                                    <select id="venue_id" name="venue_id" class="form-control dynamic" data-dependent="actual_price" required>
                                        @foreach($allvenueinfo as $row)
                                            @if($reservationInfo->venue_id == $row->id)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="actual_price" class="col-md-4 col-form-label text-md-left">Actual Price:</label>
                                <div class="col-md-6">
                                    @foreach($allvenueinfo as $row)
                                        @if($row->id == $reservationInfo->venue_id)
                                            @php
                                            $actual_price = $row->price;
                                            echo '<input type="text" name="actual_price" value="'.$actual_price.'" id="actual_price" class="form-control" readonly>';
                                            @endphp
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="no_of_attendee" class="col-md-4 col-form-label text-md-left">No. of Attendee:</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="no_of_attendee" value="{{ $reservationInfo->no_of_attendee }}" name="no_of_attendee" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label text-md-left">Status:</label>
                                <div class="col-md-6">
                                    <select id="status" name="status" class="form-control" required>
                                        <option value>--Choose One--</option>
                                        <option value="1">{{Config::get('constants.roomBookStatus.1')}}</option>
                                        <option value="2">{{Config::get('constants.roomBookStatus.2')}}</option>
                                        <option value="3">{{Config::get('constants.roomBookStatus.3')}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-left">Amount:</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="amount" value="0" name="amount">
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" >ADD</button>
                                <button type="reset" class="btn btn-danger" >RESET</button>
                            </div>

                        </form>


                </div>
            </div>
        </div>
    </div>
@endsection

@section('customscript')
    <script src="{{asset('js/flatpickr.min.js')}}"></script>
    <script src="{{asset('js/custom_datepicker.js')}}"></script>

    <script>
        $(document).ready(function(){

            $('.dynamic').change(function(){
                if($(this).val() != '')
                {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent = $(this).data('dependent');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('dynamicdependent.fetch') }}",
                        method:"GET",
                        data:{select:select, value:value, _token:_token, dependent:dependent},
                        success:function(result)
                        {
                            $('#'+dependent).val(result);
                        }

                    })
                }
            });


            $('#venue_id').change(function(){
                $('#actual_price').val('');
            });


        });
    </script>
@endsection