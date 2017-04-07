//Root actions for the vuex instance

import * as mTypes from './mutation-types'
import * as aTypes from './action-types'
import Student from '../models/Student'
import Exam from '../models/Exam'
import Item from '../models/Item'
import Payload from '../models/Payload'
import * as api from '../api/controller'

// export const actions = {

/**
 * Creates a new exam on the client, sets
 * it as the active exam, and requests an
 * exam id from the server
 * @param state
 * @param commit
 * @param payload
 */
export const createExam = ( {state, commit}, payload ) => {
    window.console.log('actions', 'createExam', 22,);
    //instantiate the new exam
    let exam = Exam.factory({index: 0}); //.factory( {id: id, index: index} );
    //set it in the items list
    //this will call the api lister.
    commit(mTypes.setItem, Payload.factory({index: 0, obj: exam}));
    //set it as active (in case anything is depending on the older structure)
    // commit(mTypes.setActiveExam, Payload.factory({obj: exam}));
};


/**
 * Called when a brand new item needs to be created and inserted into
 * the store.
 * This handles the creation of the item and then the subsequent actions
 * like notifying the server
 *
 * @param state
 * @param commit
 */
export const createItem = ( {state, commit} ) => {
    window.console.log('actions', 'createItem', 42, state.items);
    //figure out what the index should be based on
    //what is already in the list of items
    let len = Object.keys(state.items).length;
    // let len = state.getItemCount(); //items.length;
    window.console.log('actions', 'createItem', 47, len, state.items.length);
        let index =  1 + len ;
        //set the item index
        // let index = len === 1 ? len : len + 1;

        let item = Item.factory({index: index}); //.factory( {id: id, index: index} );
        window.console.log('actions', 'createItem', 51, index,  item);
        //Calling this mutation will trigger the api listener
        commit(mTypes.setItem, Payload.factory({index: index, obj: item}));
        commit(mTypes.updateOrder);

};


/**
 * The payload should contain the exam that is presently set
 * as the active exam, but with updated properties. This
 * will replace the exam stored, so that vue can see the change
 * @param state
 * @param commit
 * @param payload
 */
export const updateExam = ( {state, commit}, payload ) => {

    //set it as active
    commit(mTypes.setActiveExam, Payload.factory({obj: exam}));
    //request server update
};


