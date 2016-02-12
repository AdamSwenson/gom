<!-- Starting page for the setup task. User can create, edit, clone and delete exams -->

@extends('layouts.master')

@section('pageTitle', 'Exam Setup | gradeomatic')

@section('description', 'Create, edit, clone or delete an exam')

@section('cssLinks')

@endsection

@section('body')

    <style>
        a {
            cursor: pointer;
        }

        .table th {
            border: none;
        }
    </style>

    <nav>
        <ul class="pager">
            <li class="next">
                <a href="{{ url('exam/create') }}" title="Create new exam">Create New Exam
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
            </li>
        </ul>
    </nav>
    <h2><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Exam Setup</h2>
    <h4>Create, edit and delete exams</h4>
    <table class="table">
        <thead>
        <tr>
            <th class="col-lg-1">Term</th>
            <th class="col-lg-6" style="min-width: 200px;">Name</th>
            <th class="col-lg-1">Questions</th>
            <th class="col-lg-1">Students</th>
            <th class="col-lg-3" style="width: 260px; min-width: 260px;"></th>
        </tr>
        </thead>
        <tbody>
        @if ( sizeof($exams) > 0 )
            @foreach($exams as $exam)
                <tr>
                    <td style="vertical-align:middle; width: 10%;">
                        {{ $exam->getTerm() }} {{ $exam->getYear() }}</td>
                    <td style="vertical-align:middle">
                        {{ $exam->getName() }}</td>
                    <td style="vertical-align: middle">{{ $numberOfQuestions[$exam->getId()] or '0' }}</td>
                    <td style="vertical-align: middle">{{ $numberOfStudents[$exam->getId()] or '0' }}</td>
                    <!-- edit / clone / delete buttons -->
                    <td style="text-align:right;">
                        <a class="btn btn-info" href="{{ url('exam/'.$exam->getId().'/edit') }}"
                           title="Edit Exam">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            Edit
                        </a>
                        <a class="btn btn-default" href="{{ url('exam/'.$exam->getId().'/clone') }}"
                           title="Clone Exam">
                            <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> Clone
                        </a>
                        <a class="btn btn-danger" onclick="showConfirmation({{ $exam->getId() }})"
                           title="Delete Exam">
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            Delete
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td></td>
                <td><i>No Exams Found</i></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif
        </tbody>
    </table>

@endsection


@section('jsArea')
    <script type="text/javascript">
        //The tab to be set as active
        var activeTab = 'navSetup';
    </script>
    <script language="javascript" type="text/javascript" src="{{ asset('js/exam-select-package.js') }}"></script>


    {{--<script type="text/javascript">--}}

        {{--// set 'Setup' tab as active--}}
        {{--$('[id^="nav"]').attr('class', '');--}}
        {{--$('#navSetup').attr('class', 'active');--}}

        {{--function showConfirmation(examId) {--}}
            {{--bootbox.dialog({--}}
                {{--message: '<span class="glyphicon glyphicon-warning-sign text-danger" aria-hidden="true"></span> ' +--}}
                {{--"Warning: This will delete all associated students, scores, questions and elements. " +--}}
                {{--"<br/>Do you wish to proceed?",--}}
                {{--title: "Delete Exam",--}}
                {{--buttons: {--}}
                    {{--success: {--}}
                        {{--label: 'Cancel',--}}
                        {{--className: "btn-sm",--}}
                        {{--callback: function () {--}}
                        {{--}--}}
                    {{--},--}}
                    {{--danger: {--}}
                        {{--label: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete',--}}
                        {{--className: "btn-danger btn-sm",--}}
                        {{--callback: function () {--}}
                            {{--// do deletion for examId--}}
                            {{--deleteExam(examId);--}}
                        {{--}--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}

        {{--function deleteExam(examId) {--}}

            {{--$.ajax({--}}
                {{--url: 'exam/' + examId,--}}
                {{--type: "post",--}}
                {{--data: {_method: "DELETE"},--}}
                {{--success: function (data) {--}}
                    {{--window.location.replace(data.url_redirect);--}}
                {{--},--}}
                {{--error: function () {--}}
                    {{--bootbox.alert("Whoops! The exam failed to delete. Please try again.");--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}
        {{--$(document).ready(function () {--}}
            {{--return false;--}}
        {{--});--}}
    {{--</script>--}}

@endsection


