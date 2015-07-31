<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 7:27 AM
 */
$h='40px';
$w='80px';
?>


<div id='q{{ $question['questionNumber'] }}'>

    <h1 class='mainHeading'>Q{{ $question['questionNumber'] }}: {{ $question['questionName'] }}</h1>

    <p class='stockText generalStock'></p>

    <ul id='q{{ $question['questionNumber'] }}Comments'>
        @foreach($question['elements'] as $element)
            @include('feedback.comment')
        @endforeach
    </ul>
    <div id='Q{{$question['questionNumber']}}Chart' class='elementChartDiv' style='height:{{$h}}; width:{{$w}}'></div>
</div>