/**
 * Functions for use in calculating
 * scores and their letter grade equivalents
 * for individual items, since some users may
 * prefer that way of determining a score.
 *
 * NB, these do not use the centrally set up grade assignments
 * since those are for total exam scores
 */

import GradeAssignment from '../../../models/GradeAssignment';

// /**
//  * Reverse calculates the letter grade to display
//  * based on the total score.
//  * TODO This needs a flag so that we don't infer grades to people who don't want them or who entered a score manually
//  * @param totalScore
//  * @param maxScore
//  */
// export const calculateLetterGradeFromScore = function ( gradeAssignments, maxScore, totalScore ) {
//     totalScore = Number( totalScore );
//     maxScore = Number( maxScore );
//
//     let pctOfTotal = maxScore / totalScore;
//     //multiple by 100 to more easily compare with grades list
//     pctOfTotal = Math.round( pctOfTotal * 100 );
//     let grade = 'Letter grade';
//
//     // window.console.log( maxScore, totalScore, pctOfTotal );
//     for (let i = 0; i < gradeAssignments.length; i++) {
//         let cutOff = Number( gradeAssignments[ i ].calcValue );
//         if ( pctOfTotal >= cutOff ) {
//             grade = gradeAssignments[ i ].displayValue;
//             break;
//         }
//     }
//     return grade;
// };

/**
 * Since some users may want to assign item scores via
 * letter grades, this calculates the appropriate grade assignment
 *
 * When given an item score, this returns the appropriate grade assignment
 * so that we can extract the display value for things like the letter
 * grade button
 *
 *
 * NB This is not for use with total exam scores. Those use cases
 * are handled by the grade assignment modules in the store.
 *
 * @param score
 * @param maxScore
 * @returns {GradeAssignment}
 */
export function calculateGradeAssignmentFromItemScore( score, maxScore ) {
    return (function ( score, maxScore ) {
        score = Number( score );
        maxScore = Number( maxScore );
        let gradeAssignments = GradeAssignment.defaults;
        let gradeAssignment = '';

        //determine what percent of the potential max score
        //our score represents
        let pctOfTotal = score / maxScore;

        for (let i = 0; i < gradeAssignments.length; i++) {
            let cutOff = Number( gradeAssignments[ i ].minScore );
            //cutOff right now assumes that this is out of 100,
            //so we need adjust it for the maxScore which might be
            //different. The easiest way to do this is just to
            //assume that the min score represents the minimum percentage
            cutOff = cutOff / maxScore;
            if ( pctOfTotal >= cutOff ) {
                gradeAssignment = gradeAssignments[ i ];
                break;
            }
        }
        return gradeAssignment;
    })( score, maxScore )
};

/**
 * When given a grade assignment and the maximum possible score for
 * an item, this returns a numerical score
 *
 * NB This is not for use with total exam scores. Those use cases
 * are handled by the grade assignment modules in the store.

 * @param gradeValue
 * @param maxScore
 * @returns {number}
 */
export function calculateItemScoreFromLetterGrade( gradeAssignment, maxScore ) {
    let gradeValue = Number( gradeAssignment.calcValue );
    maxScore = Number( maxScore );
    let result = (gradeValue * .01) * maxScore;
    return roundToTwo( result );
};


/**
 * Handles rounding of the score
 * Cf http://stackoverflow.com/questions/11832914/round-to-at-most-2-decimal-places-in-javascript
 * @param num
 * @returns {number}
 */
export const roundToTwo = function ( num ) {
    return +(Math.round( num + "e+2" ) + "e-2");
};
