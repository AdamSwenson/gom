/**
 * Created by adam on 5/19/16.
 */

/**
 *
 *
 *
 * STILL NOT SURE IF GOING TO USE LIKE THIS
 *
 *
 *
 *
 */
var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

module.exports = {

    stockComments: {},

    elementComments: {},

    elementScores : {},
    stockComments: null,
    elementComments: null,
    elementScores: null,
    questionScores: null,
    examGradingTimes: null,
    examGrades: null,
    numQuestions: false,

    /**
     * Stores a student's score on a particular element
     * @param activeStudent
     * @param elementIndex
     * @param score
     */
    storeElementScore: function ( activeStudent, elementIndex, score ) {
        this.elementScores[ activeStudent ][ elementIndex ] = score;
    },

    /**
     * Retrieves element score for a student
     * Original: data.elementScores[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param elementIndex
     * @returns {*}
     */
    getElementScore: function ( activeStudent, elementIndex ) {
        return this.elementScores[ activeStudent ][ elementIndex ];
    },


    /**
     * Store the comment text for an element.
     *
     * If on the first slider move, the incoming commentText
     * will be an empty string. That's okay. The initial value
     * of the comment in the data object is an empty string.
     * So we save it anyway. The stock comment will be
     * retrieved on the call to getCommentText.
     *
     @param activeStudent
     * @param elementIndex
     * @param commentText
     */
    storeCommentText: function ( activeStudent, elementIndex, commentText ) {
        this.elementComments[ activeStudent ][ elementIndex ] = commentText;
    },


    /**
     * Retrieve comment text for a student.
     * If no customized text is set, then return stockComment.
     *
     * Original: data.elementComments[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param elementIndex
     * @returns {*}
     */
    getCommentText: function ( activeStudent, elementIndex, valence ) {
        var comment = this.elementComments[ activeStudent ][ elementIndex ];
        if ( comment == "" ) {
            return this.stockComments[ elementIndex ][ valence ];
        }

        return comment;
    },


    /**
     * Saves a question score for the student
     * Original: data.questionScores[ Roster.activeStudent ][ qNumber - 1 ] = score;
     * @param activeStudent
     * @param questionIndex 0-based index of the question (i.e., questionNumber - 1
     * @param score
     */
    storeQuestionScore : function(activeStudent, questionIndex, score){
        this.questionScores[ activeStudent ][ questionIndex ] = score;

    },

    /**
     * Returns student score for question
     * Old way: data.questionScores[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param questionIndex
     */
    getQuestionScore: function(activeStudent, questionIndex){
        return this.questionScores[ activeStudent ][ questionIndex ];
    },


    /**
     * Stores a new time for the student.
     * Overwrites any existing value.
     * Original: data.examGradingTimes[ Roster.activeStudent ];
     */
    storeStudentGradingTime : function(activeStudent, activeStudentTime){
        this.examGradingTimes[ activeStudent ] = activeStudentTime;
    },

    /**
     * Increases the stored time for a student by the specified
     * amount.
     * Original: data.examGradingTimes[ Roster.activeStudent ];
     */
    increaseStudentGradingTime : function(activeStudent, timeToAdd){
        this.examGradingTimes[ activeStudent ] += timeToAdd;
    },



    /**
     * Original: data.examGradingTimes[ Roster.activeStudent ]
     * @param activeStudent
     * @returns {*}
     */
    getStudentGradingTime: function(activeStudent){
        return this.examGradingTimes[ activeStudent ];
    },


    /**
     * Updates the stored total exam score for the student
     * The first time it runs, it will set the total score to 0
     * if no questions have been graded.
     */
    updateExamGrade: function(activeStudent){
        var totalScore = 0;
        for(var i=0; i < this.questionScores[ activeStudent ].length; i++){
            var v = this.questionScores[ activeStudent ][i];
            totalScore += v === null ? 0 : v;
        }
        this.examGrades[activeStudent] = totalScore;
    },


    /**
     * Returns the number of exams that have been graded
     */
    getNumberGraded : function(){
        var graded = 0;
        if(typeof this.examGrades != 'undefined') {
            for ( var i = 0; i < this.examGrades.length; i ++ ) {
                //this will be the string 'letter grade' if
                //no grade has been entered. Thus we check
                //whether it is a number 0 or greater
                if ( this.examGrades[ i ] >= 0 ) graded ++;
            }
        }
        return graded;
    },

    /**
     * Returns the total number of exams
     *
     * TODO Store this value after first run
     *
     * @returns {number|Number}
     */
    getTotalExams : function(){
        if(typeof this.examGrades == 'undefined'){
            var total = 0;
        }else{
            var total = Object.keys(this.examGrades).length;
        }

        return total;
    }


}