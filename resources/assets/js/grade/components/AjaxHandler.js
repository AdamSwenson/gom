/**
 * Created by adam on 5/15/16.
 */
var $ = require('jquery');
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

var bootbox = require('bootbox');

/**
* Responsible for all ajax server interactions
* @type {{me: *, messages: {serverErrorTitle: string, serverErrorText: string, serverTimeoutTitle: string, serverTimeoutText: string}, updateAndSaveComment: AjaxHandler.updateAndSaveComment, createGradeRequest: AjaxHandler.createGradeRequest, saveDataWithTime: AjaxHandler.saveDataWithTime, deleteScoreRequest: AjaxHandler.deleteScoreRequest, showWarningMessage: AjaxHandler.showWarningMessage}}
*/
module.exports = {

    /**
     * All messages which may be displayed to the
     * user in alerts or modals
     * @type {{}}
     */
    messages: {
        serverErrorTitle: "Error",
        serverErrorText: "<p class='errorText errorMessage'>Sorry, there was a problem saving this exam! <br /> Please try again.</p>",

        serverTimeoutTitle: 'No Response From Server',
        serverTimeoutText: "<p class='errorText timeoutMessage'>There was no response from the server. Either the server is down <br/> or you may be experiencing connection issues.</p>",
    },

//     /**
//      * updates a comment locally and saves to server
//      *
//      * DEPRECATING THIS
//      * splitting into
//      *
//      * @param $comment
//      */
//     updateAndSaveComment: function ( $comment, data, Roster ) {
//         $comment.removeAttr( 'readonly' );
//
//         //grab element and its properties
//         var $element = $comment.parents( '[id^="element"]' );
//         var eleIndex = $element.attr( 'data-element-index' );
//         var elementId = $element.attr( 'data-element-id' );
//
//         //grab score and comment
//         var score = data.elementScores[ Roster.activeStudent ][ eleIndex ];
//         var commentText = $comment.val();
//
//         //store comment text in data object
//         data.elementComments[ Roster.activeStudent ][ eleIndex ] = commentText;
//
// window.console.log('updateAndSaveComment', eleIndex, elementId, score, commentText);
//
//         this.createGradeRequest( 'element_id', elementId, score, commentText, Roster );
//     },

    saveComment: function ( data, Roster, elementId, score, commentText) {
        this.createGradeRequest( data, 'element_id', elementId, score, commentText, Roster );
    },


    /**
     * Creates a key/value array GradeRequest to upload.
     * Params: dataType: the label for thing to be modified
     *      elementId: question or element ID to receive the update
     *      score: the score for the question or element
     *      comment: text of the comment to update. Null unless modifying an element comment.
     * Requests will only include non-null scores and comments
     */
    createGradeRequest: function ( data, dataType, dataId, score, comment, Roster ) {
        var gradeRequest = {};

        gradeRequest[ dataType ] = dataId;
        if ( score !== null ) {
            gradeRequest[ 'score' ] = score;
        }
        if ( comment !== null ) {
            gradeRequest[ 'comment_text' ] = comment;
        }
        gradeRequest[ 'student_id' ] = Roster.getActiveStudentId();

        this.saveDataWithTime( gradeRequest, data, Roster );
    },

    /**
     * add time info to the gradeRequest and pass to server
     * @param gradeRequest
     */
    saveDataWithTime: function ( gradeRequest, data, Roster ) {
        var me = this;
        if ( ! gradeRequest ) {
            gradeRequest = {};
            gradeRequest[ 'student_id' ] = Roster.getActiveStudentId();
        }
        gradeRequest[ 'time' ] = data.getStudentGradingTime(Roster.activeStudent );
        var examId = $( 'h3' ).attr( 'data-exam-id' );

        $.ajax( {
            url: examId,
            data: gradeRequest,
            type: 'POST',
            success: function () {
                //console.log('success! ');
            },
            error: function () {
                me.showWarningMessage( me.messages.serverErrorTitle, me.messages.serverErrorText );
            },
            timeout: function () {
                me.showWarningMessage( me.messages.serverTimeoutTitle, me.messages.serverTimeoutText );
            }
        } );
    },

    /**
     * Sends a request to delete a score
     * @param questionAssId
     * @param Roster
     */
    deleteScoreRequest: function ( questionAssId, Roster, ) {
        var me = this;
        var examId = $( 'h3' ).attr( 'data-exam-id' );
        var gradeRequest = {};
        gradeRequest[ 'question_assignment_id' ] = questionAssId;
        gradeRequest[ 'student_id' ] = Roster.getActiveStudentId();
        $.ajax( {
            url: examId,
            data: gradeRequest,
            type: 'DELETE',
            success: function () {
            },
            error: function () {
                me.showWarningMessage( me.messages.serverErrorTitle, me.messages.serverErrorText );
            },
            timeout: function () {
                me.showWarningMessage( me.messages.serverTimeoutTitle, me.messages.serverTimeoutText );
            }
        } );
    },

    /**
     * Displays a bootstrap warning modal
     * @param title
     * @param msg
     */
    showWarningMessage: function ( title, msg ) {
        msg = '<span class="glyphicon glyphicon-warning-sign text-danger" aria-hidden="true"></span> ' + msg;
        bootbox.dialog( {
            message: msg,
            title: title,
            buttons: {
                default: {
                    label: 'Cancel',
                    className: "btn btn-sm btn-primary",
                    callback: function () {
                    }
                }
            }
        } );
    }

};