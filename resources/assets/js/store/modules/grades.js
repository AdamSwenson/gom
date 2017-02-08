/**
 * Vuex component dealing with grades
 *
 * @todo Consider moving standard grades to its own file
 * Created by adam on 10/7/16.
 */


import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'
import Payload from '../models/Payload'

const state = {
    /**
     * examGrades[] keeps a persistent total of the exam score for each student.
     * Exams without grades have a value of -1, because dealing with null and NaN
     * is unpredictable across js and PHP.
     * This shouldn't be an issue, as the DB has no notion of exam grades, they're
     * only used here as a shorthand to store and quickly find information about
     * the exam state.
     */
    examGrades: {},


    /**
     * Standard grades
     * Format:
     *  { {calcValue : int, displayValue: string}, .... }
     * @type {{}}
     */
    standardGrades: {},

};

const mutations = {

    /**
     * Overwrites the state.examGrades with object containing data
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.loadExamGrades]: ( state, rootState, payload ) => {
        Payload.checkIfPayload( payload );
        state.examGrades = payload.obj;
    },

    /**
     * Overwrites the state.standardGrades with object containing data
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.loadStandardGrades]: ( state, rootState, payload ) => {
        Payload.checkIfPayload( payload );
        state.standardGrades = payload.obj;
    },

    /**
     * Updates the value of a grade in examGrades
     * @param studentIndex
     */
    [mTypes.setGrade]: ( state, rootState, payload ) => {
        Payload.checkIfPayload( payload );
        state.examGrades[ payload.index ] = payload.num;
    },
};

const actions = {

    /**
     * Consume a json object and populate the grades state
     * @param state
     * @param rootState
     * @param studentGrades
     */
    [aTypes.loadExamGrades]: ( {state, commit}, studentGrades ) => {
        //todo type checks
        let out = Payload.factory({obj: studentGrades})
        commit( mTypes.loadExamGrades, out);
        // state.examGrades = studentGrades;
    },

    /**
     * Consume a json object and populate the grades  the standard grade cut offs
     * @param gradesJson
     */
    [aTypes.loadStandardGrades]: ( {state, commit}, gradesJson ) => {
        if ( typeof gradesJson == 'string' ) {
            gradesJson = JSON.parse( gradesJson );
        }
        let out = Payload.factory({obj: gradesJson})
        commit(mTypes.loadStandardGrades, out);
        // state.standardGrades = gradesJson;
    },

    /**
     * Updates the stored total exam score for the student
     * The first time it runs, it will set the total score to 0
     * if no questions have been graded.
     **/
    [aTypes.updateExamGrade]: ( {state, commit}, studentIndex ) => {

        var totalScore = null;
        // try {
        // state.checkValid( 'state.questionScores' );
        if ( Object.keys( state.questionScores ).length > 0 ) {
            for ( var i = 0; i < Object.keys( state.questionScores[ studentIndex ] ).length; i++ ) {
                var v = state.questionScores[ studentIndex ][ i ];
                if ( v != null ) {
                    //at least one question score is non-null
                    //so the total score should be at least 0
                    //first we check whether the totalScore is still null
                    //and set it to 0 if not
                    if ( totalScore === null ) {
                        totalScore = 0;
                    }
                    //now we can add the question values to it
                    totalScore += parseFloat( v );
                }
            }
            if ( totalScore != null && totalScore >= 0 ) {
                //push the total score into exam grades as a string
                // state.examGrades[ studentIndex ] = totalScore.toPrecision( 3 );
                let score =  totalScore.toPrecision( 3 );

                let out = Payload.factory({index: studentIndex, num: score});

                commit( mTypes.setGrade, out );

            } else {
                //replace 'letter grade' with -1
                // state.examGrades[ studentIndex ] = -1;
                let out = Payload.factory({index: studentIndex, num: -1});
                commit( mTypes.setGrade, out );
            }
        }
        // } catch ( err ) {
        //     window.console.log( err );
        // }
    }

};

const getters = {

    getExamGrade: ( state, getters, rootState, studentIndex ) => {
        return state.examGrades[ studentIndex ];
    },

    /**
     * Returns the standard grades json.
     * NB, state is not the total scores for students
     * @returns {{}}
     */
    getStandardGrades: ( state, getters, rootState ) => {
        return state.standardGrades;
    },

    /**
     * Returns the standard grades json.
     * NB, state is not the total scores for students
     * @deprecated This now wraps the better named method
     * @returns {{}}
     */
    getGrade: ( state, getters, rootState ) => {
        return getters.getStandardGrades( state, getters, rootState );
    },


};

export default {
    actions,
    getters,
    mutations,
    state,
}