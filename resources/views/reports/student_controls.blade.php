@extends('layouts.master')

@section('pageTitle', 'Student Controls | gradeomatic')
@section('description', 'Email or review student feedback')

@section('cssLinks')
@endsection

@section('body')
    <h3 id="examTitle" data-exam-id="{{ $exam->getId() }}">
        <span class="glyphicon glyphicon-user" aria-hidden="true"> </span> Student Controls:
        {{ $exam->getTerm() }} {{ $exam->getYear() }} "{{ $exam->getName() }}"</h3>
    <h4>Send email notifications or review student feedback</h4>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="col-md-3">Name</th>
            <th class="col-md-4">Email</th>
            <th class="col-md-2">ID</th>
            <th class="col-md-3"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($students as $student)
            <tr>
                <td style="vertical-align:middle"
                    id="studentName">{{ $student->last_name }}
                    , {{ $student->first_name }}</td>
                <td style="vertical-align:middle"
                    id="studentEmail{{ $student->getId()}}">{{ $student->getEmail() }}</td>
                <td style="vertical-align:middle">{{ $student->getStudentId()}}</td>
                <td style="text-align: right;">
                    <a class="btn btn-default confirmStudentEmail"
                       style="width:120px;"
                       id="{{ 'studentId'.$student->getId() }}"
                       title="Email Student" data-graded="{{ $student->hasBeenGraded($exam->getId()) }}"
                       data-studentid="{{ $student->getId() }}"
                       data-emailed="{{ $student->feedBackEmailSent($exam->getId()) }}">
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Email
                    </a>
                    <a class="btn btn-info" title="Review Student Feedback" id="btnReview"
                       data-feedback-available="{{ $student->isFeedBackAvailable($exam->getId()) }}"
                       href="{{ url('report/'.$exam->getId().'/students/'.$student->getId()) }}">
                        <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                        Review
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('jsArea')
    <script type="text/javascript">
        var activeTab = 'navReport';
    </script>

    <script type="text/javascript" src="{{ asset('js/student-controls-package.js') }}"></script>

@endsection


