/**
 * Created by adam on 7/7/17.
 */
import Vue from 'vue';
import * as gTypes from '../../getter-types'
import * as mTypes from '../../mutation-types'
import * as ngmTypes from '../../modules/newgrading/new-grading-mutation-types';
import * as aTypes from '../../action-types'
import * as ngaTypes from '../../modules/newgrading/new-grading-action-types';
import * as nggTypes from '../../modules/newgrading/new-grading-getter-types';

import scoreRequests from "../../../api/requests/scoreRequests";

import { isSameValence, getValenceForScore, sliderSettings } from "./commentHelpers";

import PayloadScore from '../../../models/PayloadScore';
import ItemScore from '../../../models/ItemScore';

// class Score {
//     constructor( examId, itemId, studentId ) {
//         this.examId = examId;
//         this.itemId = itemId;
//         this.studentId = studentId;
//         this.score;
//         this.commentText;
//     }
// }

//
// export const itemScoreGetter = ( state, itemId, studentId ) => {
//     return (function ( state, itemId, studentId ) {
//         var r = state.scores.filter( function ( i ) {
//             if ( i.itemId === itemId && i.studentId === studentId ) {
//                 return i;
//             }
//         } );
//         return r[ 0 ];
//     })( state, itemId, studentId )
// };
//
//
// export const create = ( state, exam, item, student ) => {
//     let obj = ItemScore.factory( {
//         examId: exam.id,
//         itemId: item.id,
//         studentId: student.id
//     } );
//     //add it to storage
//     state.scores.push( obj )
//     return obj;
// }
//

const state = {
    //Array of Score objects
    scores: []
};
//
// const mutations = {
//
//     [ ngmTypes.updateScore ]: ( state, payload ) => {
//         //check whether we already have the object
//         let obj = itemScoreGetter( state, payload.item.id, payload.student.id );
//         if ( _.isUndefined( obj ) ) {
//             obj = create( state, payload.exam, payload.item, payload.student );
//         }
//         let score = payload.score;
//         //update the object
//         Vue.set( obj, 'score', score );
//     },
//
//     [ ngmTypes.updateText ]: ( state, payload ) => {
//         //check whether we already have the object
//         let obj = itemScoreGetter( state, payload.item.id, payload.student.id );
//         if ( _.isUndefined( obj ) ) {
//             obj = create( state, payload.exam, payload.item, payload.student );
//         }
//         let text = payload.text;
//         //update the object
//         Vue.set( obj, 'text', text );
//     }
// };

