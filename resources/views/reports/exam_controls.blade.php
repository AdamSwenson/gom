<!-- Release an exam1, un-release an exam1, view analytics and review student feedback -->
@extends('layouts.master')
@section('pageTitle', 'Reports | gradeomatic')
@section('description', 'Handle post-grading tasks')

@section('otherCss')
    <link rel="stylesheet" href="{{ asset('css/report-index-package.css') }}"/>
@endsection

@section('body')
    <div id="examControlsPage">
        <div id="app">
            <h3><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Post-Grading Tasks</h3>
            <h4>Release grades to students or view data about an exam1</h4>

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
                        @foreach($exams as $exam1)
                            <?php $examId = $exam1->id or '0'; ?>
                            @include('reports.partials.exam_controls_tr_dropdown')
                        @endforeach
                    @else
                        <tr>
                            <td class="examDetailsCell" ></td>
                            <td class="examNameEmptyCell"><i>No Exams Found</i></td>
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
//        var activeTab = '';
        var baseUrl = '{!! url('') !!}';
    </script>
    <script type="text/javascript" src="{{ asset('js/report-exam1-controls-package.js') }}"></script>
@endsection


