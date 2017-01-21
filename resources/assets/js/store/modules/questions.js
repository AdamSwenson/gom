/**
 * Created by adam on 10/7/16.
 */
import Question from './../models/Question';
import Payload from '../models/Payload'
import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'

const state = {
    /** Integer count of questions on the exam */
    numberQuestions: null,
    /**
     * Json of the maximum possible scores for each question.
     * Keys are questionIndexes
     * Format: { questionIndex : maxScore, ... }
     */
    maxQuestionScores: {},

    /**
     * Format: { questionIndex : {questionName, questionNumber, questionAssignmentId, maxScore}, .... }
     * @type {{}}
     */
    questions: {},

};

const mutations = {

    /**
     * Add a score to the max possible score store
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.setMaxQuestionScore]: ( state, rootState, payload ) => {
        Payload.checkIfPayload(payload);
        state.maxQuestionScores[payload.index] = payload.num;
    },

    /**
     * Remove a score (including index) from the max possible score store
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.removeMaxQuestionScore]: ( state, rootState, payload ) => {
        Payload.checkIfPayload(payload);
        state.maxQuestionScores[payload.index] = payload.num;
    },


    /**
     * Push a question object into the store.
     * Overwrites any existing question at the index.
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.setQuestion]: ( state, rootState, payload ) => {
        Payload.checkIfPayload(payload);
        state.questions[payload.index] = payload.obj;
        // let {questionIndex, questionObject} = payload;
        // state.questions[ questionIndex ] = questionObject;
    },

    /**
     * Update the properties of a specific question
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.removeQuestion]: ( state, rootState, payload ) => {
        // let {questionIndex, questionObject} = payload;
        // state.questions[ questionIndex ] = questionObject;
    },


    /**
     * Sets the stored number of questions. Provides the option
     * of having the set number of questions and the number of questions
     * in the array differ.
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.setNumberQuestions]: ( state, rootState, payload ) => {
        if ( Number.isInteger( payload ) ) {
            state.numberQuestions = payload;
        }
        else {
            //count the questions
            state.numberQuestions = Object( state.questions ).keys().length
        }
    }
};

const actions = {
    /**
     * Add a new question to the store of questions
     * todo handle case where payload contains a Question object already
     * @param state
     * @param commit
     * @param payload
     */
    [aTypes.addQuestion]: ( {state, commit}, payload ) => {

        let question = Question.factory( payload);

        if ( question instanceof Question ) {
            let pl = new Payload();
            pl.id = question.id;
            pl.index = payload.questionIndex;
            pl.obj = question;
            commit( mTypes.setQuestion, pl );
        }
        //
        // // let {questionIndex, content} = payload;
        // let question = Question.factory( payload, payload.questionIndex );
        // let out = Payload.factory( {
        //         index: question.questionIndex,
        //         obj: question
        //     });
        //
        // commit( mTypes.setQuestion, out );
    },

    /**
     * Initially loads a json of max scores into the object
     * Format: { questionIndex: maxScore, ....}
     * @param maxScores
     */
    [aTypes.loadMaxQuestionScores]: ( {state, commit}, payload ) => {
        commit( mTypes.loadMaxQuestionScores, payload );
    },

    /**
     * Loads a json object of questions
     * @param payload questionsJson
     */
    [aTypes.loadQuestions]: ( {state, commit}, payload ) => {
        for ( let i = 0; i < Object.keys( payload ).length; i++ ) {
            let index = Object.keys( payload )[ i ];
            let s = payload[ index ];
            state.questions[ index ] = Question.factory( s, index );
        }
    },

    /**
     * Set the number of questions on the exam directly.
     * This decouples the number of questions from the number in the store
     * @param state
     * @param commit
     * @param numberQuestionsOnExam
     */
    [aTypes.loadNumberQuestions]: ( {state, commit}, payload ) => {
        state.numberQuestions = payload;
    },
};

const getters = {
    /**
     * Returns a question object.
     * This has keys: questionName, questionNumber, questionAssignmentId, maxScore
     * @param questionIndex
     * @returns {*}
     */
    getQuestion: ( state, getters, rootState, questionIndex ) => {
        return state.questions[ questionIndex ];
    },

    /**
     * Returns the maximum possible score for a given question
     * @param questionIndex
     * @returns {*}
     */
    getMaxQuestionScore: ( state, getters, rootState, questionIndex ) => {
        return state.maxQuestionScores[ questionIndex ];
    }
};


export default {
    actions,
    getters,
    mutations,
    state,
}






