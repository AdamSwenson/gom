/**
 * This manages state regarding the exam
 * currently being worked on, used for grading, etc
 *
 * Created by adam on 1/12/17.
 */

import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'
import Exam from '../models/Exam'
import Payload from '../models/Payload'

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
    [mTypes.setActiveExam]: ( state, rootState, payload ) => {
        Payload.checkIfPayload( payload );
        state.activeExam = payload.obj;
    },


    /**
     * Resets active exam to null
     * It's tempting to consolodate tbhis with the above
     * but it actually turns out to be a bit complicatied to get rid of this

     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.clearActiveExam]: ( state, rootState, payload ) => {
        //    Payload.checkIfPayload( payload );
        state.activeExam = null;
    }
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
            obj = payload;
        }
        // else
        //     {
        //     let {examId, examIndex, obj, name, year, term} = payload;
        //     console.log( examId, examIndex, obj, name, year, term );
        //     if(typeof obj == 'undefined') {
        //         //if not, create a new exam object
        //         // let {name, year, term} = payload;
        //         obj = Exam.factory( {
        //             examIndex: examIndex,
        //             examId: examId
        //         } );
        //         obj.name = name;
        //         obj.year = year;
        //         obj.term = term;
        //     }
        // }

        //create the payload with the object
        let pl = Payload.factory( {obj: obj} );

        //Save the object
        commit( mTypes.setActiveExam, pl );
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


    /**
     * This should probably be deprecated
     *
     * @param state
     * @param commit
     * @param payload
     */
        [aTypes.setActiveStudentId]( {state, commit}, payload ){
        //look up the student

        //set the exam by calling setActiveExam


    }

};

const getters = {

    getActiveExamId: ( state, getters, payload ) => {
        return state.activeExam.id;
    },

    getActiveExamIndex: ( state, getters, payload ) => {
        return state.activeExam.index;
    },

    getActiveExamObj: ( state, getters ) => {
        return state.activeExam;
    }

};

export default {
    actions,
    getters,
    mutations,
    state,
}