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
    [mTypes.loadElementScores](state, rootState, studentElementScores)
    {
        state.elementScores = studentElementScores;
    },

    /**
     * Set a student's score on a particular element
     * @param studentIndex
     * @param elementIndex
     * @param score
     */
        [mTypes.setElementScore](state, rootState, studentIndex, elementIndex, score)
    {
        state.elementScores[studentIndex][elementIndex] = score;
    },



    [mTypes.storeElementScoreForActiveStudent](state, elementIndex, score) {
        state.storeElementScore(state.activeStudentIndex, elementIndex, score);
    }
};

const actions = {};

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

const api = {    /**
 * Stores a student's score on a particular element
 * @param studentIndex
 * @param elementIndex
 * @param score
 */
    [mTypes.storeElementScore](state, rootState, studentIndex, elementIndex, score) {
    state.elementScores[studentIndex][elementIndex] = score;
},
}

// }

export default {
    actions,
    getters,
    mutations,
    state,
}