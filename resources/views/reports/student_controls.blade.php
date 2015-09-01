@extends('layouts.master')

@section('pageTitle', 'Student Controls')
@section('description', 'Email or review student feedback')

@section('cssLinks')
@endsection

@section('body')

    <div class="container">
        <h3 id="examTitle" data-exam-id="{{ $exam->getId() }}">
            <span class="glyphicon glyphicon-user" aria-hidden="true"> </span> Student Controls:
            {{ $exam->getTerm() }} {{ $exam->getYear() }} "{{ $exam->getName() }}"</h3>
        <h4>Send email notifications or review student feedback</h4>
        <div class="well-lg">
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
                        <td style="vertical-align:middle">{{ $student->last_name }}, {{ $student->first_name }}</td>
                        <td style="vertical-align:middle">{{ $student->getEmail() }}</td>
                        <td style="vertical-align:middle">{{ $student->getStudentId()}}</td>
                        <td style="text-align: right;">
                            <a class="btn btn-default" style="width:120px;" id="{{ 'studentId'.$student->getId() }}" title="Email Student"
                               onclick="confirmEmail({{ $student->getId() }})" data-emailed="0">
                                <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Email
                            </a>
                            <a class="btn btn-primary" title="Review Student Feedback"
                               href="{{ url('report/'.$exam->getId().'/students/'.$student->getId()) }}">
                                <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                 Review
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('errors.list')

@endsection


@section('jsArea')
    <script type="text/javascript">

        // set 'Reports' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navReport').attr('class', 'active');

        //set the display for all emailed students
        $('[id^="studentId"]').each( function() {
            if ( $(this).attr('data-emailed')  == '1'){
                setAsEmailed( $(this) );
            }
        });

        function confirmEmail(studentId) {
            var released = $('#studentId' + studentId).attr('data-emailed');
            var confirmMsg = "This will email the student with a link containing their grade and feedback.";
            if (released === '1') {
                confirmMsg = "This will re-send the notification email, informing the student that their exam has been graded.";
            }
            // confirm and email student
            bootbox.confirm(confirmMsg, function(result) {
                if (result) {
                    var examId = $('#examTitle').attr('data-exam-id');
                    var $student = $('#studentId' + studentId);
                    $student.addClass('disabled');
                    var path = "/report/" + examId + "/students/" + studentId;
                    $.ajax({
                        url: path,
                        type: 'POST',
                        success: function() {
                            setAsEmailed( $student );
                        },
                        error: function( ) {
                            alert( "Sorry, there was a problem emailing this student!" );
                        },
                        complete: function() {
                            $student.removeClass('disabled');
                        }
                    });
                }
            });
        }

        // changes the visuals and status for a released exam
        function setAsEmailed($student) {
            $student.attr('data-emailed', '1');
            $student.attr('class', 'btn btn-success');
            $student.html("<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>" +
                    " Email Sent");
        }
    </script>
@endsection


