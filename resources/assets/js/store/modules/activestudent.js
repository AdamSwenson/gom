/**
 * This handles all matters related to one student being the
 * currently selected student which operations on the page
 * are affecting. Mainly used in grading, but could also be used in
 * reporting.
 *
 * Created by adam on 10/7/16.
 */

import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'
import Student from '../models/Student'
import Payload from '../models/Payload'

const state = {

    /**
     * Holds the object representing the currently selected student
     * @type Student|null
     */
    activeStudent: null,

    /**
     * The time spent grading the current student
     * @type float|null
     */
    Time: null,

};

const mutations = {

    /**
     * Sets the active student from the object in the payload
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.setActiveStudent]: ( state, rootState, payload ) => {
        Payload.checkIfPayload( payload );
        state.activeStudent = payload.obj;
    },


    /**
     * Resets active exam to null
     * It's tempting to consolidate this with the above
     * but it actually turns out to be a bit complicated to get rid of this

     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.clearActiveStudent]: ( state, rootState, payload ) => {
        state.activeStudent = null;
    },

    [mTypes.setActiveStudentTime]: ( state, rootState, payload ) => {
        state.Time = payload.num;
    }


};

const actions = {

    /**
     * Updates the stored time for the currently selected student
     * @param state
     * @param rootState
     * @param payload integer
     */
        [aTypes.setTime]( {state, commit}, payload )
    {
        if ( typeof(payload) == 'number' ) {
            commit( mTypes.setActiveStudentTime, Payload.factory( {num: payload} ) )
            state.Time = payload;
        }
    },

    /**
     * Update the state with the indicated student
     * as activeStudent.
     * This is the main action which should be called externally.
     * Most of the other actions are called by this.
     *
     * @param state
     * @param rootState
     * @param payload
     */
        [aTypes.setActiveStudent]( {state, commit}, payload ) {

        //Really should've received a Student object.
        //this is the happiest of paths
        if ( payload instanceof Student ) {
            //we just build the payload
            let pl = Payload.factory( {obj: payload} );
            //call the mutation
            commit( mTypes.setActiveStudent, pl );
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
    [aTypes.clearActiveStudent]: ( {state, commit}, payload ) => {
        commit( mTypes.clearActiveStudent );
    },


    //
    // let payloadType;
    // let studentId;
    // let studentIndex;
    // let studentObject;
    // let time;
    //
    //
    // //Uh oh. They gave us something other than a student.
    // //Lets try to help them out by finding the right student
    // //object
    // else {
    //     //figure out what received in payload
    //     switch ( typeof payload ) {
    //         case 'number':
    //             if ( Number.isInteger( payload ) ) {
    //                 studentId = payload;
    //
    //             }
    //             //non-integer case?
    //
    //             break;
    //
    //         case 'object':
    //             //Generic object with parameters as keys/values
    //             if ( typeof (payload.studentId != 'undefined') ) {
    //                 studentId = payload.studentId;
    //                 //try getting index and object
    //             }
    //             if ( typeof (payload.studentIndex != 'undefined') ) {
    //                 studentIndex = payload.studentIndex;
    //                 //try getting id and object
    //             }
    //
    //             if ( typeof (payload.studentObject != 'undefined') ) {
    //                 studentObject = payload.studentObject;
    //                 studentId = studentObject.studentId;
    //                 studentIndex = studentObject.studentIndex;
    //             }
    //             break;
    //
    //         case 'student-object':
    //             break;
    //     }

    //set id
    // studentObject = Student.factory(payload);
    //set index

    //set object

    //set time

    // //mapping from expected payload keys to mutations
    // let mutationMap = {studentId: types.setId, studentIndex: types.setIndex};
    // let me = this;
    //
    // //populate fields from payload
    // mutationMap.forEach( function ( incomingKey, mutationName ) {
    //     if ( typeof(payload[ incomingKey ]) != 'undefined' ) {
    //         //Set the state property
    //         commit( mutationName, payload );
    //     }
    // } );
    // }
    // },


};

const getters = {
    /**
     * Returns the id of the currently selected student
     * @param state
     * @param getters
     * @param rootState
     * @returns {null|integer}
     */
    getActiveStudentId( state, getters, rootState ){
        return state.activeStudent.id;
    },

    /**
     * Returns index of the currently selected student
     * @param state
     * @param getters
     * @param rootState
     * @returns {integer|null}
     */
    getActiveStudentIndex: ( state, getters, rootState ) => {
        return state.activeStudent.index;
    },

    /**
     * Returns the student object corresponding to the
     * currently selected student.
     * @returns {Student}
     */
    getActiveStudent: ( state, getters, rootState ) => {
        return state.activeStudent;
    }

};

export default {
    actions,
    getters,
    mutations,
    state,
}