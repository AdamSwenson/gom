var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );
var bootbox = require( 'bootbox' );
var common = require( '../common.js' );


$( 'a[data-href]' ).on( "click", function () {

    var parent = $( this ).closest( 'tr' );
    console.log( parent.find( '#numStudents' ).text() );
    if ( parent.find( '#numStudents' ).text() == '0' ) {
        showError( "No Students", "An exam must have at least one student in order to be graded." )
    } else if ( parent.find( '#numQuestions' ).text() == '0' ) {
        showError( "No Questions", "An exam must have at least one question in order to be graded." )
    } else {
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
                className: "btn-sm",
                callback: function () {
                }
            }
        }
    } );
}