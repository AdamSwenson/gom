var $ = require('jquery');
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;
require('bootstrap');

/**
 * Responsible for managing and displaying grading statistics
 * @type {{updateExamGrades: Dashboard.updateExamGrades, examsGraded: Dashboard.examsGraded, updateGradedRemainingCounter: Dashboard.updateGradedRemainingCounter}}
 */
module.exports = {

    /**
     * examGrades[] keeps a persistent total of the exam score for each student.
     * Exams without grades have a value of -1, because dealing with null and NaN is unpredictable across js and PHP.
     * This shouldn't be an issue, as the DB has no notion of exam grades, they're only used here as a shorthand
     * to store and quickly find information about the exam state.
     */
    updateExamGrades: function ( data ) {
        for ( var i = 0; i < data.questionScores.length; i ++ ) {
            var totalScore = null;
            data.questionScores[ i ].forEach( function ( gradeEntry ) {
                if ( gradeEntry !== null && gradeEntry >= 0 ) {
                    if ( totalScore === null ) {
                        totalScore = 0;
                    }
                    totalScore += parseFloat( gradeEntry );
                }
            } );
            if ( totalScore != null ) data.examGrades[ i ] = totalScore.toPrecision( 3 );
            else {
                data.examGrades[ i ] = - 1;
            }
        }
    },

    /**
     * returns: # of exams graded
     * @returns {number}
     */
    examsGraded: function ( data ) {
        var graded = 0;
        for ( var i = 0; i < data.examGrades.length; i ++ ) {
            if ( data.examGrades[ i ] >= 0 ) graded ++;
        }
        return graded;
    },

    /**
     * update the "graded: xx remaining: xx" counters
     * also displays the "Save & Finish" button when remaining == 0
     */
    updateGradedRemainingCounter: function ( data ) {
        var total = data.examGrades.length;
        var graded = this.examsGraded( data );
        var remaining = total - graded;
        $( "#graded" ).text( graded );
        $( "#remaining" ).text( remaining );
        if ( remaining === 0 ) {
            $( '#finishButton' ).show();
        }
    }

};

