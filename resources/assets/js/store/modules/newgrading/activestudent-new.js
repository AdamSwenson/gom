/**
 * This handles all matters related to one student being the
 * currently selected student which operations on the page
 * are affecting. Mainly used in grading, but could also be used in
 * reporting.
 *
 * Created by adam on 10/7/16.
 */

import Vue from 'vue';
//using different common name store so don't get into
//trouble with the original
import * as mTypes from './new-grading-mutation-types';
import * as aTypes from './new-grading-action-types';
import * as gTypes from './new-grading-getter-types';
import Student from '../../../models/Student';
import Payload from '../../../models/Payload';

import { getStudentGradingTime } from '../../../api/requests/timeRequests';

const state = {

    /**
     * Holds the object representing the currently selected student
     * @type Student|null
     */
    activeStudent: null,

    /**
     * whether or not the timer is running.
     * This allows a parent or distant relative
     * to tell the dashboard-timer to start or stop the
     * time by altering this
     */
    timerRunning: false,

};

const mutations = {

    /**
     * Sets the active student from the object in the payload
     * @param state
     * @param rootState
     * @param payload
     */
    [ mTypes.setActiveStudent ]: ( state, rootState, payload ) => {
        Payload.checkIfPayload( payload );
        state.activeStudent = payload.obj;
    },


    [ mTypes.setActiveStudentTime ]: ( state, rootState, payload ) => {
        Payload.checkIfPayload( payload );
        Vue.set( state.activeStudent, 'gradingTime', payload.num );
    },

    [mTypes.startExamTimer]: (state)=>{
        state.timerRunning = true;
    },

    [mTypes.stopExamTimer]: (state)=>{
state.timeRunning = false;
    },



};

const actions = {

    /**
     * Updates the stored time for the currently selected student
     * @param state
     * @param rootState
     * @param payload integer
     */
    [ aTypes.setTime ]( { state, commit }, time ) {
        commit( mTypes.setActiveStudentTime, Payload.factory( { num: payload } ) )

    },

    /**
     * Update the state with the indicated student
     * as activeStudent.
     * This is the main action which should be called externally.
     * Most of the other actions are called by this.
     *
     * @param state
     * @param student
     * @param rootState
     */
    [ aTypes.setStudentAsActive ]( { dispatch, commit, getters }, student ) {
        return new Promise( function ( resolve, reject ) {
            //Really should've received a Student object.
            //this is the happiest of paths
            if ( student instanceof Student ) {
                //call the mutation
                commit( mTypes.setActiveStudent, Payload.factory( { obj: student } ) );


                //check if the student already has grading time
                //todo

                //if not, load it from server
                // let p = getStudentGradingTime()

            }
        } );
    },


    /**
     * This is the omnibus handler for resetting
     * the active student state
     *
     * Resets active exam to null and
     * resets the current grading time to null
     *
     * @param state
     * @param rootState
     * @param payload
     */
    [ aTypes.resetActiveStudent ]: ( { state, commit } ) => {
        return new Promise( function ( resolve, reject ) {
            let pl = Payload.factory( { obj: null, num: null } )
            commit( mTypes.setActiveStudent, pl );
            commit( mTypes.setActiveStudentTime, pl );
        } );

    },


};

const getters = {

    /**
     * Returns the student object corresponding to the
     * currently selected student.
     * @returns {Student}
     */
    [ gTypes.getActiveStudent ]: ( state, getters, rootState ) => {
        return state.activeStudent;
    },

    [gTypes.isTimerRunning]: (state)=>{
        return state.timerRunning;
    }
    //
    // [ gTypes.getActiveStudentGradingTime ]: ( state, getters ) => {
    //     return state.activeStudent.gradingTime;
    // }


};

export default {
    actions,
    getters,
    mutations,
    state,
}