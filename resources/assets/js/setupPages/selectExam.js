var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );

var bootbox = require('bootbox');
var common = require( '../common.js' );


$(".deleteExam").on('click', function(){
   var examId = $(this).data('exam-id');
    window.console.log('deleting ' + examId);
    showConfirmation(examId);
});

function showConfirmation(examId) {
    bootbox.dialog({
        message: '<p id="confirmationModalText"><span class="glyphicon glyphicon-warning-sign text-danger" aria-hidden="true"></span> ' +
        "Warning: This will delete all associated students, scores, questions and elements. " +
        "<br/>Do you wish to proceed?</p>",
        title: "Delete Exam",
        buttons: {
            success: {
                label: 'Cancel',
                className: "cancelDelete btn btn-default btn-sm",
                callback: function () {
                }
            },
            danger: {
                label: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete',
                className: "confirmDelete btn-danger btn-sm",
                callback: function () {
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
        type: "post",
        data: {_method: "DELETE"},
        success: function (data) {
            window.location.replace(data.url_redirect);
        },
        error: function () {
            bootbox.alert("Whoops! The exam failed to delete. Please try again.");
        }
    });
}