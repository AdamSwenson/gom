<!-- Starting page for the setup task. User can create, edit, clone and delete exams -->

@extends('layouts.master')

@section('pageTitle', 'Setup exam1')

@section('description', 'Create, edit, clone or delete an exam1')

@section('otherCss')
    <link rel="stylesheet" href="{{ asset('css/select-exam1-package.css') }}">
@endsection

@section('body')
    <div id="setupSelectExamPage" class="mainBodyLocator">
        <nav>
            <ul class="pager">
                <li class="next">
                    <a id="forwardNavButton"
                       href="{{ url('exams') }}"
                       title="Create new exam1">Create New Exam
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
                @foreach($exams as $exam1)
                    <tr id="examRow{{ $exam1->getId() }}">
                        <td style="vertical-align:middle; width: 10%;">
                            {{ $exam1->getTerm() }} {{ $exam1->getYear() }}</td>
                        <td style="vertical-align:middle">
                            {{ $exam1->getName() }}</td>
                        <td style="vertical-align: middle">{{ $numberOfQuestions[$exam1->getId()] or '0' }}</td>
                        <td style="vertical-align: middle">{{ $numberOfStudents[$exam1->getId()] or '0' }}</td>
                        <!-- edit / clone / delete buttons -->
                        <td style="text-align:right;">
                            <a id="editExamButton{{$exam1->getId()}}"
                               class="editExam btn btn-info"
                               href="{{ url('exam1/'.$exam1->getId().'/edit') }}"
                               title="Edit Exam">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                Edit
                            </a>
                            <a id="cloneExamButton{{$exam1->getId()}}"
                               class="cloneExam btn btn-default"
                               href="{{ url('exam1/'.$exam1->getId().'/clone') }}"
                               title="Clone Exam">
                                <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> Clone
                            </a>
                            <a id="deleteExamButton{{$exam1->getId()}}"
                               class="deleteExam btn btn-danger"
                               data-exam1-id="{{ $exam1->getId() }}"
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
    </div>
@endsection


@section('jsArea')
    <script type="text/javascript">
        //The tab to be set as active
        var activeTab = 'navSetup';
    </script>
    <script language="javascript" type="text/javascript" src="{{ asset('js/exam1-select-package.js') }}"></script>
@endsection


