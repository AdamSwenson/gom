<!-- Analytics page holds visualizations for student performance -->
@extends('layouts.master')

@section('pageTitle', 'Analytics | gradeomatic')
@section('description', 'View information about the exam')

@section('cssLinks')
@endsection

@section('body')

    <div class="container">

        <h3><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Analytics: {{ $exam->getTerm() }}
            {{ $exam->getYear() }} "{{ $exam->getName() }}"</h3>

            <div class="chart_div" style="width: 900px; height: 500px;">
            </div>
    </div>
    @include('errors.list')

@endsection


@section('jsArea')

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">


        // set 'Reports' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navReport').attr('class', 'active');

        google.load("visualization", "1", {packages: ['corechart']});
        google.setOnLoadCallback(drawCharts);


        function drawCharts() {

            var data = google.visualization.arrayToDataTable([
                ['Mon', 20, 28, 38, 45],
                ['Tue', 31, 38, 55, 66],
                ['Wed', 50, 55, 77, 80],
                ['Thu', 77, 77, 66, 50],
                ['Fri', 68, 66, 22, 15]
                // Treat first row as data as well.
            ], true);

            var options = {
                legend: 'none'
            };

            var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div'));

            chart.draw(data, options);
            // Create and populate the data table. Column 6: median, Column 7: mean. Values are
            // invented!
            /*
             var data = google.visualization.arrayToDataTable([

             ['Serie1', 20, 28, 38, 45, 20, 25],
             ['Serie2', 31, 38, 55, 66, 30, 35],
             ['Serie3', 50, 55, 77, 80, 10, 15],
             ['Serie4', 77, 77, 66, 50, 20, 25],
             ['Serie5', 68, 66, 22, 15, 30, 35]
             // Treat first row as data as well.
             ], true);

             // Create and draw the visualization.
             var chart = new google.visualization.ComboChart(document.getElementById('boxChart'));
             chart.draw(data, {
             title : 'Box Plot with Median and Average',
             width: 600,
             height: 400,
             vAxis: {title: "Value"},
             hAxis: {title: "Series ID"},
             series: { 0: {type: "candlesticks"}, 1: {type: "line", pointSize: 10, lineWidth:
             0 }, 2: {type: "line", pointSize: 10, lineWidth: 0, color: 'black' } }
             });
             */
        }
    </script>

@endsection


