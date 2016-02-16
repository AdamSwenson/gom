<?php
$data = \App\Feedback::all()->random();
?>

<html>
<head>
    <style type="text/css">

        div.pageEnd {
            page-break-after: always;
            page-break-inside: avoid;
        }
        div.questionFeedbackArea{
            page-break-after: auto;
            page-break-inside: avoid;
        }
    </style>
    @include('layouts.js.js_jquery_loader')
    @include('layouts.js.js_bootstrap_loader')
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

</head>
<body style="font-family: Arial;border: 0 none;">
<div class="container-fluid">

    @include('feedback.partials.student_info')

    @include('feedback.partials.overall_chart')

    <div id="questionResultsHere">
        @foreach($data->content as $question)
            @include('feedback.partials.question')
        @endforeach
    </div>

    <div class="pageEnd"></div>
</div>

    <div class="jsArea">
        <script type="text/javascript">
            var studentData =  {!! ($data ? json_encode([$data->getAccessKey() => $data->content], JSON_FORCE_OBJECT) : '') !!};

            google.load('visualization', '1', {'packages': ['corechart']});

            //        google.load('visualization', '1');   // Don't need to specify chart libraries!
            google.setOnLoadCallback(drawAllStudentCharts);

            /**
             * This handles all chart creation. It is agnostic on the number of
             * students on the page
             */
            function drawAllStudentCharts() {
                $.each(studentData, function ($sid, $data) {
                    //Make the chart displaying how they did on each question vs class
                    makeOverallChart($sid, $data);

                    //Make a chart for the scores on all the elements for a given question
                    $.each($data, function ($k, $v) {
                        //Don't make a chart for questions which student didn't answer
                        if (!$.isEmptyObject($v.elements)) {
                            var chartTarget = 's' + $sid + '_q' + $v.questionNumber;
                            makeElementsChartForQuestion(chartTarget, $v.questionNumber, $v.elements);
                        }
                    });
                });
            }

            /**
             * Builds the chart comparing performance on all questions
             * @param sid Something to identify the student
             * @param studentData
             */
            function makeOverallChart(sid, studentData) {

                /* Which chart div to stick this in (esp important if there are multiple students on page */
                var chartTarget = 'overall_s' + sid;

                var options = {
                    title: "How you did on each question compared to the class average ",
                    width: 600,
                    height: 400,
                    bar: {groupWidth: "65%"},
                    legend: {position: "bottom"}
                };

                //Prepare the data
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'question');
                data.addColumn('number', 'Your Score');
                data.addColumn('number', 'Class Average');

                $.each(studentData, function ($k, $v)
                {
                    //Build up question name for label
                    //Since question name is optional, only add it if it is present
                    var questionName = 'Q' + $v['questionNumber'] + ' ';
                    questionName += $v['questionName'] ? $v['questionName'] : ' ';

                    //push row into data table
                    data.addRow([questionName, $v['score'], $v['average']]);
                });

                //Draw the chart
                var chart = new google.visualization.ColumnChart(document.getElementById(chartTarget));
                chart.draw(data, options);
            }


            /**
             * Makes a chart of the student's performance vs. average on each element
             * comprising the question
             * @param chartTarget The div id to put the chart in
             * @param questionNumber
             * @param elementsData Object of all element data for that question
             */
            function makeElementsChartForQuestion(chartTarget, questionNumber, elementsData) {

                //push into data table as chart is expecting
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'task');
                data.addColumn('number', 'Your Score');
                data.addColumn('number', 'Class Average');

                //Make a row for each element
                $.each(elementsData, function ($k, $v) {
                    data.addRow([$v['elementName'], $v['score'], $v['average']]);
                });

                var options = {
                    title: "How you did on tasks for question #" + questionNumber,
                    width: 600,
                    height: 400,
                    bar: {groupWidth: "65%"},
                    legend: {position: "bottom"}
                };

                var chart = new google.visualization.ColumnChart(document.getElementById(chartTarget));
                chart.draw(data, options);
            }

        </script>
    </div>


</body>
</html>




