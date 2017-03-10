//Root actions for the vuex instance

import * as mTypes from './mutation-types'
import * as aTypes from './action-types'
import Student from '../models/Student'

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
     * Handles figuring out how to set the active student from the given
     * the id in the provided payload
     * @deprecated
     * @param state
     * @param rootState
     * @param payload
     */

    [aTypes.setActiveStudentId]: ( {state, commit}, payload ) => {
        // [aTypes.setActiveStudentId](state, rootState, payload){

        console.log( aTypes.setActiveStudentId, 'is deprecated!' );
        console.log( aTypes.setActiveStudentId, payload );
        payload = state.activeStudent;

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
     * Handles figuring out how to set the active student given
     * the provided index payload
     * @deprecated
     * @param state
     * @param commit
     * @param payload
     */
    [ aTypes.setActiveStudentIndex ]: ( {state, commit}, payload ) => {

        console.log( aTypes.setActiveStudentIndex, 'is deprecated!' );
        payload = state.activeStudent;
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
        payload = state.activeStudent;
        actions[ aTypes.setActiveStudent ]( state, commit, payload );
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
        payload = state.activeStudent;

        actions[ aTypes.setActiveStudent ]( state, commit, payload );
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
        payload = state.activeStudent;

        if ( typeof (payload) == 'object' && payload instanceof Student ) {
            commit( mTypes.setActiveStudent, Payload.factory( {obj: payload} ) )
            // state.student = payload;
        }
    },


    // -------------------- from times

    /**
     * Handles figuring out how to set the time of the the currently
     * selected student from the provided payload
     * @returns {boolean}
     */
        [aTypes.setActiveStudentTime]( {state, commit}, payload )
    {

        let studentIndex = state.activeStudent.index;
        let time;

        switch ( typeof (payload) ) {
            case 'number':
                if ( Number.isInteger( payload ) ) {
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
        if ( typeof(time) == 'number' ) {
            commit( mTypes.setTime, time );
        }
    },

    /**
     * Increases the stored time for the student currently being graded by the specified
     * amount.
     * Original: data.this.examGradingTimes[ Roster.activeStudent ];
     */
    [aTypes.increaseActiveStudentGradingTime]: ( {state, commit}, payload ) => {
        let studentIndex = state.activeStudent.index;
        state.examGradingTimes[ studentIndex ] += payload.timeToAdd;
    },

// qscores


    /**
     * Save a question score for the currently active student
     * @param state
     * @param commit
     * @param payload
     */
    [aTypes.storeQuestionScoreForActiveStudent]: ( {state, commit}, payload ) => {
        // window.console.log( 'store called', this.activeStudentIndex, questionIndex, score );
        let {questionIndex, score} = payload;
        let studentIndex = state.activeStudent.index;
        //type checking

        let out = Payload.factory({index2: questionIndex, index: studentIndex, num: score});

        commit( mTypes.setQuestionScore, out );
    },

    // escores

    [aTypes.storeElementScoreForActiveStudent]({state, commit}, payload) {
        let studentIndex = state.getActiveStudentIndex();
        let {elementIndex, score} = payload;
        //type checks

        if(typeof (score) == 'undefined'){
            //score may have been named differently
            score = payload.elementScore;
        }


        let out = Payload.factory({
            index: studentIndex,
            index2: elementIndex,
            num: score
        });

        commit(mTypes.setElementScore, out);
    },


}
