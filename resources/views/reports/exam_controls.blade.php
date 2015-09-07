@extends('layouts.master')

@section('pageTitle', 'Reports')
@section('description', 'Select an exam action')

@section('cssLinks')
@endsection

@section('body')
    <div class="container">
        <h3><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Reports & Release</h3>
        <h4>Release grades to students or view data about an exam</h4>

        <div class="well-lg">
            <div class="panel panel-default">
                <table class="table">
                    <tbody>
                    @foreach($exams as $exam)
                        <tr>
                            <!-- width will override the column width setting for term info -->
                            <td class="col-md-1" style="vertical-align:middle; width: 10%;">
                                {{ $exam->getTerm() }}
                                {{ $exam->getYear() }}
                            </td>
                            <td class="col-md-7" style="vertical-align:middle">
                                {{ $exam->getName() }}
                            </td>
                            <!-- control buttons -->
                            <td class="col-md-4" style="text-align:right">
                                <a class="btn btn-primary" id="{{'exam'.$exam->getId()}}" style="width:140px;"
                                   title="Release Exam" data-released="{{ $exam->getReleased() }}"
                                   onclick="confirmRelease({{ $exam->getId()}})">
                                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                    Release Exam
                                </a>
                                <a class="btn btn-default disabled" id="lock" title="Remove Access"
                                   onclick="removeAccess({{ $exam->getId() }})" >
                                    <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                                </a>
                                <a class="btn btn-info" title="Exam Analytics"
                                   href="{{url('report/' . $exam->getId() . '/analytics')}}"><span
                                            class="glyphicon glyphicon-stats"
                                            aria-hidden="true"></span> </a>
                                <a class="btn btn-info" title="Student Controls"
                                   href="{{url('report/' . $exam->getId() . '/students')}}"><span
                                            class="glyphicon glyphicon-user" aria-hidden="true"></span> </a>
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

        // set 'Reports' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navReport').attr('class', 'active');

        //set controls for all released exams
        $('[id^="exam"]').each( function() {
            if ($(this).attr('data-released') == '1'){
                setAsReleased( $(this) );
                enableLock( $(this).siblings('#lock') );
            }
        });

        function confirmRelease(examId) {
            var released = $('#exam' + examId).attr('data-released');
            var confirmMsg = "Releasing this exam will e-mail all students \n their grades and personalized feedback. " +
                            "Do you wish to continue?";
            if (released === '1') confirmMsg = "Re-releasing this exam sends all students an additional message informing them " +
                    "that exam grades or comments may have changed. Do you wish to continue?";
            bootbox.confirm(confirmMsg, function(result) {
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
                success: function() {
                    setAsReleased( $exam );
                    alertEmailSent();
                    enableLock( $exam.siblings('#lock') );
                },
                error: function( ) {
                    alert( "Sorry, there was a problem releasing this exam!\nPlease try again." );
                },
                complete: function(){
                    $exam.removeClass('disabled');
                }
            });
        }

        function alertEmailSent() {
            bootbox.alert("All students have been e-mailed!", function() {});
        }

        // removes student access to the exam, deleting any response keys that have been generated.
        function removeAccess(examId) {
            bootbox.confirm('Removing access will prevent students from viewing feedback on the exam. Access can ' +
                    'be restored by releasing the exam again.', function(result){
                var $exam = $('#exam' + examId);
                $exam.addClass('disabled');
                if (result) {
                    var path = "/report/" + examId + "/unrelease";
                    $.ajax({
                        url: path,
                        type: 'GET',
                        success: function() {
                            disableLock( $exam.siblings('#lock'));
                            setAsUnreleased($exam);
                        },
                        error: function( ) {
                            $exam.removeClass('disabled');
                            alert( "Sorry, there was a problem locking this exam!\nPlease try again." );
                        },
                        complete: function(){
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


