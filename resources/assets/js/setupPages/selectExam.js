var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );
require('bootbox');

var common = require( '../common.js' );

function showConfirmation(examId) {
    bootbox.dialog({
        message: '<span class="glyphicon glyphicon-warning-sign text-danger" aria-hidden="true"></span> ' +
        "Warning: This will delete all associated students, scores, questions and elements. " +
        "<br/>Do you wish to proceed?",
        title: "Delete Exam",
        buttons: {
            success: {
                label: 'Cancel',
                className: "btn-sm",
                callback: function () {
                }
            },
            danger: {
                label: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete',
                className: "btn-danger btn-sm",
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