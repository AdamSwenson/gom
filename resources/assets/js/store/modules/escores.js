import * as lmTypes from '../legacy-mutation-types'
import * as laTypes from '../legacy-action-types'
import Payload from '../../models/Payload'

const state = {
    /** Format: { studentIndex : { elementIndex : elementScore},  ... } */
    elementScores: {},
};


const isEmpty = (state) => {
    if(Object.keys(state.elementScores).length > 0){
        return false;
    }
    return true;
}

const mutations = {
    /**
     * Consume a json object and populate the elementScores state
     * @param state
     * @param rootState
     * @param studentElementScores
     */
        [lmTypes.loadElementScores](state, rootState, payload)
    {
        Payload.checkIfPayload(payload);
        //set the state to the payload's object
        state.elementScores = payload.obj;
    },

    /**
     * Set a student's score on a particular element
     * @param studentIndex
     * @param elementIndex
     * @param score
     */
        [lmTypes.setElementScore](state, rootState, payload)
    {
        Payload.checkIfPayload(payload);
        let studentIndex = payload.index;
        let elementIndex = payload.index2;
        let score = payload.num;

        state.elementScores[studentIndex][elementIndex] = score;
    },
};

const actions = {

    /**
     * Stores a student's score on a particular element
     * @param studentIndex
     * @param elementIndex
     * @param score
     */
        [laTypes.setElementScore]({state, commit}, payload)
    {

        let {studentIndex, elementIndex, score} = payload;
        //type checks

        if(typeof (score) == 'undefined'){
            //score may have been named differently
            score = payload.elementScore;
        }

        let out = Payload.factory({
            index: studentIndex,
            index2: elementIndex,
            num: score
        });

        commit(lmTypes.setElementScore, out);
    },

    /**
     * Consume a json object and populate the elementScores state.
     * Overwrites the existing store.
     * @param state
     * @param rootState
     * @param studentElementScores
     */
        [laTypes.loadElementScores]({state, commit}, payload)
    {

        let pl = Payload.factory({obj: payload});
        commit(lmTypes.loadElementScores, pl);
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
        if(isEmpty(state)){ return false; };

        return state.elementScores[studentIndex][elementIndex];
    }



};

export default {
    actions,
    getters,
    mutations,
    state,
}