<!DOCTYPE html>
<html>
    <head>
        <title>MTC Bill</title>
        <style>
            table.view {
                width: 700px;
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
                padding-right: 25px;
            }
            .date {
                float: right;
                margin: 60px 10px 10px 10px;
            }
        </style>
    </head>

    <body>

    <div class="date">
        <?php $date = Date('d-M-Y'); echo $date;  ?>
    </div>
    <table class="heading" style="border: 0; margin-bottom: 30px;">
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
    <table class="view" border="1">
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
            <td colspan="5" class="subt a">Sub Total-1</td>
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
            <td colspan="5" class="subt a">Sub Total-2</td>
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

        <div class="row1" style="margin-left: -480px; margin-top: 100px;">
            <center>
                <hr style="width: 210px;">
                <p><b>Prepared By</b></p>
                <p>Abul Kalam Aazad</p>
                <p>Sr. Accounts</p>
            </center>
        </div>
        <div class="row2"style="margin-left: 480px; margin-top: -130px;">
            <center>
                <hr style="width: 210px;">
                <p><b>Authorised By</b></p>
                <p>Noor Mohammad Shoron</p>
                <p>In-Charge</p>
            </center>
        </div>

        <div class="note" style="border: 1px solid #000;">
            <p style="font-size: 13px; text-align: center;">NB: Please Pay your By on line/DD/Account Pay Check only to Bank Details <br>
             Bank Details: CA A/C No: 200006064,Accounts Name: ASPADA Training Academy, Routing Number: 200611549 Sonali <br>
             Bank Limited, Matsha Gabeshona Institute Branch, Mymensingh.</p>
        </div>
    </body>
</html>
