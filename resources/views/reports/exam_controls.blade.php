<!-- Release an exam, un-release an exam, view analytics and review student feedback -->
@extends('layouts.master')
@section('pageTitle', 'Reports | gradeomatic')
@section('description', 'Select an exam action')

@section('otherCss')
    <link rel="stylesheet" href="{{ asset('css/exam-controls-package.css') }}"/>
    {{--<link href="{{asset('css/exam-button-package.css')}}" rel="stylesheet">--}}


@endsection

@section('body')
    <div id="examControlsPage">
        <div id="app">
            <h3><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Reports & Release</h3>
            <h4>Release grades to students or view data about an exam</h4>

            <div class="panel panel-default">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="col-sm-1">Term</th>
                        <th class="col-sm-6">Name</th>
                        <th class="col-sm-5"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ( sizeof($exams) > 0 )
                        @foreach($exams as $exam)
                            <?php $examId = $exam->id or '0'; ?>
                            @include('reports.partials.exam_controls_tr_dropdown')
                        @endforeach
                    @else
                        <tr>
                            <td style="vertical-align:middle; width: 10%;"></td>
                            <td style="vertical-align:middle"><i>No Exams Found</i></td>
                            <td></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('jsArea')
    <script type="text/javascript">
        var activeTab = 'navReport';
        var baseUrl = '{!! url() !!}';
    </script>
    <script type="text/javascript" src="{{ asset('js/dev-exam-buttons.js') }}"></script>


    {{--<script type="text/javascript" src="{{ asset('js/exam-controls-package.js') }}"></script>--}}


@endsection


