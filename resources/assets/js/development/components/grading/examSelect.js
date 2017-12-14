var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );
var bootbox = require( 'bootbox' );
var common = require( '../common.js' );

var noStudentsErrorTitle = "No Students";
var noStudentsErrorMessage = "<p class='noStudentsError'>An exam must have at least one student in order to be graded.</p>";

var noQuestionsErrorTitle = "No Questions";
var noQuestionsErrorMessage = "<p class='noQuestionsError'>An exam must have at least one question in order to be graded.</p>";

$( 'a[data-href]' ).on( "click", function () {

    var parent = $( this ).closest( 'tr' );
    var numStudents = parent.find( '.numStudents' ).text();
    var numQuestions = parent.find( '.numQuestions' ).text();
    console.log( 'numStudents', numStudents );
    window.console.log( 'numQuestions', numQuestions );
    if ( numQuestions == '0' ) {
        showError( noQuestionsErrorTitle, noQuestionsErrorMessage );
    }
    else if ( numStudents == '0' ) {
        showError( noStudentsErrorTitle, noStudentsErrorMessage );
    }
    else {
        document.location = $( this ).data( 'href' );
    }
} );

function showError( msgTitle, message ) {
    bootbox.dialog( {
        message: message,
        title: msgTitle,
        buttons: {
            default: {
                label: 'Ok',
                className: "btn btn-sm btn-primary",
                callback: function () {
                }
            }
        }
    } );
}