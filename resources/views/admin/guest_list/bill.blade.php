@extends('admin.master')

@section('content')

    <style>
        table.view {
            width: 900px;
            text-align: center;
        }
        th {
            text-align: center;
            padding: 5px;
            border: 1px solid;
        }
        .view td {
            padding: 10px 5px;
            border: 1px solid;
        }
        th#date {
            width: 115px;
            padding: 0px;
        }
        td.subt {
            padding: 2px;
            font-weight: 700;
        }
        td.subt.a {
            text-align: right;
        }
        .heading td {
            padding: 2px 35px;
        }

        div#border {
            border: 1px solid;
            margin-top: 70px;
            width: 210px;
        }
        .date {
            float: right;
            margin: 60px 109px 10px 10px;
        }
        .container {
            background: #fff;
        }
        a.btn.btn-success {
            margin-top: 20px;
        }
    </style>


    <div class="container">
        <a href="{{ URL::to('generate-pdf/'.$viewBill->id) }}" class="btn btn-success" style="margin-left: 105px; margin-bottom: 25px;">Download</a>

        <div class="date">
            <?php $date = Date('d-M-Y'); echo $date;  ?>
        </div>
        <table class="heading" style="border: 0; margin-left: 70px;">
            <tr>
                <td>Bill To:</td>
                <td>{{ $viewBill->name }}</td>
            </tr>
            <tr>
                <td>Address:</td>
                <td></td>
            </tr>
            <tr>
                <td>Programme:</td>
                <td></td>
            </tr>
        </table>

        <p class="alert-success" style="font-size: 20px; color: white; background:#149278; padding: 0 30px 0 30px;">
            @php
            $message=Session::get('message');
            if($message) {
            echo $message;
            Session::put('message',null);
            }
            @endphp
        </p>
        <div class="row justify-content-center">

            <table class="view" border="2">
                <tr>
                    <th colspan="2" id="date">Date</th>
                    <th rowspan="2" id="description">Description</th>
                    <th rowspan="2"  id="quantity">Day/ Unit</th>
                    <th rowspan="2"  id="price">Unit Price</th>
                    <th rowspan="2"  id="amount">Amount (TK.)</th>
                </tr>
                <tr>
                    <th id="date">Form</th>
                    <th id="date">To</th>
                </tr>
                <tr>
                    <td>{{date("d M Y", strtotime($viewBill->v_start_date))}}</td>
                    <td>{{date("d M Y", strtotime($viewBill->v_end_date))}}</td>
                    <td>{{ $viewBill->venue_no }}</td>
                    <td>{{ $viewBill->v_total_day }}</td>
                    <td>{{ $viewBill->v_unit_price }}</td>
                    <td>{{ $viewBill->v_total_bill }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="subt a">Sub Total =</td>
                    <td class="subt">{{ $viewBill->v_total_bill }}</td>
                </tr>
                <tr>
                    <td>{{ $viewBill->v_start_date }}</td>
                    <td>{{ $viewBill->v_end_date }}</td>
                    <td>Room No. {{ $viewBill->room_no }}</td>
                    <td>{{ $viewBill->h_total_day }}</td>
                    <td>{{ $viewBill->room_unit_price }}</td>
                    <td>{{ $viewBill->h_total_bill }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="subt a">Sub Total =</td>
                    <td class="subt">{{ $viewBill->h_total_bill }}</td>
                </tr>
                <tr>
                    <td colspan="5">Total Food Bill </td>
                    <td>{{ $viewBill->r_total_bill }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="subt a">Total Bill =</td>
                    <td class="subt">{{ $viewBill->all_total }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="subt a">Discount =</td>
                    <td class="subt">{{ $viewBill->discount }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="subt a">Grand Total Amount TK =</td>
                    <td class="subt">{{ $viewBill->grand_total }}</td>
                </tr>
            </table>
        </div>

        <center>
        <div class="row">
                <div class="col-md-6">
                    <div id="border"></div>
                    <p><b>Prepared By</b></p>
                    <p>Abul Kalam Aazad</p>
                    <p>Sr. Accounts</p>
                </div>
                <div class="col-md-6">
                    <div id="border"></div>
                    <p><b>Authorised By</b></p>
                    <p>Noor Mohammad Shoron</p>
                    <p>In-Charge</p>
                </div>

        </div>
        </center>

        <div class="note" style="border: 1px solid #000; width: 900px; margin: 10px auto;">
            <p style="font-size: 13px; text-align: center;">NB: Please Pay your By on line/DD/Account Pay Check only to Bank Details <br>
                Bank Details: CA A/C No: 200006064,Accounts Name: ASPADA Training Academy, Routing Number: 200611549 Sonali <br>
                Bank Limited, Matsha Gabeshona Institute Branch, Mymensingh.</p>
        </div>
    </div>

    @endsection

    @section('datatable')

            <!-- datatable -->
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#bill').DataTable();
        } );
    </script>
@endsection