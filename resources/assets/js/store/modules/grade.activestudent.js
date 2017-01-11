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

const state = {
    /** The database id of the student currently selected/ being graded
     * @type integer|null
     */
    Id: null,

    /**
     * The index of the student currently selected/ being graded.
     * @type integer|null
     */
    Index: null,

    /**
     * Holds the object representing the currently selected student
     * @type Student
     */
    student: null,

    /**
     * The time spent grading the current student
     * @type float|null
     */
    Time: null,

};

const mutations = {
    /**
     * Updates the state's stored index for the currently selected
     * to the index specified in the payload.
     * Does not update id or student; those must be called separately
     * @param state
     * @param rootState
     * @param payload
     */
        [mTypes.setIndex](state, rootState, payload){
        if (Number.isInteger(payload)) {
            rootState.Index = payload;
            state.Index = payload;
        }
    },

    /**
     * Updates the state's stored student id for the currently
     * selected student to the id specified in the payload.
     * Does not update index or student; those must be called separately
     * @param state
     * @param rootState
     * @param payload integer
     * @returns {boolean}
     */
        [mTypes.setId](state, rootState, payload)
    {
        if (Number.isInteger(payload)) {
            rootState.Id = payload;
            state.Id = payload;
            return true;
        }
    },

    /**
     * Sets the state's stored student object to the
     * object specified in the payload.
     * Does not update index or id. Those must be called separately.
     * @param state
     * @param rootState
     * @param payload Student
     */
        [mTypes.setStudentObject](state, rootState, payload)
    {
        if (typeof (payload) == 'object' && payload instanceof Student) {
            state.student = payload;
        }
    },

    /**
     * Updates the stored time for the currently selected student
     * @param state
     * @param rootState
     * @param payload integer
     */
        [mTypes.setTime](state, rootState, payload)
    {
        if (typeof(payload) == 'number') {
            state.Time = payload;
        }
    }
};

const actions = {
    /**
     * Handles figuring out how to set the student id given
     * the provided payload
     * @param state
     * @param rootState
     * @param payload
     */

        [aTypes.setActiveStudentId]({ state, commit }, payload){
    // [aTypes.setActiveStudentId](state, rootState, payload){

        console.log(aTypes.setActiveStudentId, payload);
        let studentId;

        //number passed in
        if (typeof (payload) == 'number' && Number.isInteger(payload)) {
            studentId = payload;
        }

        //object passed in
        //todo add object case
        console.log('studentId', studentId);
        if (Number.isInteger(studentId)) {
            commit(mTypes.setId, studentId);
        }
    },

    /**
     * Handles figuring out how to set the student index given
     * the provided payload
     * @param state
     * @param commit
     * @param payload
     */
        [aTypes.setActiveStudentIndex]({ state, commit }, payload){
        let studentIndex;
        switch (typeof (payload)) {
            case 'number':
                if (Number.isInteger(payload)) {
                    studentIndex = payload;
                }
                break;
            case 'object':
                //todo write if object

                break;
            default:
        }

        if (Number.isInteger(studentIndex)) {
            commit(mTypes.setIndex, studentIndex);
        }
    },

    /**
     * Handles figuring out how to set a student object as active
     * from the provided payload
     * @param student
     * @param rootState
     * @param payload
     */
        [aTypes.setActiveStudentObject]({ state, commit }, payload){
        // let student;

        // if (payload instanceof Student) {
        //     student = payload;
        // }
        // switch(typeof (payload)){
        //     case 'number':
        //         if(Number.isInteger(payload)){
        //             studentIndex = payload;
        //         }
        //         break;
        //     case 'object':
        //         //todo write if object
        //
        //         break;
        //     default:
        // }

        //Call the mutation
        if (payload instanceof Student) {
            commit(mTypes.setStudentObject, payload);
        }
    },

    /**
     * Handles figuring out how to set the time of the the currently
     * selected student from the provided payload
     * @returns {boolean}
     */
        [aTypes.setActiveStudentTime]({ state, commit }, payload)
    {
        let time;

        switch (typeof (payload)) {
            case 'number':
                if (Number.isInteger(payload)) {
                    //go straight to recording
                    time = payload;
                }
                break;

            //object with expected key
            case 'object':
                //todo write if object
                break;

            //other allowed types
                // todo

            //numeric string
                // todo
            default:
                //todo
        }

        //Call the mutation
        if (typeof(time) == 'number') {
            commit(mTypes.setTime, time);
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
        [aTypes.setActiveStudent]({ state, commit }, payload) {
        let payloadType;
        let studentId;
        let studentIndex;
        let studentObject;
        let time;

        //figure out what received in payload
        switch (typeof payload) {
            case 'number':
                if (Number.isInteger(payload)) {
                    studentId = payload;
                }
                //non-integer case?

                break;

            case 'object':
                //Generic object with parameters as keys/values
                if (typeof (payload.studentId != 'undefined')) {
                    studentId = payload.studentId;
                    //try getting index and object
                }
                if (typeof (payload.studentIndex != 'undefined')) {
                    studentIndex = payload.studentIndex;
                    //try getting id and object
                }

                if (typeof (payload.studentObject != 'undefined')) {
                    studentObject = payload.studentObject;
                    studentId = studentObject.studentId;
                    studentIndex = studentObject.studentIndex;
                }
                break;

            case 'student-object':
                break;
        }

        //set id

        //set index

        //set object

        //set time

        //mapping from expected payload keys to mutations
        let mutationMap = {studentId: types.setId, studentIndex: types.setIndex};
        let me = this;

        //populate fields from payload
        mutationMap.forEach(function (incomingKey, mutationName) {
            if (typeof(payload[incomingKey]) != 'undefined') {
                //Set the state property
                commit(mutationName, payload);
            }
        });

        //Set the index on the state
        if (typeof(this.studentIndex != 'undefined')) {
            state.Index = this.studentIndex;
        }

        //set student id
        if (typeof this.studentId == 'undefined' || this.studentId === null) {

            let student = state.students[studentIndex];
            // window.console.log( 'jjj', student );
            studentId = student.studentId;
        }

        state.Id = studentId;
    }
};
//
// /**
//  * internally used helpers
//  * @type {{if: (()), typeof: boolean}}
//  */
// const methods = {
//
//     setStudentId: (val) => {
//         if (typeof val != 'undefined' && val != null && Number.isInteger(val)) {
//             return val;
//         }
//     }
// };

const getters = {
    /**
     * Returns the id of the currently selected student
     * @param state
     * @param getters
     * @param rootState
     * @returns {null|integer}
     */
    getActiveStudentId(state, getters, rootState){
        return state.Id;
    },

    /**
     * Returns index of the currently selected student
     * @param state
     * @param getters
     * @param rootState
     * @returns {integer|null}
     */
    getActiveStudentIndex: (state, getters, rootState) => {
        return state.Index;
    },

    /**
     * Returns the student object corresponding to the
     * currently selected student.
     * @returns {Student}
     */
    getActiveStudent: (state, getters, rootState) => {
        return state.student;
    }

};

export default {
    actions,
    getters,
    mutations,
    state,
}