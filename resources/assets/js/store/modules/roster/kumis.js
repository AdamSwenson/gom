/**
 * Created by adam on 7/11/17.
 */
import Vue from 'vue'
import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'

import Payload from '../../../models/Payload'
import Kumi from '../../../models/Kumi'

const KUMIS_JSON_NAME = 'loadedKumis';


const state = {
    kumis: [],

    //holds objects with keys examId and kumiId
    examKumiAssociations: [],

    //holds objects with keys studentSN and kumiSN
    studentKumiAssociations: [],

    /**
     * This is either null or a kumi object
     * if it is null, we are supposed to show all kumi and students
     * associated with the exam
     */
    selectedKumi: null
};

const filterExamAssociations = ( state, prop, val ) => {
    return state.examKumiAssociations.filter( ( i ) => {
        if ( i[ key ] === val ) {
            return i;
        }
    } );
};


const filterStudentAssociations = ( state, prop, val ) => {
    return state.studentKumiAssociations.filter( ( i ) => {
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


const getKumiBySerialNumber = ( state, ksn ) => {
    let r = filterKumis( state, 'serialNumber', ksn );
    return r[ 0 ];
};

const processKumiFromJson = function ( state, kumiData, exam ) {
    _.forEach( kumiData, function ( d, i ) {
        //first make a kumi from the loaded data
        let kumi = Kumi.factory( { d } );
        let pl = Payload.factory( {
            obj: kumi,
            examId: exam.id,
            kumiId: kumi.id,
            mutateSilently: true
        } );

        // push it into storage
        // state.commit('addKumi', pl);
        state.kumis.push( kumi );

        if ( i === 0 ) {
            //set the first kumi as the one to display
            //this needs to happen before associate exam is called
            state.commit( 'updateSelectedKumi', pl )
        }

        //Now associate the kumi with the exam
        state.commit( 'associateExamWithKumi', pl );


    } );
};

const mutations = {

    addKumi: ( state, payload ) => {
        state.kumis.push( payload.obj );
    },

    updateKumi: ( state, payload ) => {
        Payload.checkIfPayload( payload );
        let kumi = getKumiBySerialNumber( state, payload.obj.serialNumber );
        Vue.set( kumi, payload.updateProp, payload.updateVal );
        // let idx = state.kumis.indexOf( kumi );
        // window.console.log( 'kumis', 'updateKumi', 50, state.kumis, idx, payload);
        //
        // Vue.set( state.kumis[idx], payload.updateProp, payload.updateVal );
    },

    /**
     * Adds an exam to the list of exams the
     * kumi is associated with
     * @param examId
     */
    associateExamWithKumi: ( state, payload ) => {
//todo Should check that not duplicating?
        let examId = payload.examId;
        let kumiId = payload.kumiId;
        state.examKumiAssociations.push( { examId: examId, kumiId: kumiId } );
    },

    /**
     *
     * @param examId
     */
    disassociateExamFromKumi: ( state, payload ) => {
        let examId = payload.examId;
        let kumiId = payload.kumiId;
        let r = filterExamAssociations( state, kumiId, examId );
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
    associateStudentWithKumi: ( state, payload ) => {
        let student = payload.student;
        let kumi = payload.kumi;
//todo Should check that not duplicating?
        state.studentKumiAssociations.push( {
            studentSerialNumber: student.serialNumber,
            kumiSerialNumber: kumi.serialNumber
        } );
    },

    /**
     *
     * @param studentId
     */
    disassociateStudentFromKumi: ( state, payload ) => {
        let studentId = payload.studentId;
        let kumiId = payload.kumiId;
        let r = filterStudentAssociations( state, kumiId, studentId );
        let index = state.studentKumiAssociations.indexOf( r[ 0 ] );
        state.studentKumiAssociations.splice( index, 1 );
    },

    updateSelectedKumi: ( state, payload ) => {
        //if no payload arrived, use the 0th kumi
        //this is so we don't have to look up the 0th kumi and do
        //it from another module
        let kumi = ! _.isUndefined(payload) && ! _.isUndefined(payload.obj) ? payload.obj : state.kumis[ 0 ];
        state.selectedKumi = kumi;
    }


};

const actions = {
    processKumiFromJson( { state, dispatch, commit, getters } ){
        let exam = getters.getCurrentExam;
        let kumiData = JSON.parse( document.getElementById( KUMIS_JSON_NAME ).getAttribute( 'data' ) );

        _.forEach( kumiData, function ( d, i ) {
            //first make a kumi from the loaded data and push it into storage
            let kumi = Kumi.factory( { d } );
            //Now associate the kumi with the exam
            let pl = Payload.factory( {
                obj: kumi,
                examId: exam.id,
                kumiId: kumi.id,
                mutateSilently: true
            } );
            commit( 'addKumi', pl );
            commit( 'associateExamWithKumi', pl );
            if ( i === 0 ) {
                //set the first kumi as the one to display
                commit( 'updateSelectedKumi', pl )
            }
        } );

    }
};


const getters = {
    getKumiBySerialNumber: ( state, getters, rootState, serialNumber ) => ( serialNumber ) => {
        return getKumiBySerialNumber( state, serialNumber );
    },

    getKumis: function ( state ) {
        return state.kumis;
    },

    /**
     * Returns all kumis associated with the exam
     * @param examId
     */
    getExamKumis: ( state, getters, rootState, examOrExamId ) => ( examOrExamId ) => {
        // return new Promise((resolve, reject)=>{

        let exam = _.isUndefined(examOrExamId) ? this.$store.getters.currentExam : examOrExamId;

        // let objId = examOrExamId;
        let objId = exam.id;
        let kumiIds = filterExamAssociations( state, objId );
        // if ( !returnObjects ) return kumiIds;

        let out = [];
        _.forEach( kumiIds, ( i ) => {
            let kumi = getKumiById( state, i );
            out.push( kumi );
        } );
        // resolve(out);
        return out;
        // });
    },

    /**
     * Returns all exams associated with the given kumi
     */
    getKumiExams: ( state, kumiOrKumiId, returnObjects = false ) => {
        let objId = kumiOrKumiId;
        let examIds = filterExamAssociations( state, objId );
        if ( !returnObjects ) return examIds;
        //todo return objects
    },

    getStudentsForKumi: ( state, getters, rootState, kumiOrKumiId ) => ( kumiOrKumiId ) => {
        let kumi = kumiOrKumiId;
        let studentSerialNumbers = filterStudentAssociations( state, 'serialNumber', kumi.serialNumber );
        let out = [];
        _.forEach( studentSerialNumbers, ( i ) => {
            out.push( getters.getStudentFromRosterBySerialNumber( i ) );
        } );
        return out;

    },

    /**
     * Returns the currently selected kumi object or null if
     * no kumi is set
     * @param state
     * @param getters
     * @param rootState
     */
    getSelectedKumi: ( state, getters, rootState ) => {
        return state.selectedKumi;
    },


    /**
     * Returns true if the specified student is in the
     * presently selected kumi or, if all kumis are selected.
     * Returns false otherwise
     * @param state
     * @param getters
     * @param rootState
     * @param studentOrStudentId
     * @returns {boolean}
     */
    isStudentInSelectedKumi: ( state, getters, rootState, studentOrStudentId ) => ( studentOrStudentId ) => {
        try {
            let kumi = getters.getSelectedKumi;

            //if the selected kumi is null, then we are to
            //display all kumi associated with the exam
            if ( _.isNull( kumi ) ) return true;

            //todo add support for student id
            let student = studentOrStudentId;
            let students = getters.getStudentsForKumi( kumi );
            window.console.log( 'kumis', 'isStudentInSelectedKumi', 222, student, kumi, students );
            if ( students.indexOf( student ) >= 0 ) return true;
            return false;

        } catch (Error) {
            window.console.log( 'kumis', 'isStudentInSelectedKumi', 209, Error );
            //       return false;
        }
    }

};


export default {
    actions,
    getters,
    mutations,
    state,
}