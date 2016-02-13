<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 7:27 AM
 */
$h='400px';
$w='800px';
?>

@if(!empty($question['score']))
<div id='q{{ $question['questionNumber'] }}' class="questionFeedbackArea">

    <h1 class='mainHeading'>Q{{ $question['questionNumber'] }}: {{ $question['questionName'] }}</h1>

    <p class='stockText generalStock'></p>

    <div id='q{{ $question['questionNumber'] }}Comments' class="commentsArea">
        @foreach($question['elements'] as $element)
            @include('feedback.partials.comment')
        @endforeach
    </div>
    <div class="chartContainer">
    <h4>Q{{$question['questionNumber']}}: {{$question['questionName']}}</h4>
        <div id='Q{{$question['questionNumber']}}Chart' class='elementChartDiv' style='height:{{$h}}; width:{{$w}}'></div>
    </div>
</div>
@endif