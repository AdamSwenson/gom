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

        <div id="chart_div" style="width: 900px; height: 500px;">
        </div>
    </div>
    @include('errors.list')

@endsection


@section('jsArea')

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        var questionScores = <?= json_encode( $questionScores ) ?>;
        var meanScores = <?= json_encode( $meanScores ) ?>;
        var stdDeviations = <?= json_encode( $stdDeviations ) ?>;
        var questionDataSets = [];
        var boxPlotData = [];
        function DataSet () {
            this.min = 0;
            this.max = 30;
            this.second = 0;
            this.third = 0;
            this.median = 0;
            this.mean = 0;
        }

        calculateDataSets();

        function calculateDataSets(){
            questionDataSets = [];

            questionScores.forEach( function(scores, i) {
                scores.sort(function(a, b){return a-b});

                var num = scores.length;
                var dataSet = new DataSet();
                dataSet.min = scores[0];
                dataSet.max = scores[num-1];
                dataSet.second = scores[parseInt(num / 4)];
                dataSet.third = scores[parseInt(num * 3/4)];
                var mid = parseInt( num / 2) - 1;
                dataSet.median = scores[mid];
                if ( num % 2 ) {
                   dataSet.median = (scores[parseInt(mid)] + scores[mid + 1]) / 2;
                }
                dataSet.mean = parseFloat(meanScores[i+1].toFixed(2));
                questionDataSets[i] = dataSet;
            });
        }

        // set 'Reports' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navReport').attr('class', 'active');

        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawCharts);

        function drawCharts() {
            drawBoxPlots();
        }

        function drawBoxPlots() {

            boxPlotData = [];
            questionDataSets.forEach( function(dataSet, i) {
                // Create and populate the data table. Column 6: median, Column 7: mean.
                boxPlotData.push(['Question '+ (i+1), dataSet.min, dataSet.second, dataSet.third, dataSet.max, dataSet.median,
                    dataSet.mean]);
            });

            var data = google.visualization.arrayToDataTable( boxPlotData , true);
            console.log(boxPlotData);
            // Create and draw the visualization.
            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, {
                title: 'Plot of Question Scores with Quartiles and Means',
                width: 800,
                height: 500,
                vAxis: {title: "Score"},
                hAxis: {title: "Question"},
                legend: { position: 'none' },
                series: {
                    0: {type: "candlesticks"},
                    1: { type: "line", pointSize: 10, lineWidth: 0 },
                    2: {type: "line", pointSize: 10, lineWidth: 0, color: 'black'}
                }
            });
        }
    </script>

@endsection


