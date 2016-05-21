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
    storeElementScore : function(activeStudent, elementIndex, score){
        this.elementScores[ activeStudent ][ elementIndex ] = score;
    },

    /**
     * Retrieves element score for a student
     * @param activeStudent
     * @param elementIndex
     * @returns {*}
     */
    getElementScore : function(activeStudent, elementIndex){
        return this.elementScores[ activeStudent ][ elementIndex ];
    },


/**
     * Store the comment text for an element
     * @param activeStudent
     * @param elementIndex
     * @param commentText
     */
    storeCommentText: function ( activeStudent, elementIndex, commentText ) {
        this.elementComments[ activeStudent ][ elementIndex ] = commentText;
    },


    /**
     * Retrieve comment text for a student.
     * If no customized text is set, then return stockComment
     * @param activeStudent
     * @param elementIndex
     * @returns {*}
     */
    getCommentText : function(activeStudent, elementIndex, valence){
        var comment = this.elementComments[ activeStudent ][ elementIndex ];
        if(comment == ""){
            return this.stockComments[ elementIndex ][ valence ];
        }

        return comment;
    }



}