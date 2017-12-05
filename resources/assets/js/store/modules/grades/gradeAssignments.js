/**
 * Created by adam on 12/1/17.
 */
import Vue from 'vue';

import * as mTypes from '../../mutation-types';
import * as aTypes from '../../action-types';
import * as gTypes from '../../getter-types';


import GradeAssignment from '../../../models/GradeAssignment';
import Payload from '../../../models/Payload';

/**
 * Returns true if the new ordering will not
 * mess up the grading structure.
 * Returns false if it will
 * @param payload
 */
const validateOrderingChange = ( payload ) => {
    //todo
}

/**
 * Takes the totalScores array
 * and returns a new sorted array
 * @param totalScores
 * @returns {Array}
 */
const sortTotalScores = ( totalScores, ascending = true ) => {
    let newList = [];

    _.forEach( totalScores, function ( score ) {
        //Get the index of where it should go
        let idx = _.sortedIndex( newList, score );
        //push it into the new array
        newList.splice( idx, 0, score );
    } );

    if ( !ascending ) newList = _.reverse( newList );

    return newList;
}

/**
 * Sorts the grade assignments object
 * by calc value and returns an array of assignments
 * in the selected sort order
 *
 * @param gradeAssignments
 * @param ascending
 */
const sortGradeAssignments = ( gradeAssignments, ascending = true ) => {
    return (function ( gradeAssignments, ascending ) {

        let list = [];

        _.forEach( gradeAssignments, function ( assign ) {
            //Get the index of where it should go
            let idx = _.sortedIndexBy( list, assign, 'calcValue' );
            //push it into the new array
            list.splice( idx, 0, assign );
        } );

        if ( !ascending ) list = _.reverse( list );

        return list;
    })( gradeAssignments, ascending )
}

const gradeGetterForScore = ( gradeAssignments, score ) => {
    return (function ( gradeAssignments, score ) {
        let assignments = sortGradeAssignments( state.gradeAssignments, false );

        for (var j = 0; j < assignments.length; j++) {
            let assign = assignments[ j ];

            if ( score >= assign.minScore ) {
                //if the score clears the cut off,
                // add the calc value to the list
                return assign;
//                list.push( assign.calcValue );
                //once we've recorded it, we skip to the next score
            }
        }
    })( gradeAssignments, score )
}

const state = {

    /**
     * The maximum and minimum scores for each
     * letter grade on an exam
     */
    gradeAssignments: (function () {
        return GradeAssignment.initialize();
    })(),

    totalScores: [],

    /**
     * A list of the calcValues of each grade
     * based on a score and the current distribution
     */
    gradeValues: []


};

const mutations = {
    [ mTypes.updateGradeCutoffs ]: ( state, payload ) => {
        Payload.checkIfPayload( payload );
        Vue.set( payload.obj, payload.updateProp, payload.updateVal );
    },

    /**
     * Overwrites the existing list of total scores
     * with an incoming array.
     * This will sort them in ascending order before
     * saving them
     *
     * @param state
     * @param payload
     */
    [ mTypes.loadTotalScores ]: ( state, payload ) => {
        state.totalScores = sortTotalScores( payload.updateVal );
    }

};

const actions = {

    [ aTypes.updateCutoff ]: ( { state, dispatch, commit, getters }, payload ) => {
        //validate that adding this value won't mess
        //up the proper ordering of the scores

        if ( validateOrderingChange( payload ) ) {
            //Call the mutation
            commit( mTypes.updateGradeCutoffs, payload );

        } else {
            //error handling
        }
    }

};

const getters = {

    [ gTypes.getGradeAssignments ]: ( state, getters, rootState ) => {
        return state.gradeAssignments;
    },

    [ gTypes.getGradeAssignmentsInSortedList ]: ( state, getters, rootState ) => {
        return sortGradeAssignments( state.gradeAssignments );
    },

    /**
     * Gets the minimum score for the represented letter grade
     *
     * @param state
     * @param getters
     * @param rootState
     * @param letterGrade
     * @returns {function(*=)}
     */
    [ gTypes.getCutOffsForLetterGrade ]: ( state, getters, rootState, letterGrade ) => ( letterGrade ) => {
        return (function () {
            return state.gradeAssignments[ letterGrade ];
        })( letterGrade )
    },

    getListOfGradeValues: ( state, getters, rootState ) => {
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

    [ gTypes.getMaxPossibleScore ]: ( state, getters, rootState ) => {
        let score = 0;
        let items = getters[ [ gTypes.getAllItems ] ];

        _.forEach( items, function ( item ) {
            score += !_.isUndefined( item.maxScore ) ? item.maxScore : 0;
        } );

        return score;
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

    [ gTypes.getGradeForScore ]: ( state, getters, rootState, score ) => ( score ) => {
        return (function ( score ) {
            // window.console.log( 'gradeAssignments', 'score', 253, score);
            return gradeGetterForScore( state.gradeAssignments, score );
        })( score );
    }
};


export default {
    actions,
    getters,
    mutations,
    state,
}