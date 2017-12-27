/**
 * Created by adam on 10/7/16.
 */
import * as lmTypes from '../legacy-mutation-types'
import * as laTypes from '../legacy-action-types'
import Payload from '../../models/Payload'

const state = {

    /**
     * Object containing empty slots and actual scores for each
     * student on the exam. Structure of items:
     *      {studentIndex : {questionIndex: score}]
     * Use getters and setters to access
     */
    questionScores: {},

};

const isScoresEmpty = (state)=>{
    if(Object.keys(state.questionScores).length > 0 ){
        return false;
    }
return true;
};

const mutations = {

    /**
     * Saves a question score for the student.
     * Overwrites any existing score
     * Original: data.this.questionScores[ Roster.activeStudent ][ qNumber - 1 ] = score;
     * @param studentIndex
     * @param questionIndex 0-based index of the question (i.e., questionNumber - 1
     * @param score
     */
    [lmTypes.setQuestionScore]: ( state, rootState, payload ) => {
        // console.log( 'mutation.setQuestionScore', payload );
        Payload.checkIfPayload( payload );

        let studentIndex = payload.index;
        let questionIndex = payload.index2;

        state.questionScores[ studentIndex ][ questionIndex ] = payload.num;
    },

    /**
     * Removes a score and its index from the question score store
     * @param state
     * @param rootState
     * @param payload
     */
    [lmTypes.removeQuestionScore]: ( state, rootState, payload ) => {
        Payload.checkIfPayload( payload );

        let studentIndex = payload.index;
        let questionIndex = payload.index2;

        state.questionScores[ studentIndex ][ questionIndex ] = payload.num;
    }



};

const actions = {
    /**
     * Consumes an object of question scores and
     * populates the store with them.
     */
    [laTypes.loadQuestionScores]: ( {state, commit}, payload ) => {
        for ( let i = 0; i < Object.keys( payload ).length; i++ ) {
            actions[ laTypes.setQuestionScore ]( {state, commit}, payload[ i ] );
        }
    },


    /**
     * Saves a question score for the student
     * Overwrites existing score
     * Original: data.this.questionScores[ Roster.activeStudent ][ qNumber - 1 ] = score;
     * @param studentIndex
     * @param questionIndex 0-based index of the question (i.e., questionNumber - 1
     * @param score
     */
    [laTypes.setQuestionScore]: ( {state, commit}, payload ) => {
        //todo add checking

        let pl = new Payload();
        pl.index = payload.studentIndex;
        pl.index2 = payload.questionIndex;
        pl.num = payload.score;

        commit( lmTypes.setQuestionScore, pl );
    },

};

const getters = {

    /**
     * Returns student score for question
     * Old way: data.this.questionScores[ Roster.activeStudent ][ index ];
     * @param studentIndex
     * @param questionIndex
     */
    getQuestionScore( state, getters, rootState, studentIndex, questionIndex ) {
        if(isScoresEmpty(state)) { return false; }

        return state.questionScores[ studentIndex ][ questionIndex ];
    },


};


export default {
    actions,
    getters,
    mutations,
    state,
}