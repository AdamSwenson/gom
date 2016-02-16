<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/7/15
 * Time: 12:07 PM
 */ ?>

@extends('layouts.master')
@section('pageTitle', 'Quality control tools')

@section('body')
    <h1>Quality Control <br/>
        <small>Catch grading errors before your students do</small>
    </h1>

    <div class="panel row">
        <div class="col-md-4">
            <p>Click on exams in the following charts to add them to the list of exams to revisit. </p>
            <p>(Make sure you copy this list and paste it into a document; it won't be saved after you leave this
                page</p>
        </div>
        <div class="col-md-8"></div>
    </div>

    <div class="row">
        <div class="col-md-6 text-left">
            <h4>Exams to revisit</h4>
            <ul id="revisitList" class="list-group"></ul>
        </div>
        <div class="col-md-6"></div>
    </div>

    <div id="scoresOrderArea">
        <div class="panel row">
            <div class="col-md-1"></div>
            <div class="col-md-6">

                <h3>Framing effects</h3>
                <p>It seems likely that if you read several very good exams and then one not-so-good exam, the lesser
                    exam
                    will seem worse than it would've if it had been read amongst exams of similar quality. </p>
                <p>Each bar in the following chart represents an exam. The exams are arranged in the order you graded
                    them,
                    from the leftmost being the earliest and the rightmost being the most recent. </p>
                <p>Look for exams with scores much higher or lower than their predecessors. These might be worth taking
                    a quick look at. </p>
            </div>
            <div class="col-md-5"></div>
        </div>

        <div class="row">
            <div id="scoresGradedOrderBar"></div>
        </div>
    </div>

    <div id="timeScoreScatter">
        <div class="panel row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
            <h3>Grading time</h3>
            <p>Spending a lot more than on others which received the same score might be a sign that you were tired and
                not really concentrating on the task. Spending a lot less time might be a sign that you were
                rushing.</p>
            <p>The following chart plots the time spent grading each exam against it's total score. You might want to
                recheck outliers.</p>
        </div>
            <div class="col-md-1"></div>
            </div>

        <div class="row">
            <div id="timeScoreScatter"></div>
        </div>

        <div class="row">
            <div id="gradingTimeHistogram"></div>
        </div>
    </div>

    {{--<div class="row">--}}
    {{--<div id="timesGradedOrderBar"></div>--}}
    {{--</div>--}}

    {{--<div class="row">--}}
    {{--<div id="combinedTimeAndScore"></div>--}}
    {{--</div>--}}

@endsection

@section('jsArea')
    <script type="text/javascript">
        var activeTab = 'navReport';
        var scoresAndTimes = [
                @foreach($scoresAndTimes as $st)
            [ '{{ $st["dateTime"] }}', {{ $st["seconds"] }}, {{ $st["totalScore"] }}],
            @endforeach
        ];
        var scoresAndTimesAll = [
                @foreach($scoresAndTimes as $st)
            [ '{{ $st["dateTime"] }}', {{ $st["seconds"] }}, {{ $st["totalScore"] }}, '{{ $st['studentIdentifier'] }}', '{{ $st['studentName'] }}' ],
            @endforeach
        ];
        var scoresGradedOrder = [
                @foreach($scoresAndTimes as $st)
            [ '{{ $st["dateTime"] }}', {{ $st["totalScore"] }}],
            @endforeach
        ];

        var timesGradedOrder = [
                @foreach($scoresAndTimes as $st)
            [ '{{ $st["dateTime"] }}', {{ $st["seconds"] }} ],
            @endforeach
        ];
    </script>

    @include('layouts.js.js_google_charts_include')
    <script type="text/javascript" src="{{ asset('js/quality-control-package.js') }}">

        //        google.load( "visualization", "1", { packages: [ "corechart" ] } );
        //        google.setOnLoadCallback( drawCharts );
        //
        //        function drawCharts() {
        //            drawScoresByOrder();
        //            drawTimesByOrder();
        //            drawTimeHistogram();
        //            drawTimeScoreScatter();
        //            drawScoreAndTimeByOrder();
        //
        //        }
        //

    </script>
@endsection
