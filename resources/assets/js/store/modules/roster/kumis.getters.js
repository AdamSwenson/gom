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


import {
    filterExamKumiAssociations, filterStudentAssociations, filterKumis,
    getKumiById,
    getKumiBySerialNumber,
    processKumiFromJson
} from './kumis.helpers';


module.exports = {

    areKumiAndExamAssociated: ( state, getters, rootState, objs ) => ( objs ) => {
        let { exam, kumi } = objs;
        let r = state.examKumiAssociations.filter( ( i ) => {
            if ( i.examId === exam.id && i.kumiId === kumi.id ) {
                return i;
            }
        } );
        return r.length > 0;
    },

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
    getKumiById:
        ( state, getters, rootState, kumiId ) => ( kumiId ) => {
            return getKumiById( state, kumiId );
        },

    /**
     * Returns all kumis that have been loaded
     * @param state
     * @returns {any[] | _.LoDashImplicitArrayWrapper<T> | _.LoDashImplicitArrayWrapper<any> | _.LoDashExplicitArrayWrapper<T> | _.LoDashExplicitArrayWrapper<any>}
     */
    [ gTypes.getAllKumis ]:
        ( state ) => {
            return _.uniq( state.kumis );
        },

    /**
     * Returns all kumi objects associated with the exam
     * @param examId
     */
    [ gTypes.getKumisForExam ]:
        ( state, getters, rootState, exam ) => ( exam ) => {
            let kumiAssocs = filterExamKumiAssociations( state, 'examId', exam.id );
            let out = [];
            _.forEach( kumiAssocs, function ( i ) {
                //since the associations only have ids,
                //we add the object for each to our list
                let kumi = getters.getKumiById( i.kumiId );
                out.push( kumi );
            } );
            return _.uniq( out );
        },

    /**
     * Returns all exams associated with the given kumi
     */
    getKumiExams:
        ( state, kumiOrKumiId, returnObjects = false ) => {
            let objId = kumiOrKumiId;
            let examIds = filterExamKumiAssociations( state, objId );
            if ( !returnObjects ) return examIds;
            //todo return objects
        },

    /**
     * Returns the root kumi object which attaches
     * the exam to the students, i.e., the roster
     * @param state
     * @param getters
     */
    getRootKumi:

        function ( state, getters ) {
            let idx = _.findIndex( state.kumis, { isRoster: true } );
            if ( idx >= 0 ) {
                return state.kumis[ idx ];
            }
            // return state.kumis[ 0 ];
        }

    ,


//Remember students can belong to more than one kumi
    getStudentsForKumi: ( state, getters, rootState, kumi ) => ( kumi ) => {
        let studentSerialNumbers = filterStudentAssociations( state, 'serialNumber', kumi.serialNumber );
        let out = [];
        _.forEach( studentSerialNumbers, ( i ) => {
            out.push( getters.getStudentFromRosterBySerialNumber( i ) );
        } );
        return out;
    },


    [ gTypes.getKumiCount ]:
        ( state, getters, rootState ) => {
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

}
;