// const actions = {
//     initializeItemScore: ( { state, dispatch, commit, getters }, { exam, item, student } ) => {
//         let me = this;
//         return new Promise( function ( resolve, reject ) {
//             // window.console.log( 'itemscores', '', 193, exam, item, student);
//             commit( ngmTypes.updateScore, PayloadScore.factory( { exam, item, student, mutateSilently: true } ) );
//             //create( state, exam, item, student );
//             resolve();
//         } );
//     },
//
//     loadScoresFromServer: ( { state, dispatch, commit, getters }, exam ) => {
//         let me = this;
//         return new Promise( function ( resolve, reject ) {
//             // window.console.log( 'itemscores', '', 193, exam, item, student);
//             let p = scoreRequests.getAllScoresForExamRequest( exam );
//
//             p.then( function ( data ) {
//                 _.forEach( data, function ( d ) {
//                     let item = getters[ gTypes.getItemById ]( d.item_id );
//                     let student = getters.getStudentFromRosterById( d.student_id );
//                     let score = parseFloat( d.score );
//
//                     //record the score (this will initialize the object too)
//                     commit( ngmTypes.updateScore, PayloadScore.factory( {
//                         exam: exam,
//                         item: item,
//                         student: student,
//                         score: score,
//                         mutateSilently: true
//                     } ) );
//
//                     //record the comment text
//                     commit( ngmTypes.updateText, PayloadScore.factory( {
//                         exam: exam,
//                         item: item,
//                         student: student,
//                         text: d.comment_text,
//                         mutateSilently: true
//                     } ) );
//                 } );
//
//                 resolve();
//             } );
//
//
//         } );
//     },
//     /**
//      * This handles saving an item score to the server
//      * as well as updating the comments and performing
//      * any other necessary actions.
//      *
//      * Any change to the item score (aside from initial load)
//      * should happen through this
//      *
//      * @param state
//      * @param dispatch
//      * @param commit
//      * @param getters
//      * @param item
//      * @param student
//      * @param score
//      */
//     [ ngaTypes.recordItemScore ]: ( { state, dispatch, commit, getters }, { exam, item, student, score } ) => {
//         return new Promise( function ( resolve, reject ) {
//
//             //store the score
//             let pl = PayloadScore.factory( {
//                 exam: exam,
//                 item: item,
//                 student: student,
//                 score: score
//             } );
//
//             //before we save the score and thus lose
//             // what the previous score was, we need to
//             //check whether the valence has changed
//             let oldScore = getters[ nggTypes.getItemScoreObject ]( {item : item, student: student} );
//             let sameValence = _.isUndefined(oldScore) ? false : isSameValence( oldScore.score, score, item.maxScore );
//             window.console.log( 'itemscores', 'sqmc', 163, oldScore, sameValence);
//             //Similarly, we need to determine whether the presently
//             //existing text has been customized by the user. If it has,
//             //we don't want changes of the slider and score to overwrite
//             //the text
//             //todo dev
//             let customText = false;
//
//             let p1 = new Promise( function ( resolve, reject ) {
//                 commit( ngmTypes.updateScore, pl );
//                 resolve();
//             } );
//
//             p1.then( function () {
//                 //We only need to alter text if the score has changed valence regions
//                 //if the valence hasn't changed or if the text is customized, we are done
//                 if ( sameValence || customText ) resolve();
//
//                 //Ok. So the score is in a new valence region and we're using stock
//                 //comments. Let's get the appropriate stock comment text and update
//                 // accordingly.
//                 let newValenceIdx = getValenceForScore( score, item.maxScore );
//                 let newValenceName = _.lowerCase(sliderSettings.valenceLabels[ newValenceIdx ]);
//                 let comment = item.comments.get( newValenceName );
//                 //This needs to be stored / saved
//                 let pl2 = {
//                     exam: exam,
//                     item: item,
//                     student: student,
//                     text: comment
//                 };
//
//                 //call the action to record the new comment
//                 let p2 = dispatch( ngaTypes.recordCommentText, pl2 );
//                 p2.then( function () {
//                     resolve();
//                 } );
//
//             } );
//
//         } );
//     },
//
//     /**
//      * This handles saving the comment text to the server.
//      * It performs all other relevant tasks. Any change to the
//      * comment text should be made using this.
//      * @param state
//      * @param dispatch
//      * @param commit
//      * @param getters
//      * @param exam
//      * @param item
//      * @param student
//      */
//     [ ngaTypes.recordCommentText ]: ( { state, dispatch, commit, getters }, { exam, item, student, text } ) => {
//         return new Promise( function ( resolve, reject ) {
//
//             //todo Checks for making sure that the text isn't custom go here
//
//             //store the score
//             let pl = PayloadScore.factory( {
//                 exam: exam,
//                 item: item,
//                 student: student,
//                 text: text
//             } );
//
//             commit( ngmTypes.updateText, pl );
//
//             //todo we may need to handle flagging the text as custom here so it won't get overwritten
//             resolve();
//         } );
//     },
//
//
// };

// const getters = {
//
//     getExamScores: ( state, getters, rootState, examId ) => ( examId ) => {
//         return (function ( state, examId ) {
//             var r = state.scores.filter( function ( i ) {
//                 if ( i.examId === examId ) {
//                     return i;
//                 }
//             } );
//             return r[ 0 ];
//         })( state, examId )
//     },
//
//     getItemScores: ( state, getters, rootState, itemId ) => ( ItemId ) => {
//         return (function ( state, itemId ) {
//             var r = state.scores.filter( function ( i ) {
//                 if ( i.itemId === itemId ) {
//                     return i;
//                 }
//             } );
//             return r[ 0 ];
//         })( state, itemId )
//     },
//
//     getStudentScores: ( state, getters, rootState, studentId ) =>
//         ( studentId ) => {
//             return (function ( state, studentId ) {
//                 var r = state.scores.filter( function ( i ) {
//                     if ( i.studentId === studentId ) {
//                         return i;
//                     }
//                 } );
//                 return r[ 0 ];
//             })( state, studentId )
//         },
//
//
//     /**
//      * Returns the score object for the given item
//      * and student.
//      * This object includes score and commentText fields
//      * @param state
//      * @param getters
//      * @param rootState
//      * @param itemId
//      * @param studentId
//      * @returns {function(*=, *=)}
//      */
//     [ nggTypes.getItemScoreObject ]: ( state, getters, rootState, { item, student } ) => ( { item, student } ) => {
//         return (function(state, item, student){
//             if ( !_.isUndefined( item ) && !_.isUndefined( student ) ) {
//                 return itemScoreGetter( state, item.id, student.id );
//             }
//         })(item, student)
//     },
// };

import actions from './itemscores.actions';
import getters from './itemscores.getters';
import mutations from './itemscores.mutations';

export default {
    actions,
    getters,
    mutations,
    state,
}