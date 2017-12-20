/**
 * Created by adam on 7/7/17.
 */
import Vue from 'vue';
import * as gTypes from '../../getter-types'
import * as mTypes from '../../mutation-types'
import * as ngmTypes from '../../modules/newgrading/new-grading-mutation-types';
import * as aTypes from '../../action-types'
import * as ngaTypes from '../../modules/newgrading/new-grading-action-types';

import scoreRequests from "../../../api/requests/scoreRequests";

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

export const itemScoreGetter = ( state, itemId, studentId ) => {
    return (function ( state, itemId, studentId ) {
        var r = state.scores.filter( function ( i ) {
            if ( i.itemId === itemId && i.studentId === studentId ) {
                return i;
            }
        } );
        return r[ 0 ];
    })( state, itemId, studentId )
};

/**
 * Sets currentValence to which valence group a [score] belongs to by comparing with valenceCutoffs[]
 * i.e. a score > 0 and <= 2.5 will be in the 'poor' valence (1)
 *
 * @param score
 * @returns {number}
 */
export const getValence = function ( score ) {

    const settings = {
        sliderStep: 0.25,
        valenceCutoffs: [ 0, 3.25, 6.75, 10 ],
        valenceLabels: [ "Missing", "Poor", "Fair", "Excellent" ],
        valenceLabelPositions: [ 0, 33, 67, 100 ]
    };
    let me = this;
    if ( score === null ) throw new Error( "cannot get valence for null" );
    if ( score < 0 || score > settings.valenceCutoffs[ settings.valenceCutoffs.length - 1 ] ) throw new Error( "cannot get valence. value out of range" );

    let valence = 0;
    //start at the second largest value in the cutoffs.
    for (let j = settings.valenceCutoffs.length - 2; j >= 0; j--) {
        if ( score > settings.valenceCutoffs[ j ] ) {
            //if the score is greater than the second largest cutoff value, then it belongs
            //to the highest valence and so on.
            valence = j + 1;
            break;
        }
    }
    //return the set valence. If made it all the way to 0, the default will be returned.
    return valence;
};

/**
 * Check whether the old and new scores have the same valence.
 * If they are, return true.
 * If not or if oldScore wasn't set, return false
 * @param oldScore
 * @param newScore
 * @returns {boolean}
 */
export const isSameValence = function ( oldScore, newScore ) {
    //if there was no old score, return false
    if ( typeof oldScore == 'undefined' || oldScore == null ) {
        return false;
    }
    //check old and new are the same
    if ( getValence( newScore ) != getValence( oldScore ) ) {
        return false;
    }
    return true;
};

export const create = ( state, exam, item, student ) => {
    let obj = ItemScore.factory( {
        examId: exam.id,
        itemId: item.id,
        studentId: student.id
    } );
    //add it to storage
    state.scores.push( obj )
    return obj;
}


const state = {

    //Array of Score objects
    scores: []
};

const mutations = {

    [ ngmTypes.updateScore ]: ( state, payload ) => {
        //check whether we already have the object
        let obj = itemScoreGetter( state, payload.item.id, payload.student.id );
        if ( _.isUndefined( obj ) ) {
            obj = create( state, payload.exam, payload.item, payload.student );
        }
        let score = payload.score;
        //update the object
        Vue.set( obj, 'score', score );
    },

    [ ngmTypes.updateText ]: ( state, payload ) => {
        //check whether we already have the object
        let obj = itemScoreGetter( state, payload.item.id, payload.student.id );
        if ( _.isUndefined( obj ) ) {
            obj = create( state, payload.exam, payload.item, payload.student );
            //
            // obj = ItemScore.factory({
            //     examId:  payload.exam.id,
            //     itemId: payload.item.id,
            //     studentId : payload.student.id
            // });

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

    [ ngaTypes.storeItemScore ]: ( { state, dispatch, commit, getters }, item, student, score ) => {
//store the score
        let pl = PayloadScore.factory( {
            exam: getters[ gTypes.getActiveExamObj ],
            item: item,
            student: student,
            score: score
        } )

        commit( ngmTypes.updateScore, pl );
        /**
         //  * update comment text and save to DB.
         //  * Only replace text if the score has changed valence regions
         //  */
        // if ( !this.isSameValence( this.score, this.elementScore ) ) {
        //     //Score is in a new valence region.
        //     //So let's plug in the appropriate comment text and save to DB
        //     //
        //     //Dear Adam, make sure you read the doc for storeCommentText before fucking with
        //     //anything in these lines
        //     this.commentText = this.store.getCommentTextForActiveStudent( this.elementIndex, this.getValence( this.elementScore ) );
        //
        // } else {
        //     // Score is in the same valence region.
        //     // Jump straight to saving without changing the elementComment
        //     // Fear not. Changes directly to the comment text will be handled elsewhere.
        // }
        //
        // // If using bell curve (standardScoring), element score affects
        // // the total question score, so update
        // // if ( Roster.standardScoring ) {
        // //     //  updateStandardScores();
        // // }

        //decide what to do about the comment

    },

    initializeItemScore: ( { state, dispatch, commit, getters }, { exam, item, student } ) => {
        let me = this;
        return new Promise( function ( resolve, reject ) {
            // window.console.log( 'itemscores', '', 193, exam, item, student);
            commit( ngmTypes.updateScore, PayloadScore.factory( { exam, item, student, mutateSilently: true } ) );
            //create( state, exam, item, student );
            resolve();
        } );
    },

    loadScoresFromServer: ( { state, dispatch, commit, getters }, exam  ) => {
        let me = this;
        return new Promise( function ( resolve, reject ) {
            // window.console.log( 'itemscores', '', 193, exam, item, student);
            let p = scoreRequests.getAllScoresForExamRequest( exam );

            p.then( function ( data ) {
                _.forEach(data, function(d) {
                    let item = getters[ gTypes.getItemById ]( d.item_id );
                    let student = getters.getStudentFromRosterById( d.student_id );
                    let score = parseFloat(d.score);

                    //record the score (this will initialize the object too)
                    commit( ngmTypes.updateScore, PayloadScore.factory( {
                        exam: exam,
                        item: item,
                        student: student,
                        score: score,
                        mutateSilently: true
                    } ) );

                    //record the comment text
                    commit( ngmTypes.updateText, PayloadScore.factory( {
                        exam: exam,
                        item: item,
                        student: student,
                        text: d.comment_text,
                        mutateSilently: true
                    } ) );
                });

                resolve();
            } );


        } );
    },
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
    getItemScoreObject: ( state, getters, rootState, itemId, studentId ) => ( itemId, studentId ) => {
        // window.console.log( 'itemscores', '', 241, itemId, studentId );
        return itemScoreGetter( state, itemId, studentId );

    },
};


export default {
    actions,
    getters,
    mutations,
    state,
}