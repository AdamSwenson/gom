/**
 * This handles kumi object storage and
 * the relationships between kumi and other
 * objects.
 *
 * It does not handle the display properties
 * (e.g., which are selected for display). That
 * is handled in display.js
 *
 *
 * Created by adam on 7/11/17.
 */
import Vue from 'vue'
import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types'

import Payload from '../../../models/Payload'
import Kumi from '../../../models/Kumi'
import Student from '../../../models/Student'

const KUMIS_JSON_NAME = 'loadedKumis';


const filterExamAssociations = ( state, prop, val ) => {
    return state.examKumiAssociations.filter( ( i ) => {
        if ( i[ prop ] === val ) {
            return i;
        }
    } );
};


const filterStudentAssociations = ( state, prop, val ) => {
    return state.studentKumiAssociations.filter( ( i ) => {
        if ( i[ prop ] === val ) {
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
            state.commit( 'toggleKumi', pl )
        }

        //Now associate the kumi with the exam
        state.commit( 'associateExamWithKumi', pl );


    } );
};

module.exports = {

    getKumiBySerialNumber: ( state, getters, rootState, serialNumber ) => ( serialNumber ) => {
        return getKumiBySerialNumber( state, serialNumber );
    },


    /**
     * Looks up the client side representation of a Kumi object
     * @param state
     * @param getters
     * @param rootState
     * @param serialNumber
     */
    getKumiById: ( state, getters, rootState, kumiId ) => ( kumiId ) => {
        return getKumiById( state, kumiId );
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

        let exam = _.isUndefined( examOrExamId ) ? this.$store.getters.currentExam : examOrExamId;

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

    /**
     * Returns the root kumi object which attaches
     * the exam to the students, i.e., the roster
     * @param state
     * @param getters
     */
    getRootKumi: function ( state, getters ) {
        return state.kumis[0];
    },


    //Remember students can belong to more than one kumi
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
     * Returns true if the specified student is in the
     * presently displayed kumis or, if all kumis are selected.
     * Returns false otherwise
     * @param state
     * @param getters
     * @param rootState
     * @param studentOrStudentSN
     * @returns {boolean}
     */
    isStudentInDisplayedKumi: ( state, getters, rootState, studentOrStudentSN ) => ( studentOrStudentSN ) => {
        try {
            let selectedKumis = getters.getDisplayedKumis;

            //if the selected kumi is null or empty, then we are to
            //display all kumi associated with the exam
            if ( _.isNull( selectedKumis ) || selectedKumis.length === 0 ) return true;

            let student = studentOrStudentSN instanceof Student ? studentOrStudentSN : getters.getStudentFromRosterBySerialNumber( studentOrStudentSN );

            // if(student.associatedKumis.length===0) return false;

            // window.console.log( 'kumis', '', 310, selectedKumis, student);
            let a = false;
            _.forEach( selectedKumis, function ( kumi ) {
                _.forEach( student.associatedKumis, function ( k ) {
                    // window.console.log( 'kumis', 'k', 316, kumi, k );
                    if ( kumi.serialNumber === k.serialNumber )
                        a = true;
                } );
                // if(filterStudentAssociations(student, 'serialNumber', kumi.serialNumber)) return true;
                // if ( student.associatedKumis.indexOf( kumi ) > -1 ) return true;
            } );

            return a;

        } catch (Error) {
            window.console.log( 'kumis', 'isStudentInDisplayedKumi', 325, Error );
            return false;
        }
    },


    /**
     * Returns true if the specified student is in the
     * presently selected kumi or, if all kumis are selected.
     * Returns false otherwise
     * @param state
     * @param getters
     * @param rootState
     * @param studentOrStudentSN
     * @returns {boolean}
     */
    isStudentInSelectedKumi: ( state, getters, rootState, studentOrStudentSN ) => ( studentOrStudentSN ) => {
        try {
            let selectedKumis = getters.getSelectedKumis;

            //if the selected kumi is null or empty, then we are to
            //display all kumi associated with the exam
            if ( _.isNull( selectedKumis ) || selectedKumis.length === 0 ) return true;

            let student = studentOrStudentSN instanceof Student ? studentOrStudentSN : getters.getStudentFromRosterBySerialNumber( studentOrStudentSN );

            _.forEach( selectedKumis, function ( kumi ) {
                if ( student.associatedKumis.indexOf( kumi ) > -1 ) return true;
            } );

            return false;
//            return student.associatedKumis.indexOf( kumi ) > -1;
            //     //if the selected kumi is null, then we are to
            //     //display all kumi associated with the exam
            //     if ( _.isNull( kumi ) ) return true;
            //
            //     //todo add support for student id
            //     let student = studentOrStudentId;
            //     let students = getters.getStudentsForKumi( kumi );
            //     window.console.log( 'kumis', 'isStudentInSelectedKumi', 222, student, kumi, students );
            //     if ( students.indexOf( student ) >= 0 ) return true;
            //     return false;

        } catch (Error) {
            window.console.log( 'kumis', 'isStudentInSelectedKumi', 209, Error );
            return false;
        }
    },


    [ gTypes.getKumiCount ]: ( state, getters, rootState ) => {
        return _.size( state.kumis );
    }

    // [gTypes.getKumiCountForExam ]: ( state, getters, rootState, examOrExamId ) => ( examOrExamId ) => {
    //     return _.size(state.kumis);
    //
    //     let exam = _.isUndefined( examOrExamId ) ? this.$store.getters.currentExam : examOrExamId;
    //     let kumis = getters.getExamKumis(examOrExamId);
    //     // let objId = exam.id;
    //     // let kumiIds = filterExamAssociations( state, objId );
    //
    //     return _.size(kumis);
    //
    // }

};
