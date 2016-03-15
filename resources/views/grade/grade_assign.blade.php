<!-- Analytics page holds visualizations for student performance -->
@extends('layouts.master')

@section('pageTitle', 'Assign Grades | gradeomatic')
@section('description', 'Assign letter grades for the exam')

@section('cssLinks')
@endsection

@section('body')
    <h3><span class="glyphicon glyphicon-signal" aria-hidden="true"></span> Assign Grades: {{ $exam->getTerm() }}
        {{ $exam->getYear() }} "{{ $exam->getName() }}"</h3>
    <h4>Enter the minimum exam grade for each letter assignment. Blank grades will not be used.</h4>
    <br/>

    <div class="row">
        <!-- Left column holds grade assignment regions -->
        <div class="col-sm-5" style="text-align: center; max-width: 450px; min-width: 350px;">
            <h4 style="text-align: center;">Maximum possible score: {{ $examMaxScore or '--' }}</h4>

            <form class="form-horizontal" method="post" role="form" name="frmGradeCutoffs"
                  action="{{ url('grade/exam/'.$exam->getId().'/assign') }}">
                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                <!-- Grade Assignment fields. These will form into 2 columns of up to 7 items each -->
                <div class="row">
                    <div class="col-xs-1"></div>
                    <div class="col-xs-5" style="min-width: 160px;">
                        @foreach($gradeTypes as $key => $gradeType)
                            @if( $key < 7)
                                @include('grade.partials.grade_assignment_row')
                            @endif
                        @endforeach
                    </div>
                    <div class="col-xs-5" style="min-width: 160px;">
                        @foreach($gradeTypes as $key => $gradeType)
                            @if( $key >= 7)
                                @include('grade.partials.grade_assignment_row')
                            @endif
                        @endforeach
                    </div>
                    <div class="col-xs-1"></div>
                </div>
                <div style="text-align: center;">
                    <a type="submit" onclick="document.frmGradeCutoffs.submit();" class="btn btn-success">
                        <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Save Assignments
                    </a>
                </div>
            </form>
        </div>
        <div class="col-sm-7">
            <div id="gradeFreqChart" style="width: 450px; height: 220px;"></div>
            <div id="scoreChart" style="width: 450px; height: 220px;"></div>
        </div>
    </div>

@endsection


@section('jsArea')

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        var strExamScores = JSON.parse('{!! json_encode( $examScores )!!}'); // student exam scores as strings
        var gradeTypes = JSON.parse('{!! json_encode( $gradeTypes ) !!}'); // holds string values for grades: "A+", "A", etc
        var scoreChartData = []; // array to be passed to google API for the student score dist chart
        var freqChartData = []; // array to be passed for the grade frequency chart
        var gradeCutoffs = JSON.parse('{!! json_encode( $gradeCutoffs )!!}'); // numerical cutoffs assigned to each grade (indexed A+ = 0, A = 1, ...)
        var gradeFrequency = []; // number of students with a given grade (indexed A+ = 0, A = 1, ...)
        var examMaxScore = JSON.parse('{!! json_encode( $examMaxScore ) !!}');

        // for setting 'Grade' tab as active
        var activeTab = 'navGrade';
