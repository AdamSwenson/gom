/**
 * Created by adam on 10/7/16.
 */
import Question from './Question';

export const Questions = {
    state: {
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

    },
    mutations: {
        /**
         * Initially loads a json of max scores into the object
         * Format: { questionIndex: maxScore, ....}
         * @param maxScores
         */
        loadMaxQuestionScores( state, rootState, maxScores ) {
            state.maxQuestionScores = maxScores;
        },

        /**
         * Loads a json object of questions
         */
        loadQuestions( state, rootState, questionsJson ) {
            for ( let i = 0; i < Object.keys( questionsJson ).length; i ++ ) {
                let index = Object.keys( questionsJson )[ i ];
                let s = questionsJson[ index ];
                state.questions[ index ] = Question.factory( s, index );
            }
//        this.questions = questionsJSON;
        },

        loadNumberQuestions( state, rootState, numberQuestionsOnExam ) {
            state.numberQuestions = numberQuestionsOnExam;
        },

    },
    actions: {},
    getters: {
        /**
         * Returns a question object.
         * This has keys: questionName, questionNumber, questionAssignmentId, maxScore
         * @param questionIndex
         * @returns {*}
         */
        getQuestion( state, getters, rootState, questionIndex ) {
            return state.questions[ questionIndex ];
        },

        /**
         * Returns the maximum possible score for a given question
         * @param questionIndex
         * @returns {*}
         */
        getMaxQuestionScore( state, getters, rootState, questionIndex ) {
            return state.maxQuestionScores[ questionIndex ];
        }
    }
}





