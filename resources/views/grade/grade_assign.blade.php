<!-- Analytics page holds visualizations for student performance -->
@extends('layouts.master')

@section('pageTitle', 'Assign Grades | gradeomatic')
@section('description', 'Assign letter grades for the exam')

@section('cssLinks')
@endsection

@section('body')
    <style>
        .chart rect {
            fill: steelblue;
        }

        .chart text {
            fill: white;
            font: 10px sans-serif;
            text-anchor: middle;
        }
    </style>
    <div class="container">
        @include('errors.list')

        <h3><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Assign Grades: {{ $exam->getTerm() }}
            {{ $exam->getYear() }} "{{ $exam->getName() }}"</h3>
        <h4>Enter the minimum exam grade for each letter assignment. Blank grades will not be used.</h4>

        <div class="row">
            {{-- Left column holds grade assignment regions --}}
            <div class="col-md-5">
                <form class="form-horizontal" id="rosterData" method="post" role="form"
                      action="{{ url('grade/exam/'.$exam->getId().'/assign') }}">
                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                    {{-- Grade Assignment fields. These will form into 2 columns of up to 7 items each --}}
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            @foreach($gradeTypes as $key => $gradeType)
                                @if( $key < 7)
                                    @include('grade.grade_assignment_row')
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-5">
                            @foreach($gradeTypes as $key => $gradeType)
                                @if( $key >= 7)
                                    @include('grade.grade_assignment_row')
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="col-md-offset-4 col-md-8">
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Save Assignments
                        </button>
                    </div>
                </form>
            </div>
            {{-- Right column may hold some data, maybe a chart or list of grades? --}}
            <div class="col-md-7">
                <div class="container">
                    <div id="chart_div" style="width:400px; height:300px;"></div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('jsArea')

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        // set 'Reports' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navGrade').attr('class', 'active');

        google.load('visualization', '1', {packages: ['corechart', 'bar']});
        google.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Visitations', { role: 'style' } ],
                ['2010', 10, 'color: gray'],
                ['2010', 14, 'color: #76A7FA'],
                ['2020', 16, 'opacity: 0.2'],
                ['2040', 22, 'stroke-color: #703593; stroke-width: 4; fill-color: #C5A5CF'],
                ['2040', 28, 'stroke-color: #871B47; stroke-opacity: 0.6; stroke-width: 8; fill-color: #BC5679; fill-opacity: 0.2']
            ]);

            var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
            chart.draw(data, options);
        }

    </script>

@endsection


