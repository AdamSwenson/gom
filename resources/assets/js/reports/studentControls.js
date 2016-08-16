var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );

var bootbox = require('bootbox');

var common = require( '../common.js' );


$('.confirmStudentEmail' ).on('click', function(){
    var studentId = $(this ).data('studentid');
    confirmEmail(studentId);
});

//set the display for all emailed students
$('[id^="studentId"]').each(function () {
    if (!$(this).attr('data-graded')) {
        $(this).addClass('disabled');
        $(this).text('Not Graded');
    } else if ($(this).attr('data-emailed') == '1') {
        setAsEmailed($(this));
    }
});

// Disable 'review' button if feedback is not available
$('#btnReview').each(function () {
    if (!$(this).data('feedback-available')) {
        $(this).addClass('disabled');
    }
});

function confirmEmail(studentId) {

    // Display error if email is blank
    var email = $('[id^="studentEmail' + studentId + '"]').text();
    if (email.length == 0) {
        bootbox.alert('No email for this student');
        return false;
    }
    var released = $('#studentId' + studentId).attr('data-emailed');
    var confirmMsg = "This will email the student with a link containing their grade and feedback.";
    if (released === '1') {
        confirmMsg = "This will re-send the notification email, informing the student that their exam has been graded.";
    }
    // confirm and email student
    bootbox.confirm(confirmMsg, function (result) {
        if (result) {
            var examId = $('#examTitle').attr('data-exam-id');
            var $student = $('#studentId' + studentId);
            $student.addClass('disabled');
            var path = "/report/" + examId + "/students/" + studentId;
            $.ajax({
                url: path,
                type: 'POST',
                success: function () {
                    setAsEmailed($student);
                    alertEmailSent($student.closest('tr'));
                },
                error: function () {
                    alert("Sorry, there was a problem emailing this student!");
                },
                complete: function () {
                    $student.removeClass('disabled');
                }
            });
        }
    });
}

function alertEmailSent($tr) {
    var email = $tr.find('[id^="studentEmail"]').text();
    bootbox.alert("An email has been sent to " + email + ".", function () {
    });
}

// changes the visuals and status for a released exam
function setAsEmailed($student) {
    $student.attr('data-emailed', '1');
    $student.attr('class', 'btn btn-success');
    $student.html("<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>" +
        " Email Sent");
}
