@extends('admin.master')

@section('content')
    <style>
        .required{
            color: #ff0000;
        }
    </style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"> <big> <strong>ADD NEW MENU</strong> </big> </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{URL::to('/restaurant/menu/menus')}}" class="btn btn-primary">BACK</a>
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
              <form class="" action="{{ url('/save_menu') }}" method="post" enctype="multipart/form-data" autocomplete="off" style="padding: 0 30px 0 30px;">
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

                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <label for="name" class="col-form-label text-md-left font-weight-bold">Menu Name: <span class="required">*</span></label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <label for="menu_type_id" class="col-form-label text-md-left font-weight-bold">Menu Type: <span class="required">*</span></label>
                        </div>
                        <div class="col-md-10">
                            <select id="menu_type_id" name="menu_type_id" class="form-control" required>
                                <option value>--Choose One--</option>
                                @foreach($menu_type_info as $menu_type)
                                    <option value="{{ $menu_type->id }}">{{ $menu_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                                {{-- current --}}
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="item_1_id" class="col-md-4 text-md-left font-weight-bold">Item 1 Name:</label>
                        <div class="col-md-5">
                            <select id="item_1_id" name="item_1_id" class="form-control dynamic" data-dependent="actual_price1" >
                                <option value>--Choose One--</option>
                                @foreach($meal_item_info as $meal_item)
                                    <option value="{{ $meal_item->id }}">{{ $meal_item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input class="form-control col-md-3" type="number" id="actual_price1" value="" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="item_1_quantity" class="col-md-4 text-md-right font-weight-bold">Item 1 Quantity:</label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" id="item_1_quantity" name="item_1_quantity">
                        </div>
                        <input class="form-control col-md-3" type="number" id="total1" value="0" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="item_2_id" class="col-md-4 text-md-left font-weight-bold">Item 2 Name:</label>
                        <div class="col-md-5">
                            <select id="item_2_id" name="item_2_id" class="form-control dynamic" data-dependent="actual_price2" >
                                <option value>--Choose One--</option>
                                @foreach($meal_item_info as $meal_item)
                                    <option value="{{ $meal_item->id }}">{{ $meal_item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input class="form-control col-md-3" type="number" id="actual_price2" value="" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="item_2_quantity" class="col-md-4 text-md-right font-weight-bold">Item 2 Quantity:</label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" id="item_2_quantity" name="item_2_quantity">
                        </div>
                        <input class="form-control col-md-3" type="number" id="total2" value="0" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="item_3_id" class="col-md-4 text-md-left font-weight-bold">Item 3 Name:</label>
                        <div class="col-md-5">
                            <select id="item_3_id" name="item_3_id" class="form-control dynamic" data-dependent="actual_price3">
                                <option value>--Choose One--</option>
                                @foreach($meal_item_info as $meal_item)
                                    <option value="{{ $meal_item->id }}">{{ $meal_item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input class="form-control col-md-3" type="number" id="actual_price3" value="" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="item_3_quantity" class="col-md-4 col-form-label text-md-right font-weight-bold">Item 3 Quantity:</label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" id="item_3_quantity" name="item_3_quantity">
                        </div>
                        <input class="form-control col-md-3" type="number" id="total3" value="0" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="item_4_id" class="col-md-4 text-md-left font-weight-bold">Item 4 Name:</label>
                        <div class="col-md-5">
                            <select id="item_4_id" name="item_4_id" class="form-control dynamic" data-dependent="actual_price4" >
                                <option value>--Choose One--</option>
                                @foreach($meal_item_info as $meal_item)
                                    <option value="{{ $meal_item->id }}">{{ $meal_item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input class="form-control col-md-3" type="number" id="actual_price4" value="" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="item_4_quantity" class="col-md-4 col-form-label text-md-right font-weight-bold">Item 4 Quantity:</label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" id="item_4_quantity" name="item_4_quantity">
                        </div>
                        <input class="form-control col-md-3" type="number" id="total4" value="0" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="item_5_id" class="col-md-4 text-md-left font-weight-bold">Item 5 Name:</label>
                        <div class="col-md-5">
                            <select id="item_5_id" name="item_5_id" class="form-control dynamic" data-dependent="actual_price5" >
                                <option value>--Choose One--</option>
                                @foreach($meal_item_info as $meal_item)
                                    <option value="{{ $meal_item->id }}">{{ $meal_item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input class="form-control col-md-3" type="number" id="actual_price5" value="" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="item_5_quantity" class="col-md-4 col-form-label text-md-right font-weight-bold">Item 5 Quantity:</label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" id="item_5_quantity" name="item_5_quantity">
                        </div>
                        <input class="form-control col-md-3" type="number" id="total5" value="0" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="item_6_id" class="col-md-4 col-form-label text-md-left font-weight-bold">Item 6 Name:</label>
                        <div class="col-md-5">
                            <select id="item_6_id" name="item_6_id" class="form-control dynamic" data-dependent="actual_price6" >
                                <option value>--Choose One--</option>
                                @foreach($meal_item_info as $meal_item)
                                    <option value="{{ $meal_item->id }}">{{ $meal_item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input class="form-control col-md-3" type="number" id="actual_price6" value="" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="item_6_quantity" class="col-md-4 col-form-label text-md-right font-weight-bold">Item 6 Quantity:</label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" id="item_6_quantity" name="item_6_quantity">
                        </div>
                        <input class="form-control col-md-3" type="number" id="total6" value="0" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="item_7_id" class="col-md-4 col-form-label text-md-left font-weight-bold">Item 7 Name:</label>
                        <div class="col-md-5">
                            <select id="item_7_id" name="item_7_id" class="form-control dynamic" data-dependent="actual_price7" >
                                <option value>--Choose One--</option>
                                @foreach($meal_item_info as $meal_item)
                                    <option value="{{ $meal_item->id }}">{{ $meal_item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input class="form-control col-md-3" type="number" id="actual_price7" value="" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="item_7_quantity" class="col-md-4 col-form-label text-md-right font-weight-bold">Item 7 Quantity:</label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" id="item_7_quantity" name="item_7_quantity">
                        </div>
                        <input class="form-control col-md-3" type="number" id="total7" value="0" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="item_8_id" class="col-md-4 col-form-label text-md-left font-weight-bold">Item 8 Name:</label>
                        <div class="col-md-5">
                            <select id="item_8_id" name="item_8_id" class="form-control dynamic" data-dependent="actual_price8" >
                                <option value>--Choose One--</option>
                                @foreach($meal_item_info as $meal_item)
                                    <option value="{{ $meal_item->id }}">{{ $meal_item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input class="form-control col-md-3" type="number" id="actual_price8" value="" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="item_8_quantity" class="col-md-4 col-form-label text-md-right font-weight-bold">Item 8 Quantity:</label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" id="item_8_quantity" name="item_8_quantity">
                        </div>
                        <input class="form-control col-md-3" type="number" id="total8" value="0" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="item_9_id" class="col-md-4 col-form-label text-md-left font-weight-bold">Item 9 Name:</label>
                        <div class="col-md-5">
                            <select id="item_9_id" name="item_9_id" class="form-control dynamic" data-dependent="actual_price9" >
                                <option value>--Choose One--</option>
                                @foreach($meal_item_info as $meal_item)
                                    <option value="{{ $meal_item->id }}">{{ $meal_item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input class="form-control col-md-3" type="number" id="actual_price9" value="" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="item_9_quantity" class="col-md-4 col-form-label text-md-right font-weight-bold">Item 9 Quantity:</label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" id="item_9_quantity" name="item_9_quantity">
                        </div>
                        <input class="form-control col-md-3" type="number" id="total9" value="0" readonly>
                    </div>


                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="item_10_id" class="col-md-4 col-form-label text-md-left font-weight-bold">Item 10 Name:</label>
                        <div class="col-md-5">
                            <select id="item_10_id" name="item_10_id" class="form-control dynamic" data-dependent="actual_price10" >
                                <option value>--Choose One--</option>
                                @foreach($meal_item_info as $meal_item)
                                    <option value="{{ $meal_item->id }}">{{ $meal_item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input class="form-control col-md-3" type="number" id="actual_price10" value="" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="item_10_quantity" class="col-md-4 col-form-label text-md-left font-weight-bold">Item 10 Quantity:</label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" id="item_10_quantity" name="item_10_quantity">
                        </div>
                        <input class="form-control col-md-3" type="number" id="total10" value="0" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-3 text-md-right">
                        <label for="price" class="font-weight-bold">Menu Price: <span class="required">*</span></label>
                        <span href="#" class="btn btn-info " id="calculate">Calculate</span>
                    </div>
                    <div class="col-md-9">
                        <input type="number" class="form-control" id="price" name="price" required>
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

            /*
            $('#item_1_id').change(function(){
                $('#actual_price1').val('');
            });*/


        });

        $(document).on("change keyup blur", "#item_1_quantity", function() {
            var amd = $('#actual_price1').val();
            var disc = $('#item_1_quantity').val();
            if (disc != '' && amd != '') {
                $('#total1').val((parseInt(amd)) * (parseInt(disc)));
            }else{
                $('#total1').val(parseInt(amd));
            }
        });

        $(document).on("change keyup blur", "#item_2_quantity", function() {
            var amd = $('#actual_price2').val();
            var disc = $('#item_2_quantity').val();
            if (disc != '' && amd != '') {
                $('#total2').val((parseInt(amd)) * (parseInt(disc)));
            }else{
                $('#total2').val(parseInt(amd));
            }
        });

        $(document).on("change keyup blur", "#item_3_quantity", function() {
            var amd = $('#actual_price3').val();
            var disc = $('#item_3_quantity').val();
            if (disc != '' && amd != '') {
                $('#total3').val((parseInt(amd)) * (parseInt(disc)));
            }else{
                $('#total3').val(parseInt(amd));
            }
        });

        $(document).on("change keyup blur", "#item_4_quantity", function() {
            var amd = $('#actual_price4').val();
            var disc = $('#item_4_quantity').val();
            if (disc != '' && amd != '') {
                $('#total4').val((parseInt(amd)) * (parseInt(disc)));
            }else{
                $('#total4').val(parseInt(amd));
            }
        });

        $(document).on("change keyup blur", "#item_5_quantity", function() {
            var amd = $('#actual_price5').val();
            var disc = $('#item_5_quantity').val();
            if (disc != '' && amd != '') {
                $('#total5').val((parseInt(amd)) * (parseInt(disc)));
            }else{
                $('#total5').val(parseInt(amd));
            }
        });

        $(document).on("change keyup blur", "#item_6_quantity", function() {
            var amd = $('#actual_price6').val();
            var disc = $('#item_6_quantity').val();
            if (disc != '' && amd != '') {
                $('#total6').val((parseInt(amd)) * (parseInt(disc)));
            }else{
                $('#total6').val(parseInt(amd));
            }
        });

        $(document).on("change keyup blur", "#item_7_quantity", function() {
            var amd = $('#actual_price7').val();
            var disc = $('#item_7_quantity').val();
            if (disc != '' && amd != '') {
                $('#total7').val((parseInt(amd)) * (parseInt(disc)));
            }else{
                $('#total7').val(parseInt(amd));
            }
        });

        $(document).on("change keyup blur", "#item_8_quantity", function() {
            var amd = $('#actual_price8').val();
            var disc = $('#item_8_quantity').val();
            if (disc != '' && amd != '') {
                $('#total8').val((parseInt(amd)) * (parseInt(disc)));
            }else{
                $('#total8').val(parseInt(amd));
            }
        });

        $(document).on("change keyup blur", "#item_9_quantity", function() {
            var amd = $('#actual_price9').val();
            var disc = $('#item_9_quantity').val();
            if (disc != '' && amd != '') {
                $('#total9').val((parseInt(amd)) * (parseInt(disc)));
            }else{
                $('#total9').val(parseInt(amd));
            }
        });

        $(document).on("change keyup blur", "#item_10_quantity", function() {
            var amd = $('#actual_price10').val();
            var disc = $('#item_10_quantity').val();
            if (disc != '' && amd != '') {
                $('#total10').val((parseInt(amd)) * (parseInt(disc)));
            }else{
                $('#total10').val(parseInt(amd));
            }
        });



        $(document).on("click blur", "#calculate", function() {
            var total1 = $('#total1').val();
            var total2 = $('#total2').val();
            var total3 = $('#total3').val();
            var total4 = $('#total4').val();
            var total5 = $('#total5').val();
            var total6 = $('#total6').val();
            var total7 = $('#total7').val();
            var total8 = $('#total8').val();
            var total9 = $('#total9').val();
            var total10 = $('#total10').val();
                $('#price').val((parseInt(total1)) + (parseInt(total2)) + (parseInt(total3)) + (parseInt(total4)) + (parseInt(total5)) + (parseInt(total6)) + (parseInt(total7)) + (parseInt(total8)) + (parseInt(total9)) + (parseInt(total10)));
        });
    </script>
@endsection