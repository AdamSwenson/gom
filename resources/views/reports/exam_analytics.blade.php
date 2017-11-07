<!-- Analytics page holds visualizations for student performance -->
@extends('layouts.master')

@section('pageTitle', 'Analytics | gradeomatic')
@section('description', 'View information about the exam1')

@section('otherCss')
    <link rel="stylesheet" href="{{ asset('css/exam1-analytics-package.css') }}"/>
@endsection

@section('body')
    <h3><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Analytics: {{ $exam1->getTerm() }}
        {{ $exam1->getYear() }} "{{ $exam1->getName() }}"</h3>

    <div id="app">
        <h3 class="text-center">Question Score Statistics</h3>
        <div id="questionStatsTableArea" class="row chartDiv">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">

                <table id="questionStatsTable"
                       class="table table-striped table-condensed"
                >
                    <thead>
                    <tr>
                        <th>Question #</th>
                        <th>Question Name</th>
                        <th>Mean</th>
                        <th>Median</th>
                        <th>Standard Dev</th>
                        <th>Max Score</th>
                        <th>Min Score</th>
                        <th># Answers</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="col-lg-1"></div>
        </div>

        <div class="row">
            <div class="col-lg-1"></div>
            <div class="chart col-lg-10">
                <div id="questionScoreBoxplot"></div>
                {{--<p style="width: 800px; text-align: center;"><a onclick="howToReadBoxPlot();">How to read this chart</a>--}}
                </p>
            </div>
            <div class="col-lg-1">
                <p><a id="boxplotHowTo">How to read this chart</a>
            </div>
        </div>


        <h3 class="text-center">Element Score Statistics</h3>
        <div id="elementStatsTableArea" class="row chartDiv">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">

                <table id="elementStatsTable"
                       class="table"
                >
                    <thead>
                    <tr>
                        <th>Element</th>
                        <th>Element Name</th>
                        <th>Mean</th>
                        <th>Median</th>
                        <th>Standard Dev</th>
                        <th>Max Score</th>
                        <th>Min Score</th>
                        <th># Answers</th>
                        <th>View Charts</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="col-lg-1"></div>
        </div>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <div id="elementChartArea" class="row"></div>
            </div>
        </div>
        <div class="col-lg-1"></div>
    </div>

@endsection


@section('jsArea')
    @include('layouts.js.js_google_charts_include')
    <script type="text/javascript">

        google.load( "visualization", "1", { packages: [ "corechart" ] } );

        var activeTab = 'navReport';

        var questionScores = JSON.parse( '{!! $questionScores !!}' );
        var questionScoresByQNumber = JSON.parse( '{!! $questionScoresByQNumber !!}' );
        var questionStats = JSON.parse( '{!! $questionStats !!}' );
        var elementStats = JSON.parse( '{!! $elementStats !!}' );
        var elementScoresByQENumber = JSON.parse( '{!! $elementScoresByQENumber !!}' )

        console.log( 'questionStats', questionStats );
        console.log( 'elementStats', elementStats );
        console.log( 'questionScores', questionScores );
        console.log( 'questionScoresByQNum', questionScoresByQNumber );
        console.log( 'elementScoresByQENum', elementScoresByQENumber );
    </script>
    <script type="text/javascript" src="{{ asset('js/report-exam1-analytics-package.js') }}"></script>

@endsection


