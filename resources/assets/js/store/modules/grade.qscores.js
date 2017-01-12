/**
 * Created by adam on 10/7/16.
 */

import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'

const state = {

    /**
     * Object containing empty slots and actual scores for each
     * student on the exam. Structure of items:
     *      {studentIndex : {questionIndex: score}]
     * Use getters and setters to access
     */
    questionScores: {},

};

const mutations = {

    /**
     * Consume a json object and overwrite questionScores with the data
     * @param state
     * @param rootState
     * @param payload
     */
        [mTypes.populateQuestionScores](state, rootState, payload){
        state.questionScores = payload;
    },

    /**
     * Saves a question score for the student
     * Original: data.this.questionScores[ Roster.activeStudent ][ qNumber - 1 ] = score;
     * @param studentIndex
     * @param questionIndex 0-based index of the question (i.e., questionNumber - 1
     * @param score
     */
        [mTypes.storeQuestionScore](state, rootState, payload) {
        let {studentIndex, questionIndex, score} = payload;
        state.questionScores[studentIndex][questionIndex] = score;
    },


};

const actions = {
    /**
     * Loads a json object of question scores.
     * @todo might be better if didn't overwrite but rather iterate the incoming and update
     * @todo This need not be limited to json objects
     * @param questionScoresJSON
     */
        [aTypes.loadQuestionScores]({state, commit}, questionScoresJSON)
    {
        commit(mTypes.populateQuestionScores, questionScoresJSON);
    },

    /**
     * Save a question score for the currently active student
     * @param state
     * @param commit
     * @param payload
     */
        [aTypes.storeQuestionScoreForActiveStudent]({state, commit}, payload)
    {
        // window.console.log( 'store called', this.activeStudentIndex, questionIndex, score );
        let {questionIndex, score} = payload;
        let studentIndex = this.activeStudentIndex;
        //type checking
        let out = {questionIndex: questionIndex, studentIndex: studentIndex, score: score};
        commit(mTypes.storeQuestionScore, out);
    }
};

const getters = {

    /**
     * Returns student score for question
     * Old way: data.this.questionScores[ Roster.activeStudent ][ index ];
     * @param studentIndex
     * @param questionIndex
     */
    getQuestionScore(state, getters, rootState, studentIndex, questionIndex) {
        return state.questionScores[studentIndex][questionIndex];
    },


    /**
     * Convenience function for getting the current student's score for question
     * Old way: data.this.questionScores[ Roster.activeStudent ][ index ];
     * @param questionIndex
     */
    getQuestionScoreForActiveStudent(state, getters, rootState, questionIndex) {
        // if ( ! this.isActive() ) throw "ERROR: getQuestionScoreForActiveStudent | No active student set ";
        if (state.activeStudentIndex == null) return '';
        return state.getQuestionScore(this.activeStudentIndex, questionIndex);
    }


};


export default {
    actions,
    getters,
    mutations,
    state,
}