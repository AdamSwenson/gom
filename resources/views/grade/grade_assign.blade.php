<!-- Analytics page holds visualizations for student performance -->
@extends('layouts.master')

@section('pageTitle', 'Assign Grades | gradeomatic')
@section('description', 'Assign letter grades for the exam')

@section('cssLinks')
@endsection

@section('body')
    <div class="container">

        @include('errors.list')

        <h3><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Assign Grades: {{ $exam->getTerm() }}
            {{ $exam->getYear() }} "{{ $exam->getName() }}"</h3>
        <h4>Enter the minimum exam grade for each letter assignment. Blank grades will not be used.</h4>
        <br/>

        <div class="row">
            <!-- Left column holds grade assignment regions -->
            <div class="col-lg-5">
                <form class="form-horizontal" method="post" role="form" name="frmGradeCutoffs"
                      action="{{ url('grade/exam/'.$exam->getId().'/assign') }}">
                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                    <!-- Grade Assignment fields. These will form into 2 columns of up to 7 items each -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            @foreach($gradeTypes as $key => $gradeType)
                                @if( $key < 7)
                                    @include('grade.grade_assignment_row')
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-5">
                            @foreach($gradeTypes as $key => $gradeType)
                                @if( $key >= 7)
                                    @include('grade.grade_assignment_row')
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="col-md-offset-4 col-md-8">
                        <a type="submit" onclick="document.frmGradeCutoffs.submit();" class="btn btn-success">
                            <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Save Assignments
                        </a>
                    </div>
                </form>
            </div>
            <br/>
            <div class="col-lg-7">
                <div id="chart" style="width: 600px; height: 400px;"></div>
            </div>
        </div>
    </div>
@endsection


@section('jsArea')

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        // set 'Reports' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navGrade').attr('class', 'active');

        var strExamScores = <?= json_encode( $examScores ) ?>; // student's exam scores
        var gradeTypes = <?= json_encode( $gradeTypes ) ?>; // array holding letter grades passed in "A+", "A", etc
        var examScores = strExamScores.map(Number);
        examScores.sort(function (a, b) {
            return a - b
        });
        var examData = [];
        var gradeCutoffs = [];

        updateColorData();

        function updateChartColors() {
            updateColorData();
            drawChart();
        }

        // rebuild examData with new color values based on current grade cutoffs
        function updateColorData() {
            examData = [];
            examData.push(['Student', 'Score', {role: 'style'}, { role: 'annotation' }]);

            // gradeCutoffs grabs current values from gradeGroup fields
            gradeCutoffs = [];
            $('[id^="gradeGroup"]').each(function () {
                gradeCutoffs.push($(this).val());
            });

            examScores.forEach(function (score, i) {
                barColor = getColorForGrade(score);
                gradeLetter = getLetterForGrade(score);
                examData.push([(i + 1).toString(), score, '#' + barColor, gradeLetter ]);
            });
        }

        // returns grade letter -- this is shoddy because it does the same loop as getColorForGrade.
        function getLetterForGrade(score) {
            for (var i = 0; i < gradeCutoffs.length; i++) {
                if (score >= parseFloat(gradeCutoffs[i])) {
                    return gradeTypes[i];
                }
            }
        }

        // returns hex color
        function getColorForGrade(score) {
            var gradeGroup = 0;
            for (var i = 0; i < gradeCutoffs.length; i++) {
                if (score >= parseFloat(gradeCutoffs[i])) {
                    gradeGroup = i;
                    break;
                }
            }
            var c1 = "FF0000"; // base color
            var color = (16 * gradeGroup);
            var c2 = color.toString(16); // amount to add to base
            return addHexColor(c1, c2);
        }

        function addHexColor(c1, c2) {
            var hexStr = (parseInt(c1, 16) + parseInt(c2, 16)).toString(16);
            while (hexStr.length < 6) {
                hexStr = '0' + hexStr;
            } // Zero pad.
            return hexStr;
        }

        // load and display the chart
        google.load("visualization", "1.1", {packages: ['corechart', 'bar']});
        google.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable(examData);

            var options = {
                chart: {
                    title: 'Student Grades',
                },
                vAxis: {
                    title: 'Score'
                },
                hAxis: {
                    title: 'Student'
                },
                legend: {
                    position: 'none'
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart'));

            chart.draw(data, options);
        }
    </script>

@endsection


