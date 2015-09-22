<!-- Release an exam, un-release an exam, view analytics and review student feedback -->
@extends('layouts.master')
@section('pageTitle', 'Reports | gradeomatic')
@section('description', 'Select an exam action')
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
        <h3><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Reports & Release</h3>
        <h4>Release grades to students or view data about an exam</h4>
        <div class="well-lg">
            <div class="panel panel-default">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="col-md-1">Term</th>
                        <th class="col-md-7">Name</th>
                        <th class="col-md-4"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ( sizeof($exams) > 0 )
                        @foreach($exams as $exam)
                            <?php $examId = $exam->id or '0'; ?>
                            @include('reports.exam_controls_tr')
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
    @include('errors.list')

@endsection


@section('jsArea')

    <script type="text/javascript">

        // set 'Reports' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navReport').attr('class', 'active');

        //set controls for all released exams

        $('[id^="exam"]').each(function () {
            if ($(this).attr('data-released') == '1') {
                setAsReleased($(this));
                enableLock($(this).siblings('#lock'));
            }
        });

        function confirmRelease(examId) {
            var released = $('#exam' + examId).attr('data-released');
            var confirmMsg = "Releasing this exam will e-mail all students \n their grades and personalized feedback. " +
                    "Do you wish to continue?";
            if (released === '1') confirmMsg = "Re-releasing this exam sends all students an additional message informing them " +
                    "that exam grades or comments may have changed. Do you wish to continue?";
            bootbox.confirm(confirmMsg, function (result) {
                if (result) {
                    releaseExam(examId);
                }
            });
        }

        // Compiles student scores and stats, then sends notification emails to all graded students
        // who have not yet received an email. Normally, this will be most (if not all) of the class.
        // Any late graded exams can be processed by releasing again
        // or individually via the student controls page
        function releaseExam(examId) {
            var $exam = $('#exam' + examId);
            $exam.addClass('disabled');
            var path = "/report/" + examId + "/release";
            $.ajax({
                url: path,
                type: 'GET',
                success: function () {
                    setAsReleased($exam);
                    alertEmailSent();
                    enableLock($exam.siblings('#lock'));
                },
                error: function () {
                    alert("Sorry, there was a problem releasing this exam!\nPlease try again.");
                },
                complete: function () {
                    $exam.removeClass('disabled');
                }
            });
        }

        function alertEmailSent() {
            bootbox.alert("All students have been e-mailed!", function () {
            });
        }

        // removes student access to the exam, deleting any response keys that have been generated.
        function removeAccess(examId) {
            bootbox.confirm('Removing access will prevent students from viewing feedback on the exam. Access can ' +
                    'be restored by releasing the exam again.', function (result) {
                var $exam = $('#exam' + examId);
                $exam.addClass('disabled');
                if (result) {
                    var path = "/report/" + examId + "/unrelease";
                    $.ajax({
                        url: path,
                        type: 'GET',
                        success: function () {
                            disableLock($exam.siblings('#lock'));
                            setAsUnreleased($exam);
                        },
                        error: function () {
                            $exam.removeClass('disabled');
                            alert("Sorry, there was a problem locking this exam!\nPlease try again.");
                        },
                        complete: function () {
                            $exam.removeClass('disabled');
                        }
                    });
                }
            });
        }

        // changes the visuals and status for a released exam
        function setAsReleased($exam) {
            $exam.attr('data-released', '1');
            $exam.attr('class', 'btn btn-success');
            $exam.html("<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>" +
                    " Released");
        }

        // sets release exam button
        function setAsUnreleased($exam) {
            $exam.attr('data-released', '0');
            $exam.attr('class', 'btn btn-primary');
            $exam.html("<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>" +
                    " Release Exam");
        }

        // Enables the "remove access" button for the exam
        function enableLock($btnLock) {
            $btnLock.removeClass('btn-default disabled');
            $btnLock.addClass('btn-primary');
        }

        function disableLock($btnLock) {
            $btnLock.removeClass('btn-primary');
            $btnLock.addClass('btn-default disabled');
        }

    </script>
@endsection


