<?php
if(!isset($dataAll))
{
    $dataAll = [$data];
}

$r = [];
foreach ($dataAll as $data)
{
    $r[$data->getAccessKey()] = $data->content;
}
$j = json_encode($r, JSON_FORCE_OBJECT);
?>

<html>
<head>
    <style type="text/css">
        /*div.studentInfo{*/
            /*margin-top: 2%;*/
        /*}*/

        div.pageEnd {
            page-break-after: always;
            page-break-inside: avoid;
        }

        div.questionFeedbackArea {
            page-break-after: auto;
            page-break-inside: avoid;
        }
    </style>
    @include('layouts.js_jquery_loader')
    @include('layouts.js_bootstrap_loader')
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

</head>
<body style="font-family: Arial;border: 0 none;">

<div class="container-fluid">
    @foreach($dataAll as $data)
        @include('feedback.n_student_info')

        @include('feedback.n_overall_chart')

        <div id="questionResultsHere">
            @foreach($data->content as $question)
                @include('feedback.n_question')
            @endforeach
        </div>

        <div class="pageEnd"></div>
    @endforeach
</div>


<div class="jsArea">

    <script type="text/javascript" src="{{ asset('js/feedback.js') }}"></script>

    <script type="text/javascript">
        var studentData = {!! $j !!};

        google.load('visualization', '1', {'packages': ['corechart']});
        google.setOnLoadCallback(drawAllStudentCharts);

    </script>
</div>


</body>
</html>