</script>
    <script type="text/javascript" src="{{asset('js/grade-assign-package.js')}}"></script>
        {{--var examScores = strExamScores.map(Number);--}}
        {{--examScores.sort(function (a, b) {--}}
            {{--return a - b--}}
        {{--});--}}

        {{--// when scores are changed, update grade assignments and draw charts--}}
        {{--$('input').change(function () {--}}
            {{--if ($(this).val() > examMaxScore) {--}}
                {{--$(this).val(examMaxScore);--}}
            {{--}--}}

            {{--if ($(this).val() < 0) {--}}
                {{--$(this).val(0);--}}
            {{--}--}}
            {{--updateGradeFrequency();--}}
            {{--updateScoreChartData();--}}
            {{--drawCharts();--}}
        {{--});--}}

        {{--function updateGradeFrequency() {--}}
            {{--// Update gradeCutoffs--}}
            {{--gradeCutoffs = [];--}}
            {{--$('[id^="gradeGroup"]').each(function () {--}}
                {{--gradeCutoffs.push($(this).val());--}}
            {{--});--}}

            {{--// calculate frequency that each letter grade appears.--}}
            {{--// this array is reversed, with gradeFrequency[0] = F, so the table shows grades in the expected ASC order--}}
            {{--gradeFrequency = [];--}}
            {{--examScores.forEach(function (score, i) {--}}
                {{--for (var j = 0; j < gradeCutoffs.length; j++) {--}}
                    {{--if (score >= gradeCutoffs[j]) {--}}
                        {{--if (gradeFrequency[j])--}}
                            {{--gradeFrequency[j]++;--}}
                        {{--else--}}
                            {{--gradeFrequency[j] = 1;--}}
                        {{--break;--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}

            {{--freqChartData = [];--}}
            {{--gradeFrequency.forEach(function (freq, i) {--}}
                {{--var barColor = getColorForGrade(gradeCutoffs[i]);--}}
                {{--freqChartData.push([gradeTypes[i], freq, barColor]);--}}
            {{--});--}}
            {{--freqChartData.push(['Grade', 'Frequency', {role: 'style'}]);--}}
            {{--// now reverse the chart data so that "F" is the first column and A+ the furthest right--}}
            {{--freqChartData.reverse();--}}

        {{--}--}}

        {{--// rebuild scoreChartData with new color values based on current grade cutoffs--}}
        {{--function updateScoreChartData() {--}}
            {{--scoreChartData = [];--}}
            {{--scoreChartData.push(['Student', 'Score', {role: 'style'}, {role: 'annotation'}]);--}}

            {{--examScores.forEach(function (score, i) {--}}
                {{--var barColor = getColorForGrade(score);--}}
                {{--var gradeLetter = getLetterForGrade(score);--}}
                {{--scoreChartData.push([(i + 1).toString(), score, '#' + barColor, gradeLetter]);--}}
            {{--});--}}
        {{--}--}}

        {{--// returns grade letter -- this is shoddy because it does the same loop as getColorForGrade.--}}
        {{--function getLetterForGrade(score) {--}}
            {{--for (var i = 0; i < gradeCutoffs.length; i++) {--}}
                {{--if (score >= parseFloat(gradeCutoffs[i])) {--}}
                    {{--return gradeTypes[i];--}}
                {{--}--}}
            {{--}--}}
        {{--}--}}

        {{--// returns hex color -- alg is arbitrary, but needs to have enough variation from one grade group to the next--}}
        {{--function getColorForGrade(score) {--}}
            {{--var gradeGroup = 0;--}}
            {{--for (var i = 0; i < gradeCutoffs.length; i++) {--}}
                {{--if (score >= parseFloat(gradeCutoffs[i])) {--}}
                    {{--gradeGroup = i;--}}
                    {{--break;--}}
                {{--}--}}
            {{--}--}}
            {{--var c1 = "00FF00"; // base color is pure green--}}
            {{--var colorWidth = 4096;--}}
            {{--var color = (colorWidth * gradeGroup);--}}
            {{--var c2 = color.toString(16); // amount to add to base--}}
            {{--return addHexColor(c1, c2, false); // subtract 1000 hex for each grade group--}}
        {{--}--}}

        {{--// adds c1 to c2. if 'add' is false, values are subtracted--}}
        {{--function addHexColor(c1, c2, add) {--}}
            {{--if (add) {--}}
                {{--var hexStr = (parseInt(c1, 16) + parseInt(c2, 16)).toString(16);--}}
            {{--} else {--}}
                {{--var hexStr = (parseInt(c1, 16) - parseInt(c2, 16)).toString(16);--}}
            {{--}--}}
            {{--while (hexStr.length < 6) {--}}
                {{--hexStr = '0' + hexStr;--}}
            {{--}--}}
            {{--return hexStr;--}}
        {{--}--}}

        {{--// do these 2 on page load--}}
        {{--updateGradeFrequency();--}}
        {{--updateScoreChartData();--}}

        {{--// load and display charts when ready--}}
        {{--google.load("visualization", "1.1", {packages: ['corechart', 'bar']});--}}
        {{--google.setOnLoadCallback(drawCharts);--}}

        {{--function drawCharts() {--}}
            {{--drawFrequencyChart();--}}
            {{--drawScoresChart();--}}
        {{--}--}}

        {{--// displays the grade frequency chart--}}
        {{--function drawFrequencyChart() {--}}
            {{--var data = google.visualization.arrayToDataTable(freqChartData);--}}

            {{--var options = {--}}
                {{--chart: {title: 'Grade Distribution'},--}}
                {{--vAxis: {title: 'Count', format: '#'},--}}
                {{--hAxis: {title: 'Grade'},--}}
                {{--chartArea: {'width': '80%', 'height': '70%'},--}}
                {{--legend: {position: 'none'},--}}
                {{--animation: {--}}
                    {{--duration: 600,--}}
                    {{--startup: "true"--}}
                {{--}--}}
            {{--};--}}

            {{--var chart = new google.visualization.ColumnChart(document.getElementById('gradeFreqChart'));--}}
            {{--chart.draw(data, options);--}}
        {{--}--}}

        {{--// displays the bar chart of student scores--}}
        {{--function drawScoresChart() {--}}
            {{--var data = google.visualization.arrayToDataTable(scoreChartData);--}}

            {{--var options = {--}}
                {{--chart: {title: 'Student Grades'},--}}
                {{--vAxis: {title: 'Score'},--}}
                {{--hAxis: {title: 'Student #'},--}}
                {{--chartArea: {'width': '80%', 'height': '70%'},--}}
                {{--legend: {position: 'none'},--}}
                {{--animation: {--}}
                    {{--duration: 600,--}}
                    {{--startup: "true"--}}
                {{--}--}}
            {{--};--}}

            {{--var chart = new google.visualization.ColumnChart(document.getElementById('scoreChart'));--}}

            {{--chart.draw(data, options);--}}
        {{--}--}}
    {{--</script>--}}
@endsection


