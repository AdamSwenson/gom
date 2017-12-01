/**
 * Created by adam on 11/30/17.
 */

/**
 * This holds information about how many students or
 * completed exams need to be graded and how many have been
 * graded
 */

import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'

const getForExam = ( state, serialNumber ) => {
    return (function ( state, serialNumber ) {
        var r = state.counts.filter( function ( i ) {
            if ( i.serialNumber === serialNumber ) {
                return i;
            }
        } );
        return r[ 0 ];
    })( state, serialNumber )
};


const countObj = {
    serialNumber,
    totalExams,
    examGraded
};

const state = {
    counts: {}
};

const mutations = {

    addCountsForExam: function () {

    }
};

const actions = {};

const getters = {

    getTotalNumberOfExamsToGrade: ( state, getters, rootState, serialNumber ) => ( serialNumber ) => {
        let stats = getForExam( state, serialNumber );
        return stats.totalExams;
    },

    getNumberGraded: ( state, getters, rootState, serialNumber ) => ( serialNumber ) => {
        let stats = getForExam( state, serialNumber );
        return stats.examsGraded;
    }

};


export default {
    actions,
    getters,
    mutations,
    state,
}