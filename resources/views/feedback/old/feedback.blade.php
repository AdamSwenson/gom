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
@section('otherCss')
    {!! \HTML::style(asset('/inc/jqplot/jquery.jqplot.min.css')) !!}
    {!! \HTML::style(asset('/css/output.css')) !!}
@endsection

@section('body')
    <div id="studentInfo">
        <p>
            <span class="studentInfoLabel">Grade:</span> <span class="grade">{{  $data->grade() }}</span>
        </p>
        <p>
            <span class="studentInfoLabel">Entry Code:</span> <span class="pseudoID"> {{ $data->getAccessKey() }}</span>
        </p>
    </div>

    <div id="overall">
        <p class="small">Here's how you did on each question in comparison to the class average. <br/>
            The blue bar is you (on an arbitrary scale); the gold bar is the average
        </p>

        <div id="allQuestionsChart" style="height:{{$h}};width:{{$w}}; "></div>
    </div> <!--overall-->

    <div id="questionResultsHere">
        @foreach($data as $question)
            @include('feedback.old.question')
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