// // /**
// //  * Sets the id of the exam currently being worked on
// //  * @param commit
// //  * @param examId
// //  */
// // export const setExamId = ( {commit}, examId ) => {
// //     commit( '_setExamId', examId );
// // };
// //
// // export const activeStudentIdGetDecor = ( {state, commit}, payload ) => {
// //
// // };
//
//     /**
//      * Handles figuring out how to set the active student from the given
//      * the id in the provided payload
//      * @deprecated
//      * @param state
//      * @param rootState
//      * @param payload
//      */
//
//     [aTypes.setActiveStudentId]: ( {state, commit}, payload ) => {
//         // [aTypes.setActiveStudentId](state, rootState, payload){
//
//         console.log( aTypes.setActiveStudentId, 'is deprecated!' );
//         console.log( aTypes.setActiveStudentId, payload );
//         payload = state.activeStudent;
//
//         actions[ aTypes.setActiveStudent ]( state, commit, payload );
//
//         // let studentId;
//         //
//         // //number passed in
//         // if (typeof (payload) == 'number' && Number.isInteger(payload)) {
//         //     studentId = payload;
//         // }
//         //
//         //
//         // //object passed in
//         // //todo add object case
//         // console.log('studentId', studentId);
//         // if (Number.isInteger(studentId)) {
//         //     commit(mTypes.setId, Payload.factory({num: studentId}));
//         // }
//     },
//
//     /**
//      * Handles figuring out how to set the active student given
//      * the provided index payload
//      * @deprecated
//      * @param state
//      * @param commit
//      * @param payload
//      */
//     [ aTypes.setActiveStudentIndex ]: ( {state, commit}, payload ) => {
//
//         console.log( aTypes.setActiveStudentIndex, 'is deprecated!' );
//         payload = state.activeStudent;
//         actions[ aTypes.setActiveStudent ]( state, commit, payload );
//         // let studentIndex;
//         // switch (typeof (payload)) {
//         //     case 'number':
//         //         if (Number.isInteger(payload)) {
//         //             studentIndex = payload;
//         //         }
//         //         break;
//         //     case 'object':
//         //         //todo write if object
//         //
//         //         break;
//         //     default:
//         // }
//         //
//         // if (Number.isInteger(studentIndex)) {
//         //     commit(mTypes.setIndex, studentIndex);
//         // }
//     },
//
//     /**
//      * Handles figuring out how to set a student object as active
//      * from the provided payload
//      * @deprecated
//      * @param student
//      * @param rootState
//      * @param payload
//      */
//     [ aTypes.setActiveStudentObject ]: ( {state, commit}, payload ) => {
//         console.log( aTypes.setActiveStudentObject, 'is deprecated!' );
//         [ aTypes.setActiveStudent ]( state, commit, payload );
//         // // let student;
//         //
//         // // if (payload instanceof Student) {
//         // //     student = payload;
//         // // }
//         // // switch(typeof (payload)){
//         // //     case 'number':
//         // //         if(Number.isInteger(payload)){
//         // //             studentIndex = payload;
//         // //         }
//         // //         break;
//         // //     case 'object':
//         // //         //todo write if object
//         // //
//         // //         break;
//         // //     default:
//         // // }
//         //
//         // //Call the mutation
//         // if (payload instanceof Student) {
//         //     commit(mTypes.setStudentObject, payload);
//         // }
//     },
//     /**
//      * Updates the state's stored index for the currently selected
//      * to the index specified in the payload.
//      * Does not update id or student; those must be called separately
//      * @deprecated
//      * @param state
//      * @param rootState
//      * @param payload
//      */
//         [aTypes.setIndex]( {state, commit}, payload ){
//         console.log( aTypes.setIndex, 'is deprecated!' );
//         console.log( aTypes.setIndex, payload );
//         payload = state.activeStudent;
//         actions[ aTypes.setActiveStudent ]( state, commit, payload );
//     },
//
//     /**
//      * Updates the state's stored student id for the currently
//      * selected student to the id specified in the payload.
//      * Does not update index or student; those must be called separately
//      * @deprecated
//      * @param state
//      * @param rootState
//      * @param payload integer
//      * @returns {boolean}
//      */
//         [aTypes.setId]( {state, commit}, payload )
//     {
//         console.log( aTypes.setId, 'is deprecated!' );
//         payload = state.activeStudent;
//
//         actions[ aTypes.setActiveStudent ]( state, commit, payload );
//     },
//
//     /**
//      * Sets the state's stored student object to the
//      * object specified in the payload.
//      * Does not update index or id. Those must be called separately.
//      * @deprecated
//      * @param state
//      * @param rootState
//      * @param payload Student
//      */
//         [aTypes.setStudentObject]( {state, commit}, payload )
//     {
//         payload = state.activeStudent;
//
//         if ( typeof (payload) == 'object' && payload instanceof Student ) {
//             commit( mTypes.setActiveStudent, Payload.factory( {obj: payload} ) )
//             // state.student = payload;
//         }
//     },
//
//
//     // -------------------- from times
//
//     /**
//      * Handles figuring out how to set the time of the the currently
//      * selected student from the provided payload
//      * @returns {boolean}
//      */
//         [aTypes.setActiveStudentTime]( {state, commit}, payload )
//     {
//
//         let studentIndex = state.activeStudent.index;
//         let time;
//
//         switch ( typeof (payload) ) {
//             case 'number':
//                 if ( Number.isInteger( payload ) ) {
//                     //go straight to recording
//                     time = payload;
//                 }
//                 break;
//
//             //object with expected key
//             case 'object':
//                 //todo write if object
//                 break;
//
//             //other allowed types
//             // todo
//
//             //numeric string
//             // todo
//             default:
//             //todo
//         }
//
//         //Call the mutation
//         if ( typeof(time) == 'number' ) {
//             commit( mTypes.setTime, time );
//         }
//     },
//
//     /**
//      * Increases the stored time for the student currently being graded by the specified
//      * amount.
//      * Original: data.this.examGradingTimes[ Roster.activeStudent ];
//      */
//     [aTypes.increaseActiveStudentGradingTime]: ( {state, commit}, payload ) => {
//         let studentIndex = state.activeStudent.index;
//         state.examGradingTimes[ studentIndex ] += payload.timeToAdd;
//     },
//
// // qscores
//
//
//     /**
//      * Save a question score for the currently active student
//      * @param state
//      * @param commit
//      * @param payload
//      */
//     [aTypes.storeQuestionScoreForActiveStudent]: ( {state, commit}, payload ) => {
//         // window.console.log( 'store called', this.activeStudentIndex, questionIndex, score );
//         let {questionIndex, score} = payload;
//         let studentIndex = state.activeStudent.index;
//         //type checking
//
//         let out = Payload.factory( {index2: questionIndex, index: studentIndex, num: score} );
//
//         commit( mTypes.setQuestionScore, out );
//     },
//
//     // escores
//
//     [aTypes.storeElementScoreForActiveStudent]( {state, commit}, payload ) {
//         let studentIndex = state.getActiveStudentIndex();
//         let {elementIndex, score} = payload;
//         //type checks
//
//         if ( typeof (score) == 'undefined' ) {
//             //score may have been named differently
//             score = payload.elementScore;
//         }
//
//
//         let out = Payload.factory( {
//             index: studentIndex,
//             index2: elementIndex,
//             num: score
//         } );
//
//         commit( mTypes.setElementScore, out );
//     },


// }
// ;
