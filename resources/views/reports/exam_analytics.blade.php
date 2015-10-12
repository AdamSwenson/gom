<!-- Analytics page holds visualizations for student performance -->
@extends('layouts.master')

@section('pageTitle', 'Analytics | gradeomatic')
@section('description', 'View information about the exam')

@section('cssLinks')
@endsection

@section('body')
    <style>
        a {
            cursor: pointer;
        }

        .chart {
            max-width: 700px;
            max-height: 500px;
        }
    </style>

    <h3><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Analytics: {{ $exam->getTerm() }}
        {{ $exam->getYear() }} "{{ $exam->getName() }}"</h3>

    <div class="chart" id="chart_div">
    </div>
    <p style="width: 800px; text-align: center;"><a onclick="howToReadBoxPlot();">How to read this chart</a></p>

@endsection


@section('jsArea')

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        var questionScores = <?= json_encode( $questionScores ) ?>;
        var questionDataSets = [];
        var boxPlotData = [];
        function DataSet() {
            this.min = 0;
            this.max = 30;
            this.second = 0;
            this.third = 0;
            this.median = 0;
            this.mean = 0;
        }

        calculateDataSets();

        function calculateDataSets() {
            questionDataSets = [];

            questionScores.forEach(function (scores, i) {
                scores.sort(function (a, b) {
                    return a - b
                });
                var num = scores.length;
                var sum = 0;

                scores.forEach(function (score) {
                    sum += score;
                });

                var dataSet = new DataSet();
                dataSet.min = scores[0];
                dataSet.max = scores[num - 1];
                dataSet.second = scores[parseInt(num / 4)];
                dataSet.third = scores[parseInt(num * 3 / 4)];
                var mid = parseInt(num / 2) - 1;
                dataSet.median = scores[mid];
                if (num % 2) {
                    dataSet.median = (scores[parseInt(mid)] + scores[mid + 1]) / 2;
                }
                dataSet.mean = parseFloat((sum / num).toFixed(2));
                questionDataSets[i] = dataSet;
            });
        }

        // set 'Reports' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navReport').attr('class', 'active');

        google.load("visualization", "1", {packages: ["corechart"]});
        google.setOnLoadCallback(drawCharts);

        function drawCharts() {
            drawBoxPlots();
        }

        function drawBoxPlots() {

            boxPlotData = [];
            questionDataSets.forEach(function (dataSet, i) {
                // Create and populate the data table. Column 6: median, Column 7: mean.
                boxPlotData.push(['Question ' + (i + 1), dataSet.min, dataSet.second, dataSet.third, dataSet.max, dataSet.median,
                    dataSet.mean]);
            });

            var data = google.visualization.arrayToDataTable(boxPlotData, true);
            console.log(boxPlotData);
            // Create and draw the visualization.
            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, {
                title: 'Box Plot of Question Scores with Quartiles and Means',
                width: 800,
                height: 500,
                vAxis: {title: "Score"},
                hAxis: {title: "Question Number"},
                legend: {
                    position: 'right',
                    textStyle: {
                        color: 'black',
                        fontSize: 16
                    }
                },
                series: {
                    0: {type: "candlesticks", labelInLegend: 'Q2-Q3'},
                    1: {type: "line", labelInLegend: 'median', pointSize: 10, lineWidth: 0},
                    2: {type: "line", labelInLegend: 'mean', pointSize: 10, lineWidth: 0, color: 'black'}
                }
            });
        }

        function howToReadBoxPlot() {
            showMessage('<p style="text-align: justify;">How to Read - Box Plot', 'In this graph, each set of question scores is represented by a box with lines. ' +
                    'The bottom line indicates the lowest quartile (25%) of scores, while the box ' +
                    'displays the second and third quartiles (25%-75%). The top line shows the range of the top ' +
                    '25% of scores. Additional dots show the mean and median score for the question.</p>');
        }

        function showMessage(title, msg) {
            msg = msg;
            bootbox.dialog({
                message: msg,
                title: title,
                buttons: {
                    default: {
                        label: 'Ok',
                        className: "btn-sm",
                        callback: function () {
                        }
                    }
                }
            });
        }
    </script>

@endsection


