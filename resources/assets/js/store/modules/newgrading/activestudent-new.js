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
import * as ngmTypes from '../../new-grading-mutation-types';
import * as ngaTypes from '../../new-grading-action-types';
import * as nggTypes from '../../new-grading-getter-types';
import Student from '../../../models/Student';
import Payload from '../../../models/Payload';

import PayloadTime from '../../../models/PayloadTime';

import { getStudentGradingTime } from '../../../api/requests/timeRequests';

const state = {

    /**
     * Holds the object representing the currently selected student
     * @type Student|null
     */
    activeStudent: null,


};

const mutations = {

    /**
     * Sets the active student from the object in the payload
     * @param state
     * @param rootState
     * @param payload
     */
    [ ngmTypes.setActiveStudent ]: ( state, payload ) => {
        window.console.log( 'activestudent-new', '', 48, payload );
        Vue.set( state, 'activeStudent', payload.obj );
    },


    [ ngmTypes.setActiveStudentTime ]: ( state, payloadTime ) => {
        // Payload.checkIfPayload( payload );
        Vue.set( state.activeStudent, 'gradingTime', payloadTime.time );
    },


};

const actions = {

    /**
     * Increases the stored time for the student by the specified amount
     * @param state
     * @param payload.studentIndex
     * @param payload.timeToAdd
     */
    [ ngaTypes.incrementGradingTime ]: ( { dispatch, commit, getters }, amount ) => {
        let prevTime = getters[ nggTypes.getActiveStudentGradingTime ];
        if ( _.isUndefined( prevTime ) ) prevTime = 0;
        let newTime = prevTime += amount;
        let exam = getters[ nggTypes.getActiveExamNew ];
        let student = getters[ nggTypes.getActiveStudent ];
        let pl = PayloadTime.factory( { exam: exam, student: student, time: newTime } );
        // dispatch( aTypes.setTime, pl );
        commit( ngmTypes.setActiveStudentTime, pl );

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
    [ ngaTypes.resetActiveStudent ]: ( { state, commit } ) => {
        return new Promise( function ( resolve, reject ) {
            let pl = Payload.factory( { obj: null, num: null } )
            commit( ngmTypes.setActiveStudent, pl );
            commit( ngmTypes.setActiveStudentTime, pl );
        } );

    },


    /**
     * Update the state with the indicated student
     * as activeStudent.
     * This is the main action which should be called externally.
     * Most of the other actions are called by this.
     *
     * If the preference for autorunning the timer is on,
     * it will also start the timer.
     *
     * No need to check if the timer is running. It will reset any existing
     * timer.
     *
     * @param state
     * @param student
     * @param rootState
     */
    [ ngaTypes.setStudentAsActive ]( { dispatch, commit, getters }, student ) {
        // return new Promise( function ( resolve, reject ) {
        let pl = Payload.factory( { obj: student, mutateSilently: true } );

        //call the mutation
        commit( ngmTypes.setActiveStudent, pl );


        //start timer if the preference says to
        if(getters[nggTypes.getGradingPreference]('shouldTimerAutomaticallyStart')){
            dispatch(ngaTypes.startExamTimer);
        }
    },


    /**
     * Updates the stored time for the currently selected student
     * @param state
     * @param rootState
     * @param payload integer
     */
    [ ngaTypes.setTime ]( { state, commit }, time ) {
        // commit( mTypes.setActiveStudentTime, Payload.factory( { num: time } ) );

    },


};

const getters = {

    /**
     * Returns the student object corresponding to the
     * currently selected student.
     * @returns {Student}
     */
    [ nggTypes.getActiveStudent ]: ( state, getters, rootState ) => {
        return state.activeStudent;
    },


    [ nggTypes.getActiveStudentGradingTime ]: ( state, getters ) => {
        let s = getters[ nggTypes.getActiveStudent ];
        if ( !_.isUndefined( s ) && !_.isNull( s ) ) return s.gradingTime;
    }


};

export default {
    actions,
    getters,
    mutations,
    state,
}