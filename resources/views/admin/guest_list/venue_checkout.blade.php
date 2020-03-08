@extends('admin.master')

@section('header_styles')
    <link href="{{asset('css/datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/flatpickr.min.css')}}" rel="stylesheet">

    <style>

        .error_billing{
            color: #ff0000;
        }

        .error{
            color: #fff;
            opacity: 0;
            text-align: center;
        }


        #regForm {
            background-color: #ffffff;
            margin: 10px auto;
            font-family: Raleway;
            padding: 40px;
            width: 90%;
            min-width: 300px;
        }

        h1 {
            text-align: center;
        }

        input {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            font-family: Raleway;
            border: 1px solid #aaaaaa;
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

       /* button {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            font-family: Raleway;
            cursor: pointer;
        }*/

        button:hover {
            opacity: 0.8;
        }

        #prevBtn {
            background-color: #bbbbbb;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        .step.finish {
            background-color: #4CAF50;
        }
        input.credit {
            border: 0;
        }
        input {
            padding: 0;
            width: auto;
        }

    </style>

@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Guest Checkout</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a href="{{URL::to('/guest-list')}}" class="btn btn-primary btn-sm">BACK</a>
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

                    <form id="regForm" class="" action="{{ route('store_checkout') }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
                        @csrf

                        <p class="alert-success" style="font-size: 20px; color: white; background:#149278; padding: 0 30px 0 30px;">
                            @php
                            $message=Session::get('message');
                            if($message) {
                            echo $message;
                            Session::put('message',null);
                            }
                            @endphp

                        </p>

                        <?php
                            $tHotel_bill = 0;
                            $tVenue_bill = 0;
                        {?>
                        @foreach($room_bookings as $value)
                                @if($checkout_venue->room_booking_id == $value->id || ($value->venue_booking_id == $checkout_venue->id))
                                        <div class="tab">
                                            <h1 class="mb-5">Hotel Bill</h1>
                                            <input name="venue_booking_id" value="{{ $value->id }}" style="display: none; opacity: 0;">
                                            <div class="form-group row">
                                                <label for="start_date" class="col-md-4 col-form-label text-md-left">Date/Start Date:</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" id="check_in_date" name="h_start_date" value="{{ $value->start_date }}" autocomplete="off" required readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="end_date" class="col-md-4 col-form-label text-md-left">End Date:</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" id="check_out_date" value="{{ $value->end_date }}" name="h_end_date" autocomplete="off" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-md-4 col-form-label text-md-left">Name:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" value="{{ $value->guest_name }}" id="name" name="name" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="contact_no" class="col-md-4 col-form-label text-md-left">Contact No:</label>
                                                <div class="col-md-6">
                                                    <input type="number" class="form-control" id="contact_no" value="{{ $checkout_venue->contact_no }}" name="contact" required readonly>
                                                </div>
                                            </div>

                                            @foreach($rooms as $room)
                                                @if($room->id == $value->room_id)
                                                    <div class="form-group row">
                                                        <label for="room_no" class="col-md-4 col-form-label text-md-left">Room No:</label>
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" id="room_no" value="{{ $room->room_no }}" name="room_no" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="price" class="col-md-4 col-form-label text-md-left">Unit Price:</label>
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" id="price" value="{{ $room->price }}" name="room_unit_price" required readonly>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                            @foreach($hotel_bill as $bill)
                                                @if($bill->booking_id == $value->id)
                                                    <div class="form-group row">
                                                        <label for="day" class="col-md-4 col-form-label text-md-left">Total Day:</label>
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" id="day" value="{{ $bill->total_day }}" name="h_total_day" required readonly>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                            <div class="form-group row">
                                                <label for="contact_no" class="col-md-4 col-form-label text-md-left">Total Hotel Bill:</label>
                                                <div class="col-md-6">
                                                    @foreach($hotel_bill as $bill)
                                                        @if($bill->booking_id == $value->id)
                                                            <style>
                                                                .error_room_billing{
                                                                    display: none;
                                                                    opacity: 0;
                                                                    color: #fff;
                                                                }
                                                            </style>
                                                                <?php $tHotel_bill = $bill->total_pay; ?>
                                                        <input type="text" class="form-control" name="h_total_bill" value="{{ $bill->total_pay }}" readonly>
                                                        @endif
                                                    @endforeach
                                                        <p class="error_room_billing" style="color: #f00;"><b>Warning!</b> Room Billing is not Complete <a href="{{ URL::to('makebilling',$value->id) }}">Go for billings</a></p>
                                                </div>
                                            </div>
                                        </div>
                                @endif
                        @endforeach

                        <div class="tab">
                            @foreach($venue_bill as $bill)
                                @if($bill->venue_booking_id == $checkout_venue->id)
                                    <style>
                                        .error_billing{
                                            display: none;
                                            opacity: 0;
                                            color: #fff;
                                        }
                                    </style>
                                @endif
                            @endforeach
                            <h1 class="mb-5">Venue Bill</h1>
                                <input name="venue_booking_id" value="{{ $checkout_venue->id }}" style="display: none; opacity: 0;" >
                                <div class="form-group row">
                                    <label for="start_date" class="col-md-4 col-form-label text-md-left">Date/Start Date:</label>
                                    <div class="col-md-6">
                                        <input class="form-control" id="check_in_date" name="v_start_date" value="{{ $checkout_venue->start_date }}" autocomplete="off" required readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="end_date" class="col-md-4 col-form-label text-md-left">End Date:</label>
                                    <div class="col-md-6">
                                        <input class="form-control" id="check_out_date" value="{{ $checkout_venue->end_date }}" name="v_end_date" autocomplete="off" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-left">Name:</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="{{ $checkout_venue->name }}" id="name" name="name" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="contact_no" class="col-md-4 col-form-label text-md-left">Contact No:</label>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" id="contact_no" value="{{ $checkout_venue->contact_no }}" name="contact" required readonly>
                                    </div>
                                </div>

                                @foreach($venues as $venue)
                                    @if($venue->id == $checkout_venue->venue_id)
                                        <div class="form-group row">
                                            <label for="room_no" class="col-md-4 col-form-label text-md-left">Venue:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="room_no" value="{{ $venue->name }}" name="venue_no" required readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="price" class="col-md-4 col-form-label text-md-left">Unit Price:</label>
                                            <div class="col-md-6">
                                                <input type="number" class="form-control" id="price" value="{{ $venue->price }}" name="v_unit_price" required readonly>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach


                                @foreach($venue_bill as $bill)
                                    @if($bill->venue_booking_id == $checkout_venue->id)

                                        <div class="form-group row">
                                            <label for="day" class="col-md-4 col-form-label text-md-left">Total Day:</label>
                                            <div class="col-md-6">
                                                <input type="number" class="form-control" id="day" value="{{ $bill->total_day }}" name="v_total_day" required readonly>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                <div class="form-group row">
                                <label for="contact_no" class="col-md-4 col-form-label text-md-left">Total Venue Bill:</label>
                                <div class="col-md-6">
                                    @foreach($venue_bill as $bill)
                                        @if($bill->venue_booking_id == $checkout_venue->id)
                                            <?php $tVenue_bill = $bill->total_pay; ?>
                                            <input type="text" class="form-control" name="v_total_bill" value="{{ $tVenue_bill }}" readonly>
                                        @endif
                                    @endforeach
                                        <p class="error_billing"><b>Warning!</b> Venue Billing is not Complete <a href="{{ URL::to('training/makebilling',$checkout_venue->id) }}">Go for billings</a></p>
                                </div>
                            </div>
                        </div>

                        <div class="tab">
                            <h1 class="mb-5">Restaurant Bill</h1>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Food</th>
                                        <th>Menu Type</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($restaurant_bill as $bill)
                                        @foreach($menus as $menu)

                                        <?php
                                        $price = $menu->price;
                                        $quantity = $bill->quantity;
                                        $total = $price*$quantity;
                                        ?>
                                        @if($bill->guest_id == $checkout_venue->id  && $bill->menu_id == $menu->id  && $bill->booking_status == 2)
                                            <tr>
                                                <td>{{ $bill->created_at }}</td>
                                                <td>{{ $menu->name }}</td>
                                                <td>
                                                    @foreach($menuTypes as $type)
                                                        @if($bill->menu_type == $type->id )
                                                            {{ $type->name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $bill->quantity }}</td>
                                                <td>{{ $menu->price }}</td>
                                                <td><input class="credit" value="{{ $total }}" type="number" readonly></td>
                                            </tr>
                                        @endif

                                        @foreach($room_bookings as $value)
                                            @if($menu->id == $bill->menu_id)
                                                @if($checkout_venue->room_booking_id == $value->id && $bill->guest_id == $value->id  && $bill->booking_status == 1 || ($value->venue_booking_id == $checkout_venue->id && $bill->guest_id == $value->id  && $bill->booking_status == 1) )
                                                    <tr>
                                                        <td>{{ $bill->created_at }}</td>
                                                        <td>{{ $menu->name }}</td>
                                                        <td>
                                                            @foreach($menuTypes as $type)
                                                                @if($bill->menu_type == $type->id )
                                                                    {{ $type->name }}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>{{ $bill->quantity }}</td>
                                                        <td>{{ $menu->price }}</td>
                                                        <td><input class="credit" value="{{ $total }}" type="number" readonly></td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                <label for="calculateSum">Total Sum</label>
                                <input class="pull-right" type="number" name="r_total_bill" id="total-credit" readonly style="border: 0; margin-right: 33px;">
                        </div>

                        <div class="tab">
                            <?php
                             $all_total = $tHotel_bill+$tVenue_bill;
                            ?>
                            <div class="form-group row">
                                <label for="contact_no" class="col-md-4 col-form-label text-md-left">Total:</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="all" value="" name="all_total" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="contact_no" class="col-md-4 col-form-label text-md-left">Discount:</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="discount" value="0" name="discount">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="contact_no" class="col-md-4 col-form-label text-md-left">Grand Total Amount:</label>
                                <div class="col-md-6">
                                    <input type="number" min="0" class="form-control" id="grand_total" value="" name="grand_total" readonly>
                                </div>
                            </div>

                        </div>

                        <div style="overflow:auto;">
                            <div style="float:right;">
                                <button type="button" id="prevBtn" class="btn btn-warning" onclick="nextPrev(-1)">Previous</button>
                                <button type="button" id="nextBtn" class="btn btn-success" onclick="nextPrev(1)">Next</button>
                            </div>
                        </div>

                        <div style="text-align:center;margin-top:40px; display: none;">
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready( function() {
            total();

            function total() {
                var total_credit = 0;
                $('input.credit').each(function () {
                    if ( !isNaN(this.value) && this.value.length !=0 ){
                        total_credit += parseFloat(this.value);
                        cr_amount = total_credit;
                    }
                });
                $('#total-credit').val(total_credit.toFixed(2));
            }

            var stotal_credit = 0;
            $('input.credit').each(function () {
                if ( !isNaN(this.value) && this.value.length !=0 ){
                    stotal_credit += parseFloat(this.value);
                    cr_amount = stotal_credit;
                }
            });
            var all_total = <?php echo $all_total; ?>;
            var g_total = all_total+stotal_credit;
            $('#all').val(g_total);
            $('#grand_total').val(g_total);
        });

        $(document).on("change keyup blur", "#discount", function() {
            var amd = $('#all').val();
            var disc = $('#discount').val();
            if (disc != '' && amd != '') {
                $('#grand_total').val((parseInt(amd)) - (parseInt(disc)));
            }else{
                $('#grand_total').val(parseInt(amd));
            }
        });
    </script>

    <?php }?>
@endsection

@section('customscript')
    <script src="{{asset('js/flatpickr.min.js')}}"></script>
    <script src="{{asset('js/custom_datepicker.js')}}"></script>

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>

@endsection