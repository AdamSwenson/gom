

/**
 * Object transmitted with requests about questionScores
 * @param studentIndex
 * @param questionIndex
 * @param questionAssignmentId
 */
const QuestionScoreRequest = function(studentIndex, questionIndex, questionAssignmentId){
    this.studentIndex = studentIndex;
    this.questionIndex = questionIndex;
    this.questionAssignmentId = questionAssignmentId;
};


const CommentRequest = function(studentIndex, elementIndex, elementId){
    this.elementId = elementId;
    this.elementIndex = elementIndex;
    this.studentIndex = studentIndex;
};

const ElementScoreRequest =function(studentIndex, elementIndex, score, elementId){
    this.studentIndex = studentIndex;
    this.elementIndex= elementIndex;
    this.score = score;
    this.elementId = elementId;
};

const StudentSelectEvent = function(studentName, studentIdentifier){
    this.studentName = studentName;
    this.studentIdentifier = studentIdentifier;
};

/**
 * Responsible for all ajax server interactions.
 * Also handles user notifications in the event of server errors.
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


    events: {},

    requests: {

        /**
         * Request to update a comment
         * @param studentId
         * @param elementId
         * @param commentText
         * @param score
         */
        commentRequest: function ( studentId, elementId, commentText, score, time ) {
            this.comment_text = commentText;
            this.element_id = elementId;
            this.student_id = studentId;
            if ( score ) {
                this.score = score;
            }

            if ( time ) {
                this.time = time;
            }

        },

        /**
         * Request to update the score of an element without updating the comment
         * @param studentId
         * @param elementId
         * @param score
         * @param time
         */
        elementScoreRequest: function ( studentId, elementId, score, time ) {
            this.element_id = elementId;
            this.student_id = studentId;
            this.score = score;

            if ( time ) {
                this.time = time;
            }

        },

        /**
         * Request for updating a question score
         * @param studentId
         * @param questionAssignmentId
         * @param score
         */
        questionScoreRequest: function ( studentId, questionAssignmentId, score, time ) {
            this.question_assignment_id = questionAssignmentId;
            this.student_id = studentId;
            this.score = score;

            if ( time ) {
                this.time = time;
            }
        },

        /**
         * Request to update only the time
         * @param studentId
         * @param time
         */
        timeRequest: function ( studentId, time ) {
            this.student_id = studentId;
            this.time = time;
        }

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
     * Creates a key/value array GradeRequest with the expected fields to upload.
     * Requests will only include non-null scores and comments
     *
     * Params:
     * @param studentId: The id of the student in the database
     * @param dataType: the field name for thing to be modified. Acceptable values include: 'element_id'
     * @param dataId: question or element ID to receive the update
     * @param score: the score for the question or element
     * @param comment: text of the comment to update. Null unless modifying an element comment.
     * @returns Object
     */
    createGradeRequestObject: function ( studentId, dataType, dataId, score, comment, time ) {
        let gradeRequest = {};

        gradeRequest.student_id = studentId;

        gradeRequest[ dataType ] = dataId;

        if ( score !== null ) {
            gradeRequest.score = score;
        }
        if ( comment !== null ) {
            gradeRequest.comment_text = comment;
        }

        if ( time !== null ) {
            gradeRequest.time = time;
        }

        return gradeRequest;
    },

    /**
     * Sends a request to delete a score
     * @param examId
     * @param studentId
     * @param questionAssId
     */
    deleteScoreRequest: function ( examId, studentId, questionAssId ) {
        let me = this;
        let wasSuccessful = false;

        let gradeRequest = {};
        gradeRequest[ 'question_assignment_id' ] = questionAssId;
        gradeRequest[ 'student_id' ] = studentId;

        $.ajax( {
            url: examId,
            data: gradeRequest,
            type: 'DELETE',
            success: function () {
                wasSuccessful = true;

            },
            error: function () {
                me.showWarningMessage( me.messages.serverErrorTitle, me.messages.serverErrorText );
            },
            timeout: function () {
                me.showWarningMessage( me.messages.serverTimeoutTitle, me.messages.serverTimeoutText );
            }
        } );

        return wasSuccessful;
    },

    /**
     * Sends a request to delete a score
     * @param questionAssId
     * @param Roster
     */
    deleteScoreRequest2: function ( questionAssId, Roster ) {
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

    // createTimeRequestObject: function ( studentId, time ) {
    //     let timeRequest = {};
    //     timeRequest.student_id = studentId;
    //     timeRequest.time = time;
    //
    //     return timeRequest;
    // },

    /**
     * Pass request to server.
     * Not for use with deletion requests
     * @param request
     */
    sendRequest: function ( examId, request ) {
        let wasSuccessful = false;
        let me = this;

        if ( (typeof examId != 'undefined') && (typeof request != 'undefined') && (examId !== null) && (request !== null) ) {
            $.ajax( {
                url: examId,
                data: request,
                type: 'POST',
                success: function () {
                    wasSuccessful = true;
                },
                error: function () {
                    me.showWarningMessage( me.messages.serverErrorTitle, me.messages.serverErrorText );
                },
                timeout: function () {
                    me.showWarningMessage( me.messages.serverTimeoutTitle, me.messages.serverTimeoutText );
                }
            } );
        }

        return wasSuccessful;
    },

    /**
     * Pass request to record time to server.
     * Not for use with deletion requests
     * @param request
     */
    sendTimeRequest: function ( examId, request ) {
        let wasSuccessful = false;
        let me = this;

        if ( (typeof examId != 'undefined') && (typeof request != 'undefined') && (examId !== null) && (request !== null) ) {
            $.ajax( {
                url: examId + '/time',
                data: request,
                type: 'POST',
                success: function () {
                    wasSuccessful = true;
                },
                error: function () {
                    me.showWarningMessage( me.messages.serverErrorTitle, me.messages.serverErrorText );
                },
                timeout: function () {
                    me.showWarningMessage( me.messages.serverTimeoutTitle, me.messages.serverTimeoutText );
                }
            } );
        }

        return wasSuccessful;
    },


    saveComment: function ( data, Roster, elementId, score, commentText ) {
        this.createGradeRequest( data, 'element_id', elementId, score, commentText, Roster );
    },

    /**
     * add time info to the gradeRequest and pass to server
     * @param gradeRequest
     */
    saveDataWithTime: function ( gradeRequest, data, Roster ) {
        var me = this;
        if ( !gradeRequest ) {
            gradeRequest = {};
            gradeRequest[ 'student_id' ] = Roster.getActiveStudentId();
        }
        gradeRequest[ 'time' ] = data.getStudentGradingTime( Roster.activeStudent );
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