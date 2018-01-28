/**
 * This manages state regarding the exam
 * currently being worked on, used for grading, etc
 *
 * Created by adam on 1/12/17.
 */
import Vue from 'vue';
import * as mTypes from '../../new-grading-mutation-types';
import * as aTypes from '../../new-grading-action-types';
import * as gTypes from '../../new-grading-getter-types';

import Exam from '../../../models/Exam'
import Payload from '../../../models/Payload'

const state = {
    /**
     * Exam object representing the current exam being
     * worked on, graded, reported, etc
     */
    activeExam : null,

};

const mutations = {

    /**
     * Sets the active exam
     * @param state
     * @param rootState
     * @param payload
     */
    [ mTypes.setActiveExam ]: ( state, payload ) => {
        state.activeExam = payload.obj;
    },

    /**
     * Updates properties of the exam set as active.
     *
     * @param state
     * @param rootState
     * @param payload
     */
    [ mTypes.updateActiveExamProp ]: ( state, payload ) => {
        if ( state.activeExam !== null ) {
            if ( Payload.checkIfPayload( payload ) && typeof payload.updateProp !== 'undefined' ) {
                let { updateProp, updateVal } = payload;
                Vue.set( state.activeExam, updateProp, updateVal );
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
                let { updateProp, updateVal } = payload;
                Vue.set( state.items[ 0 ], updateProp, updateVal );
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
    [ aTypes.setExamAsActive]( { state, commit }, exam ) {
        let obj;
        //check and see if an exam object has already been passed in
        if ( exam instanceof Exam ) {
            let payload = Payload.factory( { obj: exam } );
            //Save the object
            commit( mTypes.setActiveExam, payload );
        }


    },

    /**
     * Sets the active exam to null.
     * @param state
     * @param commit
     * @param payload
     */
    [ aTypes.resetActiveExam ]( { state, commit } ) {
        commit( mTypes.setActiveExam, Payload.factory( { obj: null } ) );
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
    }
};

export default {
    actions,
    getters,
    mutations,
    state,
}