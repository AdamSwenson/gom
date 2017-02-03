//Root actions for the vuex instance

import * as mTypes from './mutation-types'
import * as aTypes from './action-types'
import Student from './models/Student'

export const actions = {
// /**
//  * Sets the id of the exam currently being worked on
//  * @param commit
//  * @param examId
//  */
// export const setExamId = ( {commit}, examId ) => {
//     commit( '_setExamId', examId );
// };
//
// export const activeStudentIdGetDecor = ( {state, commit}, payload ) => {
//
// };

    /**
     * Handles figuring out how to set the student id given
     * the provided payload
     * @deprecated
     * @param state
     * @param rootState
     * @param payload
     */

    [aTypes.setActiveStudentId]: ( {state, commit}, payload ) => {
        // [aTypes.setActiveStudentId](state, rootState, payload){

        console.log( aTypes.setActiveStudentId, 'is deprecated!' );
        console.log( aTypes.setActiveStudentId, payload );
        actions[ aTypes.setActiveStudent ]( state, commit, payload );
        // let studentId;
        //
        // //number passed in
        // if (typeof (payload) == 'number' && Number.isInteger(payload)) {
        //     studentId = payload;
        // }
        //
        //
        // //object passed in
        // //todo add object case
        // console.log('studentId', studentId);
        // if (Number.isInteger(studentId)) {
        //     commit(mTypes.setId, Payload.factory({num: studentId}));
        // }
    },

    /**
     * Handles figuring out how to set the student index given
     * the provided payload
     * @deprecated
     * @param state
     * @param commit
     * @param payload
     */
    [ aTypes.setActiveStudentIndex ]: ( {state, commit}, payload ) => {

        console.log( aTypes.setActiveStudentIndex, 'is deprecated!' );
        actions[ aTypes.setActiveStudent ]( state, commit, payload );
        // let studentIndex;
        // switch (typeof (payload)) {
        //     case 'number':
        //         if (Number.isInteger(payload)) {
        //             studentIndex = payload;
        //         }
        //         break;
        //     case 'object':
        //         //todo write if object
        //
        //         break;
        //     default:
        // }
        //
        // if (Number.isInteger(studentIndex)) {
        //     commit(mTypes.setIndex, studentIndex);
        // }
    },

    /**
     * Handles figuring out how to set a student object as active
     * from the provided payload
     * @deprecated
     * @param student
     * @param rootState
     * @param payload
     */
    [ aTypes.setActiveStudentObject ]: ( {state, commit}, payload ) => {
        console.log( aTypes.setActiveStudentObject, 'is deprecated!' );
        [ aTypes.setActiveStudent ]( state, commit, payload );
        // // let student;
        //
        // // if (payload instanceof Student) {
        // //     student = payload;
        // // }
        // // switch(typeof (payload)){
        // //     case 'number':
        // //         if(Number.isInteger(payload)){
        // //             studentIndex = payload;
        // //         }
        // //         break;
        // //     case 'object':
        // //         //todo write if object
        // //
        // //         break;
        // //     default:
        // // }
        //
        // //Call the mutation
        // if (payload instanceof Student) {
        //     commit(mTypes.setStudentObject, payload);
        // }
    },
    /**
     * Updates the state's stored index for the currently selected
     * to the index specified in the payload.
     * Does not update id or student; those must be called separately
     * @deprecated
     * @param state
     * @param rootState
     * @param payload
     */
        [aTypes.setIndex]( {state, commit}, payload ){
        console.log( aTypes.setIndex, 'is deprecated!' );
        console.log( aTypes.setIndex, payload );
        actions[ aTypes.setActiveStudent ]( state, commit, payload );
        // if (Number.isInteger(payload)) {
        //     rootState.Index = payload;
        //     state.Index = payload;
        // }
    },

    /**
     * Updates the state's stored student id for the currently
     * selected student to the id specified in the payload.
     * Does not update index or student; those must be called separately
     * @deprecated
     * @param state
     * @param rootState
     * @param payload integer
     * @returns {boolean}
     */
        [aTypes.setId]( {state, commit}, payload )
    {
        console.log( aTypes.setId, 'is deprecated!' );

        actions[ aTypes.setActiveStudent ]( state, commit, payload );
        // if (Number.isInteger(payload)) {
        //     rootState.Id = payload;
        //     state.Id = payload;
        //     return true;
        // }
    },

    /**
     * Sets the state's stored student object to the
     * object specified in the payload.
     * Does not update index or id. Those must be called separately.
     * @deprecated
     * @param state
     * @param rootState
     * @param payload Student
     */
        [aTypes.setStudentObject]( {state, commit}, payload )
    {
        if ( typeof (payload) == 'object' && payload instanceof Student ) {
            commit( mTypes.setActiveStudent, Payload.factory( {obj: payload} ) )
            // state.student = payload;
        }
    },

}
