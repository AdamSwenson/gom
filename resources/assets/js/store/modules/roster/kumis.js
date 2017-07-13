/**
 * Created by adam on 7/11/17.
 */

import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'

const state = {
    kumis: [],

    //holds objects with keys examId and kumiId
    examKumiAssociations: [],

    //holds objects with keys studentId and kumiId
    studentKumiAssociations: []
};

const filterAssociations = ( state, prop, val ) => {
    return state.examKumiAssociations.filter( ( i ) => {
        if ( i[ key ] === val ) {
            return i;
        }
    } );
};

const filterKumis = ( state, prop, val ) => {
    return state.kumis.filter( ( i ) => {
        if ( i[ prop ] === val ) {
            return i;
        }
    } );
};

const getKumiById = ( state, kumiId ) => {
    let r = filterKumis( state, 'id', kumiId );
    return r[ 0 ];
};

const mutations = {

    addKumi: (state, kumi)=>{
        state.kumis.push(kumi);
    },

    updateKumi: (state, kumi) =>{
//todo
    },

    /**
     * Adds an exam to the list of exams the
     * kumi is associated with
     * @param examId
     */
    associateExamWithKumi: ( state, kumiId, examId ) => {
//todo Should check that not duplicating?
        state.examKumiAssociations.push( { examId: examId, kumiId: kumiId } );
    },

    /**
     *
     * @param examId
     */
    disassociateExamFromKumi: ( state, kumiId, examId ) => {
        let r = filterAssociations( state, kumiId, examId );
        let index = state.examKumiAssociations.indexOf( r[ 0 ] );
        state.examKumiAssociations.splice( index, 1 );
    },

    /**
     * Creates a relationship between a student and a group (kumi)
     *
     * @param state
     * @param kumiId
     * @param studentId
     */
    associateStudentWithKumi: ( state, kumiId, studentId ) => {
//todo Should check that not duplicating?
        state.studentKumiAssociations.push( { studentId: studentId, kumiId: kumiId } );
    },

    /**
     *
     * @param studentId
     */
    disassociateStudentFromKumi: ( state, kumiId, studentId ) => {
        let r = filterAssociations( state, kumiId, studentId );
        let index = state.studentKumiAssociations.indexOf( r[ 0 ] );
        state.studentKumiAssociations.splice( index, 1 );
    }

};

const actions = {};


const getters = {
    /**
     * Returns all kumis associated with the exam
     * @param examId
     */
    getExamKumis: ( state, examOrExamId, returnObjects = false ) => {
        let objId = examOrExamId;
        let kumiIds = filterAssociations( state, objId );
        if ( !returnObjects ) return kumiIds;

        //todo return objects
    },

    /**
     * Returns all exams associated with the given kumi
     */
    getKumiExams: ( state, kumiOrKumiId, returnObjects = false ) => {
        let objId = kumiOrKumiId;
        let examIds = filterAssociations( state, objId );
        if ( !returnObjects ) return examIds;
        //todo return objects
    }
};


export default {
    actions,
    getters,
    mutations,
    state,
}