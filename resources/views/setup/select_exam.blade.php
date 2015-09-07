<!--
/**
* Created by PhpStorm.
* User: Brian
* Date: 7/17/2015
* Time: 4:59 PM
*/


-->

@extends('layouts.master')

@section('pageTitle', 'Select Exam')

@section('description', 'Create, edit, clone or delete an exam')

@section('cssLinks')

@endsection

@section('body')

<style type="text/css">
    a {
        cursor: pointer;
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
    <div class="well-lg">
        <div class="panel panel-default" <?php if( sizeof($exams) == 0 ) { echo('style="display:none;"');} ?> >
            <table class="table">
                <tbody>
                @foreach($exams as $exam)
                    <tr>
                        <td class="col-md-2" style="vertical-align:middle">
                            {{ $exam->getTerm() }} {{ $exam->getYear() }}
                        </td>
                        <td class="col-md-5" style="vertical-align:middle">
                            {{ $exam->getName() }}
                        </td>
                        <td class="col-md-5" style="text-align:right">
                            <a class="btn btn-info" href="{{ url('exam/'.$exam->getId().'/edit') }}">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                Edit Exam
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


