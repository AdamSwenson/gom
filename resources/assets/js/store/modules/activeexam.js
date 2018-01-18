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
import * as gTypes from "../getter-types";

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
        if ( Payload.checkIfPayload(payload) && typeof payload.obj != 'undefined' ) {
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
        window.console.log('activeexam', '', 58, state,  payload);
        if ( state.activeExam !== null ) {
            if ( Payload.checkIfPayload(payload) && typeof payload.updateProp !== 'undefined' ) {
                let {updateProp, updateVal} = payload;
                Vue.set(state.activeExam, updateProp, updateVal);
            }
        }
        else {
            //check if the 0th item is the exam. If so,
            //that's what we are supposed to be altering
            //Hold up. You're probably pretty confused. Let me explain:
            //because adam is a fake programmer, this is a kludge
            //to work around his inability to plan. You see, the activeExam
            //stuff is from the grading page. Adam partly hijacked it
            //for the setup page. But then he decided to keep the exam
            //as the 0th element of state.items. So really, the active exam
            //is state.items[0].
            //When adam's poor planning is fixed, this will not be necessary
            if ( typeof state.items[ 0 ] === 'undefined' && state.items[ 0 ] instanceof Exam ) {
                let {updateProp, updateVal} = payload;
                Vue.set(state.items[ 0 ], updateProp, updateVal);
            }
        }
    }
};

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
            payload = Payload.factory({obj: payload});
        }

        //create the payload with the object
        // let pl = Payload.factory( {obj: obj} );

        //Save the object
        commit(mTypes.setActiveExam, payload);
    },

    /**
     * Sets the active exam to null.
     * @param state
     * @param commit
     * @param payload
     */
        [aTypes.clearActiveExam]( {state, commit}, payload )
    {
        commit(mTypes.clearActiveExam);
    },

};

const getters = {

    /**
     * Returns the exam currently being used
     * @param state
     * @returns {*}
     */
    [gTypes.getActiveExam] : ( state ) => {
        return state.activeExam;
    },

    /**
     * Poorly named shortcut for getting the currently active exam.
     * @param state
     */
    currentExam: ( state, getters ) => {
      return state.activeExam;
        // return typeof state.activeExam != 'undefined' && state.activeExam ? state.activeExam : false;

    },
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
    },


    getExamSerialNumber: ( state, getters ) => {
        return typeof state.activeExam != 'undefined' && state.activeExam ? state.activeExam.serialNumber : false;

//        return state.items[ 0 ] ? state.items[ 0 ].serialNumber : null;
    }

};

export default {
    actions,
    getters,
    mutations,
    state,
}