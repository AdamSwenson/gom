<!-- Starting page for the setup task. User can create, edit, clone and delete exams -->

@extends('layouts.master')

@section('pageTitle', 'Exam Setup | Grade-O-Matic')

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

    .panel {
        border: none;
    }

</style>

<div class="container">
    <nav>
        <ul class="pager" >
            <li class="next">
                <a href="{{ url('exam/create') }}">Create New Exam <span class="glyphicon glyphicon-chevron-right"
                                                                         aria-hidden="true"></span></a>
            </li>
        </ul>
    </nav>
    <h3><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Exam Setup</h3>
    <h4>Create, edit and delete exams</h4>
    <div class="container">
        <div <?php if( sizeof($exams) == 0 ) { echo('style="display:none;"');} ?> >
            <table class="table">
                <thead>
                <tr>
                    <th class="col-md-2">Term</th>
                    <th class="col-md-5">Name</th>
                    <th class="col-md-1">Questions</th>
                    <th class="col-md-1">Students</th>
                    <th class="col-md-3"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($exams as $exam)
                    <tr>
                        <td style="vertical-align:middle" >
                            {{ $exam->getTerm() }} {{ $exam->getYear() }}</td>
                        <td style="vertical-align:middle">
                            {{ $exam->getName() }}</td>
                        <td style="vertical-align: middle">{{ $numberOfQuestions[$exam->getId()] or '0' }}</td>
                        <td style="vertical-align:middle">{{ $numberOfStudents[$exam->getId()] or '0' }}</td>
                        <!-- edit / clone / delete buttons -->
                        <td style="text-align:right">
                            <a class="btn btn-info" href="{{ url('exam/'.$exam->getId().'/edit') }}">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                Edit
                            </a>
                            <a class="btn btn-default" href="{{ url('exam/'.$exam->getId().'/clone') }}">
                                <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>
                                Clone
                            </a>
                            <a class="btn btn-danger" onclick="showConfirmation({{ $exam->getId() }})">
                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('errors.list')

@endsection


@section('jsArea')

    <script type="text/javascript">

        // set 'Setup' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navSetup').attr('class', 'active');

        function showConfirmation(examId) {
            bootbox.dialog({
                message: "Warning: This will delete all associated students, scores, questions and elements. " +
                    "Do you wish to proceed?",
                title: "Delete Exam",
                buttons: {
                    success: {
                        label: 'Cancel',
                        className: "btn-sm",
                        callback: function() {
                        }
                    },
                    danger: {
                        label: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete',
                        className: "btn-danger btn-sm",
                        callback: function() {
                            // do deletion for examId
                            deleteExam(examId);
                        }
                    }
                }
            });
        }

        function deleteExam(examId) {

            $.ajax({
                url: 'exam/' + examId,
                type:"post",
                data: { _method:"DELETE" },
                success: function(data) {
                    window.location.replace(data.url_redirect);
                },
                error: function() {
                    bootbox.alert("Whoops! The exam failed to delete. Please try again.");
                }
            });
        }
        $(document).ready(function () {
            return false;
        });
    </script>

@endsection


