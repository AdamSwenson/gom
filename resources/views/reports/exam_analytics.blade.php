<!-- Analytics page holds visualizations for student performance -->
@extends('layouts.master')

@section('pageTitle', 'Analytics | gradeomatic')
@section('description', 'View information about the exam')

@section('cssLinks')
    <link rel="stylesheet" href="{{ asset('css/exam-analytics-package.css') }}"/>
@endsection

@section('body')
    <h3><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Analytics: {{ $exam->getTerm() }}
        {{ $exam->getYear() }} "{{ $exam->getName() }}"</h3>

    <div class="chart" id="chart_div">
    </div>
    <p style="width: 800px; text-align: center;"><a onclick="howToReadBoxPlot();">How to read this chart</a></p>

@endsection


@section('jsArea')
    @include('layouts.js.js_google_charts_include')
    <script type="text/javascript">
        var activeTab = 'navReport';
        var questionScores = <?= json_encode($questionScores) ?>;
    </script>
    <script type="text/javascript" src="{{ asset('js/exam-analytics-package.js') }}"></script>

@endsection


