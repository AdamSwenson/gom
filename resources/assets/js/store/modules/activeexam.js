/**
 * This manages state regarding the exam
 * currently being worked on, used for grading, etc
 *
 * Created by adam on 1/12/17.
 */

import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'
import Exam from '../../models/Exam'
import Payload from '../../models/Payload'

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
    [mTypes.setActiveExam]: ( state, payload ) => {
        if(Payload.checkIfPayload( payload ) && typeof payload.obj != 'undefined'){
            state.activeExam = payload.obj;
        }
    },


    /**
     * Resets active exam to null
     * It's tempting to consolidate this with the above
     * but it actually turns out to be a bit complicated to get rid of this
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.clearActiveExam]: ( state, rootState, payload ) => {
        //    Payload.checkIfPayload( payload );
        state.activeExam = false;
    },

    /**
     * Updates properties of the exam set as active.
     *
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.updateActiveExamProp]: ( state, payload ) => {

        if ( Payload.checkIfPayload( payload ) && typeof payload.updateProp != 'undefined' ) {
            let {updateProp, updateVal}  = payload;
            Vue.set( state.activeExam, updateProp , updateVal );
        }

    },
}

const actions = {

    /**
     * Adds the exam in the payload to the store. Also
     * adds the exam index to the indexMap so can look up
     * the id for older components.
     * It makes sense to restrict this to existing Exam objects.
     * It shouldn't have to create a new object or even look it
     * up from other stuff. That's an api layer task
     * @param state
     * @param commit
     * @param payload
     */
        [aTypes.setActiveExam]( {state, commit}, payload )
    {
        let obj;
        //check and see if an exam object has already been passed in
        if ( payload instanceof Exam ) {
            payload = Payload.factory( {obj: payload} );
        }

        //create the payload with the object
        // let pl = Payload.factory( {obj: obj} );

        //Save the object
        commit( mTypes.setActiveExam, payload );
    },

    /**
     * Sets the active exam to null.
     * @param state
     * @param commit
     * @param payload
     */
        [aTypes.clearActiveExam]( {state, commit}, payload )
    {
        commit( mTypes.clearActiveExam );
    },

};

const getters = {

    getActiveExamId: ( state, getters, payload ) => {
        return 0;
        // return typeof state.activeExam != 'undefined' ? state.activeExam.id : false;
    },

    getActiveExamIndex: ( state, getters, payload ) => {
        return 0;
        // return typeof state.activeExam != 'undefined' ? state.activeExam.index : false;
        // return state.activeExam.index;
    },

    /**
     * Returns the exam currently being used or false if none set
     * @param state
     * @returns {*}
     */
    getActiveExamObj: ( state ) => {
        return typeof state.activeExam != 'undefined' && state.activeExam ? state.activeExam : false;
    }

};

export default {
    actions,
    getters,
    mutations,
    state,
}