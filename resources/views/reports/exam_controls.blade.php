@extends('layouts.master')

@section('pageTitle', 'Reports')
@section('description', 'Select an exam action')

@section('cssLinks')
@endsection

@section('body')
    <div class="container">
        <h3><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Report & Release</h3>
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
                            <td class="col-md-8" style="vertical-align:middle">
                                {{ $exam->getName() }}
                            </td>
                            <!-- control buttons -->
                            <td class="col-md-3" style="text-align:right">
                                <a class="btn btn-warning" id="{{'exam'.$exam->getId()}}"
                                   title="Release Exam" data-released="{{ $exam->getReleased() }}"
                                   onclick="confirmRelease({{ $exam->getId()}})">
                                    <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                                    Release Exam
                                </a>
                                <a class="btn btn-primary" title="Exam Analytics"
                                   href="{{url('report/' . $exam->getId() . '/analytics')}}"><span
                                            class="glyphicon glyphicon-stats"
                                            aria-hidden="true"></span> </a>
                                <a class="btn btn-default" title="Student Controls"
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

        //set the display for all released exams
        $('[id^="exam"]').each( function() {
            if ($(this).attr('data-released') == '1'){
                setAsReleased( $(this) );
            }
        });


        function confirmRelease(examId) {
            var released = $('#exam' + examId).attr('data-released');
            var confirmMsg = "Releasing this exam will email all students \n their grades and personalized feedback. " +
                            "Do you wish to continue?";
            if (released) confirmMsg = "Re-releasing this exam sends all students an additional message informing them " +
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
            var path = "/report/" + examId + "/release";
            $.ajax({
                url: path,
                type: 'GET',
                success: function() {
                    setAsReleased( $('#exam' + examId) );
                },
                error: function( ) {
                    alert( "Sorry, there was a problem releasing this exam!\nPlease try again." );
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

    </script>


@endsection


