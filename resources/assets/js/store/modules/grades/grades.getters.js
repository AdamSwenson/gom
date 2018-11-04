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
        //sort them in descending order so that we can
        //use the minimum scores as cut offs
        let assignments = sortGradeAssignments( state.gradeAssignments, false );

        let gradeFrequency = {};

        // calculate frequency that each letter grade appears.
        _.forEach( state.totalScores, function ( score ) {
            // window.console.log( 'gradeAssignments', 'assignment length', 175, assignments.length, assignments );
            for (var j = 0; j < assignments.length; j++) {
                let assign = assignments[ j ];

                //set the count at zero for a grade
                //if it hasn't been initialized already
                if ( !_.has( gradeFrequency, assign.displayValue ) ) {
                    gradeFrequency[ assign.displayValue ] = 0
                }

                if ( score >= assign.minScore ) {
                    //if the score clears the cut off, increment the count
                    gradeFrequency[ assign.displayValue ]++;

                    //once we've recorded it, we skip to the next score
                    break;
                }
            }
        } );

        return gradeFrequency;

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
        return (function ( state ) {
            let list = [];
            let assignments = sortGradeAssignments( state.gradeAssignments, false );

            _.forEach( state.totalScores, function ( score ) {
                for (var j = 0; j < assignments.length; j++) {
                    let assign = assignments[ j ];

                    if ( score >= assign.minScore ) {
                        //if the score clears the cut off,
                        // add the calc value to the list
                        list.push( assign.calcValue );
                        //once we've recorded it, we skip to the next score
                        break;
                    }
                }
            } );

            return list;
        })( state );

    },


    /**
     * Returns a numerical value which is the sum of all item minimum scores
     *
     * @param state
     * @param getters
     * @param rootState
     * @returns {number}
     */
    [ gTypes.getMaxPossibleScore ]: ( state, getters, rootState ) => {
        let score = 0;
        let items = getters[ gTypes.getAllItems ];

        if ( !_.isUndefined( items ) && !_.isNull( items ) ) {
            _.forEach( items, function ( item ) {
                score += (!_.isUndefined( item.maxScore ) && item.countsInTotal) ? item.maxScore : 0;
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