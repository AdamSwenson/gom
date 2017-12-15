/**
 * Created by adam on 7/7/17.
 */
import Vue from 'vue';
import * as gTypes from '../../getter-types'
import * as mTypes from '../../mutation-types'
import * as ngmTypes from '../../modules/newgrading/new-grading-mutation-types';
import * as aTypes from '../../action-types'
import * as ngaTypes from '../../modules/newgrading/new-grading-action-types';

import PayloadScore from '../../../models/PayloadScore';
import ItemScore from '../../../models/ItemScore';

class Score {
    constructor( examId, itemId, studentId ) {
        this.examId = examId;
        this.itemId = itemId;
        this.studentId = studentId;
        this.score;
        this.commentText;
    }
}

export const itemScoreGetter = function( state, itemId, studentId )  {
    return (function ( state, itemId, studentId ) {
        var r = state.scores.filter( function ( i ) {
            if ( i.itemId === itemId && i.studentId === studentId ) {
                return i;
            }
        } );
        return r[ 0 ];
    })( state, itemId, studentId )
};

const state = {

    //Array of Score objects
    scores: []
};

const mutations = {

    [ ngmTypes.updateScore ]: ( state, payload ) => {
        //check whether we already have the object
        let obj = itemScoreGetter( state, payload.item.id, payload.student.id );
        if ( _.isUndefined( obj ) ) {
            obj = ItemScore.factory({
                examId:  payload.exam.id,
                itemId: payload.item.id,
                studentId : payload.student.id
            });
            //add it to storage
            state.scores.push( obj );
        }
        //update the object
        Vue.set( obj, 'score', payload.score );
    },

    [ ngmTypes.updateText ]: ( state, payload ) => {
        //check whether we already have the object
        let obj = itemScoreGetter( state, payload.item.id, payload.student.id );
        if ( _.isUndefined( obj ) ) {
            obj = ItemScore.factory({
                examId:  payload.exam.id,
                itemId: payload.item.id,
                studentId : payload.student.id
            });

            // obj = new Score( payload.exam.id, payload.item.id, payload.student.id );
            //add it to storage
            state.scores.push( obj );
        }
        //update the object
        Vue.set( obj, 'commentText', payload.text );
    }
};

const actions = {
    //
    // [ngaTypes.storeCommentText] : ( { state, dispatch, commit, getters }, item, student, text ) => {
    //
    //     let pl = PayloadScore.factory( {
    //         exam: getters[ gTypes.getActiveExamObj ],
    //         item: item,
    //         student: student,
    //         text: text
    //     } )
    //
    //     commit( ngmTypes.updateText, pl );
    // },
    //
    // [ngaTypes.storeItemScore] : ( { state, dispatch, commit, getters }, item, student, score ) => {
    //
    //     let pl = PayloadScore.factory( {
    //         exam: getters[ gTypes.getActiveExamObj ],
    //         item: item,
    //         student: student,
    //         score: score
    //     } )
    //
    //     commit( ngmTypes.updateScore, pl );
    // }
};

const getters = {

    getExamScores: ( state, getters, rootState, examId ) => ( examId ) => {
        return (function ( state, examId ) {
            var r = state.scores.filter( function ( i ) {
                if ( i.examId === examId ) {
                    return i;
                }
            } );
            return r[ 0 ];
        })( state, examId )
    },

    getItemScores: ( state, getters, rootState, itemId ) => ( ItemId ) => {
        return (function ( state, itemId ) {
            var r = state.scores.filter( function ( i ) {
                if ( i.itemId === itemId ) {
                    return i;
                }
            } );
            return r[ 0 ];
        })( state, itemId )
    },

    getStudentScores: ( state, getters, rootState, studentId ) =>
        ( studentId ) => {
            return (function ( state, studentId ) {
                var r = state.scores.filter( function ( i ) {
                    if ( i.studentId === studentId ) {
                        return i;
                    }
                } );
                return r[ 0 ];
            })( state, studentId )
        },


    /**
     * Returns the score object for the given item
     * and student.
     * This object includes score and commentText fields
     * @param state
     * @param getters
     * @param rootState
     * @param itemId
     * @param studentId
     * @returns {function(*=, *=)}
     */
    getItemScoreObject: ( state, getters, rootState, itemId, studentId ) => {
        return itemScoreGetter( state, itemId, studentId );
        // (function ( state, itemId, studentId ) {
        //     var r = state.scores.filter( function ( i ) {
        //         if ( i.itemId === itemId  && i.studentId === studentId) {
        //             return i;
        //         }
        //     } );
        //     return r[ 0 ];
        // })( state, itemId, studentId )
    },
};


export default {
    actions,
    getters,
    mutations,
    state,
}