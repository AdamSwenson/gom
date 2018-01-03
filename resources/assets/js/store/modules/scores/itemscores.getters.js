import * as nggTypes from "../newgrading/new-grading-getter-types";
import { itemScoreGetter } from "./itemscores.helpers";

module.exports = {

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
                return r;
            })( state, studentId )
        },

    /**
     * Returns all the item scores currently
     * in store
     */
    [ nggTypes.getAllItemScores ]: ( state, getters, rootState ) => {
        return state.scores;
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
    [ nggTypes.getItemScoreObject ]: ( state, getters, rootState, pl ) => ( pl ) => {
        let { item, student } = pl;
        return (function ( state, item, student ) {
            if ( !_.isUndefined( item ) && !_.isUndefined( student ) ) {
                return itemScoreGetter( state, item.id, student.id );
            }
        })( state, item, student )
    },

    /**
     * Returns the sum of item scores for the student
     * @param state
     * @param getters
     * @param rootState
     * @param student
     * @returns {function(*)}
     */
    [ nggTypes.getTotalScoreForStudent] : ( state, getters, rootState, student ) => ( student ) => {
            let scores = getters.getStudentScores( student.id );
            let total = 0;
            _.forEach( scores, function ( scoreObj ) {
                total += _.isNumber( scoreObj.score ) ? scoreObj.score : 0;
            } );
            return total;
    }
};

