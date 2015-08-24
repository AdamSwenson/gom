<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/27/15
 * Time: 9:09 PM
 */
$h = '400px';
$w = '800px';
?>
@extends('layouts.primalMaster')

@section('pageTitle', 'Comments on your exam')
@section('cssLinks')
    <link href="{{ asset('inc/jqplot/jquery.jqplot.min.css')}}" />

    {!! \HTML::style(asset('/css/output.css')) !!}


    {{--<link href="{{ asset('inc/css/outputStyles.css')}}" type="text/css" rel="stylesheet"/>--}}
@endsection

@section('body')
    <div id="studentInfo">
        <ul>
            <li>
                <label for='grade' class="studentInfoLabel">Grade: </label>
                <input type="text" readonly="readonly" id="grade" class="grade"
                       value="{{ $data['grade'] or ''}}"/>
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
        @foreach($data as $question)
            @include('feedback.question')
        @endforeach
    </div>
    <div id="elementCharts"></div>
@endsection

@section('jsArea')
    <script type="text/javascript">
        var data = {!! ($data ? json_encode($data, JSON_FORCE_OBJECT) : '') !!};
    </script>

    <script language="javascript" type="text/javascript" src="{{ asset('inc/js/jqplot/jquery.jqplot.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.json2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.barRenderer.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.pointLabels.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.canvasTextRenderer.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.enhancedLegendRenderer.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('inc/js/outputScripts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/chartScripts.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var questionHolder = new QuestionHolder();
            questionHolder.loadScores(data);
            questionHolder.loadAverages(data);
            questionHolder.setAnsweredQuestions();
            var elementHolder = new ElementHolder();
            var elScores = consolidateElementScores(data);
            elementHolder.loadScores(data);
            //elementHolder.loadAverages(data);
            //divMaker(questionHolder);
            //Make charts
            makeOverallChart(questionHolder);
            makeElementCharts(elementHolder, questionHolder);

        });
    </script>
@endsection
