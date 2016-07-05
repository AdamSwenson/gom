<?php
//Expects an array named data, which has all feedback fields as keys

//Some things which return this view may just send a single data array,
//this wraps it in an outer array so that we can use it just like in the
//case where we want to see multiple feedback pages
if ( ! isset($dataAll) )
{
    $dataAll = [$data];
}

$r = [];
//Make sure everything has the format the js is expecting
foreach ( $dataAll as $data )
{
//    $r[ 'accessKey' ] = $data->content;
//    $r[ $data->getAccessKey() ] = $data->content;
    $r[ $data['accessKey'] ] = $data;
}
$encodedStudentData = json_encode($r, JSON_FORCE_OBJECT);
//var_dump($encodedStudentData);
?>


        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Your feedback</title>
    <meta name="description" content="Feedback for your exam">

    <link href='{{ asset('inc/images/favicon.ico') }}' rel='icon' type='image/x-icon'/>

    @include('layouts.css.css_bootstrap')
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

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
</head>
<body>
@if(isset($showNav) && $showNav == true)
    @if( Auth::check() )
        @include('navigation.nav_bar_main')
    @else
        @include('navigation.nav_bar_landing')
    @endif
@endif

<div id="studentFeedbackPage" class="container-fluid mainBodyLocator">

    @foreach($dataAll as $data)
        <?php $accessKey = $data['accessKey']; ?>
        @include('feedback.partials.student_info')

        @include('feedback.partials.overall_chart')

        <div id="questionResultsHere">
            @foreach($data['content'] as $question)
                @include('feedback.partials.question')
            @endforeach
        </div>

        <div class="pageEnd"></div>
    @endforeach

</div>


<div class="jsArea">
    <script type="text/javascript">
        var studentData = JSON.parse( '{!! $encodedStudentData !!}' );
        window.console.log( studentData );
        var activeTab = '';
    </script>
    <script type="text/javascript" src="{{ asset('js/feedback-package.js') }}"></script>
</div>

</body>

</html>




