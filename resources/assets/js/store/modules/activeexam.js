/**
 * This manages state regarding the exam
 * currently being worked on, used for grading, etc
 *
 * Created by adam on 1/12/17.
 */

import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'
import Exam from '../models/Exam'


const state = {
    /**
     * Exam object representing the current exam being
     * worked on, graded, reported, etc
     */
    activeExam: null,

};

const mutations = {

    /**
     * Sets the active exam to the payload
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.setActiveExam](state, rootState, payload){
        state.activeExam = payload;
    },

    /**
     * Sets active exam to null
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.clearActiveExam](state, rootState, payload){
        state.activeExam = null;
    }
};

const actions = {

    /**
     * Adds the exam in the payload to the store. Also
     * adds the exam index to the indexMap so can look up
     * the id for older components.
     * @param state
     * @param commit
     * @param payload
     */
        [aTypes.setActiveExam]({state, commit}, payload)
    {
        let { examId, examIndex, obj } = payload;

        //check and see if an exam object has already been passed in
        if(! obj instanceof Exam){
            //if not, create a new exam object
            let { name, year, term } = payload;
            obj = Exam.factory({ name, year, term }, examIndex );
        }

        //Save the object
        commit(mTypes.setActiveExam, obj);
    },

    /**
     * Sets the active exam to null.
     * @param state
     * @param commit
     * @param payload
     */
    [aTypes.clearActiveExam]({state, commit}, payload)
    {
        commit(mTypes.clearActiveExam);
    }
};

const getters = {

    getActiveExamId: (state, getters, payload)=>{
      return state.exam.id;
    },

    getActiveExamIndex: (state, getters, payload)=>{
        return state.exam.index;
    },

    getActiveExamObj: (state, getters) =>{
        return state.exam;
    }

};

export default {
    actions,
    getters,
    mutations,
    state,
}