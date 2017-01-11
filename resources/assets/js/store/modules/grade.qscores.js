/**
 * Created by adam on 10/7/16.
 */

import * as types from '../mutation-types'

// export const questionScores = {
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
     * Loads a json object of question scores.
     * @param questionScoresJSON
     */
        [types.loadQuestionScores](state, rootState, questionScoresJSON) {
        state.questionScores = questionScoresJSON;
    },

    /**
     * Saves a question score for the student
     * Original: data.this.questionScores[ Roster.activeStudent ][ qNumber - 1 ] = score;
     * @param studentIndex
     * @param questionIndex 0-based index of the question (i.e., questionNumber - 1
     * @param score
     */
        [types.storeQuestionScore](state, rootState, studentIndex, questionIndex, score) {
        state.questionScores[studentIndex][questionIndex] = score;
    },

    [types.storeQuestionScoreForActiveStudent](state, rootState, questionIndex, score) {
        // window.console.log( 'store called', this.activeStudentIndex, questionIndex, score );
        state.questionScores[this.activeStudentIndex][questionIndex] = score;
    }


};

const actions = {};

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