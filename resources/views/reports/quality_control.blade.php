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
        <div class="col-md-8">
            <p>Grading is boring and hard. Mistakes are both inevitable and consequential. A struggling student who gets
                a D instead of the C she deserves might lose financial aid and drop out of college. At the same time, it
                is difficult to do any real quality control without expending an unreasonable amount of time and
                effort.</p>
            <p>We are working on algorithms to better identify potential grading errors. In the meantime, here are some
                representations of your grading process which can help you visually identify potential problems. Use
                them to identify exams to quickly glance over and double-check your work.</p>
            <p>Clicking on exams in the following charts adds them to the list of exams on the right. </p>

        </div>
        <div class="col-md-4">
            <h4>Exams to revisit</h4>
            <ul id="revisitList" class="list-group"></ul>
            <p>(Make sure you copy this list and paste it into a document; it won't be saved after you leave this
                page)</p>
        </div>
    </div>

    {{--<div class="row">--}}
    {{--<div class="col-md-8 text-left">--}}
    {{--<h4>Exams to revisit</h4>--}}
    {{--<ul id="revisitList" class="list-group"></ul>--}}
    {{--<p>(Make sure you copy this list and paste it into a document; it won't be saved after you leave this--}}
    {{--page)</p>--}}
    {{--</div>--}}
    {{--<div class="col-md-4"></div>--}}
    {{--</div>--}}

    <div id="scoresOrderArea">
        <div class="panel row">
            <div class="col-md-8 col-xs-12">

                <div class="panel-heading"><h3>Framing effects</h3></div>
                <div class="panel-body">
                    <p>If you read several very good exams and then one average exam, the average exam may seem worse
                        than it is. Or vice-versa.</p>
                    Each bar in the following chart represents an exam. The exams are arranged in the order they were
                    graded. The first exam you graded is on the left. The last exam is on the right.</p>
                    <p>Look for sudden peaks and valleys. That is, exams with scores much higher or lower than their
                        predecessors. These may be worth taking a quick look at. </p>
                </div>
            </div>
            <div class="col-md-4 hidden-xs"></div>
        </div>

        <div class="row">
            <div id="scoresGradedOrderBar"></div>
        </div>
    </div>

    <div id="timeScoreScatterArea">
        <div class="panel row">
            <div class="col-md-8 col-xs-12">
                <h3>Grading time</h3>
                <p>To help keep you motivated, the gradeomatic recorded how long you spent grading each exam. You can
                    use this data to help with quality control.</p>
                <p>For example, you might have spent twice as long on one B- exam than on other B- exams because you
                    were tired or losing focus on the task. Similarly, spending a lot less time on an exam might be a
                    sign that you were rushing.</p>
                <p>The following chart plots the time spent grading each exam against it's total score. You might want
                    to pay particular attention to outliers in the upper left quadrent (high score; graded fast) and
                    lower right quadrent (low score; graded slow).</p>
            </div>
            <div class="col-md-4 hidden-xs"></div>
        </div>

        <div class="row">
            <div id="timeScoreScatter"></div>
        </div>

        <div class="row">
            <div class="col-md-8 col-xs-12">
                <p>In many disciplines, there will tend to be a rough positive correlation between exam quality and
                    grading time (i.e., better students tend to write more than less good students). Howevever, this
                    will not always be the case. It thus may help to look for outliers by grading time alone. The
                    following chart is a simple histogram of the amount of time spent grading exams. The number of exams
                    taking the amount of time a particular bin is on the vertical axis. You may want to revisit exams in
                    the extreme left and right bins.</p>
            </div>
            <div class="col-md-4 hidden-xs"></div>
        </div>

        <div class="row">
            <div id="gradingTimeHistogram"></div>
        </div>
    </div>

@endsection

@section('jsArea')
    <script type="text/javascript">
        var activeTab = 'navReport';
        var scoresAndTimes = [
                @foreach($scoresAndTimes as $st)
            ['{{ $st["dateTime"] }}', {{ $st["seconds"] }}, {{ $st["totalScore"] }}],
            @endforeach
        ];
        var scoresAndTimesAll = [
                @foreach($scoresAndTimes as $st)
            ['{{ $st["dateTime"] }}', {{ $st["seconds"] }}, {{ $st["totalScore"] }}, '{{ $st['studentIdentifier'] }}', '{{ $st['studentName'] }}'],
            @endforeach
        ];
        var scoresGradedOrder = [
                @foreach($scoresAndTimes as $st)
            ['{{ $st["dateTime"] }}', {{ $st["totalScore"] }}],
            @endforeach
        ];

        var timesGradedOrder = [
                @foreach($scoresAndTimes as $st)
            ['{{ $st["dateTime"] }}', {{ $st["seconds"] }} ],
            @endforeach
        ];
    </script>

    @include('layouts.js.js_google_charts_include')
    <script type="text/javascript" src="{{ asset('js/quality-control-package.js') }}"></script>
@endsection
