var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;
require( 'bootstrap' );

/**
 * Responsible for managing and displaying grading statistics
 * @type {{updateExamGrades: Dashboard.updateExamGrades, examsGraded: Dashboard.examsGraded, updateGradedRemainingCounter: Dashboard.updateGradedRemainingCounter}}
 */
module.exports = {

    /**
     * Deprecated. Now handled by method in data object
     *
     *
     *
     * examGrades[] keeps a persistent total of the exam score for each student.
     * Exams without grades have a value of -1, because dealing with null and NaN
     * is unpredictable across js and PHP.
     * This shouldn't be an issue, as the DB has no notion of exam grades, they're
     * only used here as a shorthand to store and quickly find information about
     * the exam state.
     *
     * @param data
     */
    updateExamGrades: function ( data ) {
        // for ( var i = 0; i < data.questionScores.length; i ++ ) {
        //     var totalScore = null;
        //     data.questionScores[ i ].forEach( function ( gradeEntry ) {
        //         if ( gradeEntry !== null && gradeEntry >= 0 ) {
        //             if ( totalScore === null ) {
        //                 totalScore = 0;
        //             }
        //             totalScore += parseFloat( gradeEntry );
        //         }
        //     } );
        //     if ( totalScore != null ) {
        //         data.examGrades[ i ] = totalScore.toPrecision( 3 );
        //     }
        //     else {
        //         data.examGrades[ i ] = - 1;
        //     }
        // }
    },


    /**
     * This manages the number graded and number of exams remaining fields.
     * Updates the "graded: xx remaining: xx" counters
     * also displays the "Save & Finish" button when remaining == 0
     */
    updateGradedRemainingCounter: function ( data ) {
        var total = data.getTotalExams();
        var graded = data.getNumberGraded();
        var remaining = total - graded;

        $( "#graded" ).text( graded );
        $( "#remaining" ).text( remaining );

        //show finish button
        if ( remaining === 0 ) {
            $( '#finishButton' ).show();
        }
    }

};

