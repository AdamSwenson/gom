import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'

const state = {
    /** Format: { studentIndex : { elementIndex : elementScore},  ... } */
    elementScores: {},
};

const mutations = {
    /**
     * Consume a json object and populate the elementScores state
     * @param state
     * @param rootState
     * @param studentElementScores
     */
        [mTypes.loadElementScores](state, rootState, payload)
    {
        state.elementScores = payload;
    },

    /**
     * Set a student's score on a particular element
     * @param studentIndex
     * @param elementIndex
     * @param score
     */
        [mTypes.setElementScore](state, rootState, payload)
    {
        let {studentIndex, elementIndex, score} = payload;
        if(typeof (score) == 'undefined'){
            //score may have been named differently
            score = payload.elementScore;
        }

        state.elementScores[studentIndex][elementIndex] = score;
    },
};

const actions = {

    [aTypes.storeElementScoreForActiveStudent]({state, commit}, payload) {
        let studentIndex = state.getActiveStudentIndex();
        let {elementIndex, score} = payload;
        //type checks

        let out = {
            studentIndex: studentIndex,
            elementIndex: elementIndex,
            score: score
        };

        commit(mTypes.setElementScore, out);
    },

    /**
     * Stores a student's score on a particular element
     * @param studentIndex
     * @param elementIndex
     * @param score
     */
        [aTypes.storeElementScore]({state, commit}, payload)
    {
        commit(mTypes.setElementScore, payload);
    },
};

const getters = {
    /**
     * Retrieves element score for a student
     * Original: data.state.elementScores[ Roster.activeStudent ][ index ];
     * @param studentIndex
     * @param elementIndex
     * @returns {*}
     */
    getElementScore(state, getters, rootState, studentIndex, elementIndex) {
        return state.elementScores[studentIndex][elementIndex];
    },

    getElementScoreForActiveStudent(state, getters, rootState, elementIndex) {
        if (state.activeStudentIndex == null) return '';
        return state.elementScores[state.activeStudentIndex][elementIndex];
    },


};

export default {
    actions,
    getters,
    mutations,
    state,
}