<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/27/15
 * Time: 9:09 PM
 */
$h = '40px';
$w = '80px';
?>
@extends('layouts.master')

@section('pageTitle', 'Comments on your exam')
@section('cssLinks')
    <link href="{{ asset('inc/css/outputStyles.css')}}" type="text/css" rel="stylesheet"/>
@endsection

@section('body')
    <div id="studentInfo">
        <ul>
            <li>
                <label for='grade' class="studentInfoLabel">Grade: </label>
                <input type="text" readonly="readonly" id="grade" class="grade"
                       value="{{ (isset($data['grade']) ? $data['grade'] : '')}}"/>
            </li>
            <li>
                <span class="studentInfoLabel">Entry Code:</span> <span class="pseudoID"> </span>
            </li>
        </ul>
    </div> <!--//close studentInfo-->

    <div id="overall">
        <p class="small">Here's how you did on each question in comparison to the class average. <br/>
            The blue bar is you (on an arbitrary scale); the gold bar is the average
        </p>

        <div id="allQuestionsChart" style="height:{{$h}};width:{{$w}}; "></div>
    </div> <!--overall-->

    <div id="questionResultsHere">
        @foreach($data['questions'] as $question)
            @include('feedback.question')
        @endforeach
    </div>
    <div id="elementCharts"></div>
@endsection

@section('jsArea')

@endsection
