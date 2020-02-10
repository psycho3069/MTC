@extends('admin.master')

@section('content')
    <div class="container">
        <style>
            .item.row-eq-height.col-md-5 {
                margin-top: 35px;
            }
        </style>

        {{-- <p>{{ Auth::user()->name }}, You are logged in!</p> --}}

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- 1st row --}}

                        <div class="row">
                            <div class="item row-eq-height col-md-1"></div>
                            <div class="item row-eq-height col-md-5">
                                <div class="row">
                                    <div class="info-box-icon bg-aqua col-md-3">
                                        <span class=""><i class="fa fa-users"></i></span>
                                    </div>
                                    <div class="info-box-content col-md-6">
                                        <p>Employees</p>
                                        <p id="employees">{{ $employees_total }}</p>
                                        <p><a href="{{ URL::to('hr_payroll/employee/add_employee') }}">Add New</a></p>
                                    </div>
                                </div>
                            </div>

                            <div class="item row-eq-height col-md-5">
                                <div class="row">
                                    <div class="info-box-icon bg-red col-md-3">
                                        <span class=""><i class="fa fa-bed"></i></span>
                                    </div>
                                    <div class="info-box-content col-md-6">
                                        <p>Leave Application</p>
                                        <p id="lvapp">{{ $leaves }}</p>
                                        <p><a href="{{ URL::to('hr_payroll/leave/leaves') }}">View All</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="item row-eq-height col-md-1"></div>

                            <br>
                            <br>
                            <div class="item row-eq-height col-md-1 mt-5"></div>
                            <div class="item row-eq-height col-md-5">
                                <div id="piechart1" style="width: 300px; height: 200px;"></div>
                            </div>
                            <div class="item row-eq-height col-md-5">
                                <div id="chart_div" style="width: 400px; height: 300px;"></div>
                            </div>
                            <div class="item row-eq-height col-md-1"></div>

                        </div>

                        {{-- 2nd row --}}

                        <div class="row" style="margin-top: 50px;">

                            <div class="item row-eq-height col-md-6">
                                <div id="top_x_div" style="width: 400px; height: 300px;"></div>
                            </div>

                            <div class="item row-eq-height col-md-6">
                                <div id="top_x_div2" style="width: 400px; height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customscript')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    {{-- pie chart --}}
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Space', 'Available'],
                ['Room Available',     {{ $data['room']['available'] }}],
                ['Room Booked',    {{ $data['room']['booked'] }}],
                ['Venue Available',     {{ $data['venue']['available'] }}],
                ['Venue Booked',    {{ $data['venue']['booked'] }}]
            ]);

            var options = {
                title: 'Room Booking Status'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

            chart.draw(data, options);
        }
    </script>

    {{-- bar chart --}}
    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Opening Move', 'Quantity'],
                    @foreach($ledger_heads as $ledger_head)
                    @if( $ledger_head->mis_head_id == 4)
                ["{{ $ledger_head->name }}", {{ $ledger_head->currentStock->sum('quantity_dr') - $ledger_head->currentStock->sum('quantity_cr') }}]
                @endif
                @endforeach
            ]);

            var options = {
                title: 'Salary Breakdown by Department',
                width: 400,
                legend: { position: 'none' },
                chart: { title: 'Grocery Status',
                    //subtitle: 'popularity by percentage'
                },
                bars: 'horizontal', // Required for Material Bar Charts.
                axes: {
                    x: {
                        0: { side: 'top', label: 'Quantity'} // Top x-axis.
                    }
                },
                bar: { groupWidth: "90%" }
            };

            var chart = new google.charts.Bar(document.getElementById('top_x_div'));
            chart.draw(data, options);
        };
    </script>
    {{-- bar chart --}}
    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Opening Move', 'Quantity'],
                    @foreach($ledger_heads as $ledger_head )
                    @if( $ledger_head->mis_head_id == 5)
                ["{{ $ledger_head->name }}", {{ $ledger_head->currentStock->sum('quantity_dr') - $ledger_head->currentStock->sum('quantity_cr') }}],
                @endif
                @endforeach
            ]);

            var options = {
                title: 'Salary Breakdown by Department',
                width: 400,
                legend: { position: 'none' },
                chart: { title: 'Inventory Status',
                    //subtitle: 'popularity by percentage'
                },
                bars: 'horizontal', // Required for Material Bar Charts.
                axes: {
                    x: {
                        0: { side: 'top', label: 'Quantity'} // Top x-axis.
                    }
                },
                bar: { groupWidth: "90%" }
            };

            var chart = new google.charts.Bar(document.getElementById('top_x_div2'));
            chart.draw(data, options);
        };
    </script>

    {{-- column chart --}}
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {

            var button = document.getElementById('change-chart');
            var chartDiv = document.getElementById('chart_div');

            var data = google.visualization.arrayToDataTable([
                ['Galaxy', 'Department', 'Employee'],
                    @foreach($departments as $department)
                ['Departments Employee', {{ $department->id }}, {{ $employees }}],
                @endforeach
            ]);

            var materialOptions = {
                width: 400,
                chart: {
                    title: 'Department Wise Employee',
                    //subtitle: 'distance on the left, brightness on the right'
                },
                series: {
                    0: { axis: 'Department' }, // Bind series 0 to an axis named 'distance'.
                    1: { axis: 'Employee' } // Bind series 1 to an axis named 'brightness'.
                },
                axes: {
                    y: {
                        distance: {label: 'parsecs'}, // Left y-axis.
                        brightness: {side: 'right', label: 'apparent magnitude'} // Right y-axis.
                    }
                }
            };

            var classicOptions = {
                width: 400,
                series: {
                    0: {targetAxisIndex: 0},
                    1: {targetAxisIndex: 1}
                },
                title: 'Nearby galaxies - distance on the left, brightness on the right',
                vAxes: {
                    // Adds titles to each axis.
                    0: {title: 'parsecs'},
                    1: {title: 'apparent magnitude'}
                }
            };

            function drawMaterialChart() {
                var materialChart = new google.charts.Bar(chartDiv);
                materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
                button.innerText = 'Change to Classic';
                button.onclick = drawClassicChart;
            }

            function drawClassicChart() {
                var classicChart = new google.visualization.ColumnChart(chartDiv);
                classicChart.draw(data, classicOptions);
                button.innerText = 'Change to Material';
                button.onclick = drawMaterialChart;
            }

            drawMaterialChart();
        };
    </script>


@endsection
