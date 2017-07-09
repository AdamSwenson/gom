/**
 * Created by adam on 7/7/17.
 */

import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'

class Score {
    constructor( examId, itemId, studentId ) {
        this.examId = examId;
        this.itemId = itemId;
        this.studentId = studentId;
        this.score;
        this.commentText;
    }
}


const state = {
    scores: []
};

const mutations = {};

const actions = {};

const getters = {

    getExamScores: ( state, getters, rootState, examId ) => ( examId ) => {
        return (function ( state, studentId ) {
            var r = state.scores.filter( function ( i ) {
                if ( i.examId === examId ) {
                    return i;
                }
            } );
            return r[ 0 ];
        })( state, examId )
    },

    getItemScores: ( state, getters, rootState, itemId ) => (ItemId ) => {
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
        }
};


export default {
    actions,
    getters,
    mutations,
    state,
}