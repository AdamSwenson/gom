import * as gTypes from "../../getter-types";
import { gradeGetterForScore, sortGradeAssignments } from "./grades.helpers";

module.exports = {

    /**
     * Given a score, it returns the appropriate gradeAssignment object
     *
     * @param state
     * @param getters
     * @param rootState
     * @param score
     * @returns {function(*=)}
     */
    [ gTypes.getGradeAssignmentForScore ]: ( state, getters, rootState, score ) => ( score ) => {
        // return (function ( score ) {
        return gradeGetterForScore( state.gradeAssignments, score );
        // })( score );
    },

    /**
     * Returns the state.gradeAssignment object
     * which has letter grade strings as keys and
     * GradeAssignment objects for its values.
     *
     * @param state
     * @param getters
     * @param rootState
     * @returns {*}
     */
    [ gTypes.getGradeAssignments ]: ( state, getters, rootState ) => {
        return state.gradeAssignments;
    },

    [ gTypes.getGradeAssignmentsInSortedList ]: ( state, getters, rootState ) => {
        return sortGradeAssignments( getters[ gTypes.getGradeAssignments ] );
    },

    /**
     * Returns an object with letter grades as keys.
     * The value is the count of total scores falling into each
     * grade's range
     * @param state
     * @param getters
     * @param rootState
     * @returns {{}}
     */
    [ gTypes.getGradeFrequencies ]: ( state, getters, rootState ) => {
        return state.gradeFrequencies;

    },

    /**
     * Returns an array of GradeAssignment objects which
     * have minimum scores that are higher than the next
     * lowest GradeAssignment.
     *
     * @param state
     * @param getters
     * @returns {Array}
     */
    [ gTypes.getInconsistentCutOffs ]: ( state, getters ) => {
        return state.inconsistent;
    },

    /**
     * Returns a list of the calc_values from each grade
     * @param state
     * @param getters
     * @param rootState
     */
    [ gTypes.getListOfGradeValues ]: ( state, getters, rootState ) => {
        return state.gradeValues;
        // return (function ( state ) {
        //     let list = [];
        //     let assignments = sortGradeAssignments( state.gradeAssignments, false );
        //
        //     _.forEach( state.totalScores, function ( score ) {
        //         for (var j = 0; j < assignments.length; j++) {
        //             let assign = assignments[ j ];
        //
        //             if ( score >= assign.minScore ) {
        //                 //if the score clears the cut off,
        //                 // add the calc value to the list
        //                 list.push( assign.calcValue );
        //                 //once we've recorded it, we skip to the next score
        //                 break;
        //             }
        //         }
        //     } );
        //
        //     return list;
        // })( state );

    },


    /**
     * Returns the maximum possible score for the exam.
     * This is either a custom score set on the exam object, or if not,
     * the sum of all item max scores
     * for which the item's countsInTotal flag is set.
     *
     * @param state
     * @param getters
     * @param rootState
     * @returns {number}
     */
    [ gTypes.getMaxPossibleScore ]: ( state, getters, rootState ) => {
        let exam = getters[gTypes.getActiveExam];
        if(! _.isNull(exam) && !_.isNull(exam.customMaxScore)){
            // window.console.log( 'grades.getters', 'custom max', 139, exam.customMaxScore);
            return exam.customMaxScore;
        }

        let score = 0;
        let items = getters[ gTypes.getAllItems ];

        if ( !_.isUndefined( items ) && !_.isNull( items ) ) {
            _.forEach( items, function ( item ) {
                if ( !_.isUndefined( item.maxScore )){
                    if ( item.countsInTotal === 1 ) {
                        score += item.maxScore
                    }
                }
            } );
        }
        return score;
    },


    /**
     * Returns a sorted list of the total scores
     *
     * @param state
     * @param getters
     * @param rootState
     * @returns {Array|*}
     */
    [ gTypes.getTotalScores ]: ( state, getters, rootState ) => {
        return state.totalScores;
    },

};