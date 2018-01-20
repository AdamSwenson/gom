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
    filterExamAssociations, filterStudentAssociations, filterKumis,
    getKumiById,
    getKumiBySerialNumber,
    processKumiFromJson
} from './kumis.helpers'

module.exports = {

    /**
     * Adds a new kumi object to the list of kumis
     * @param state
     * @param payload
     */
    [mTypes.addKumi]: ( state, payload ) => {
        state.kumis.push( payload.obj );
    },

    /**
     * Alter properties of a kumi
     * @param state
     * @param payload
     */
    [mTypes.updateKumi]: ( state, payload ) => {
        Payload.checkIfPayload( payload );
        let kumi = getKumiBySerialNumber( state, payload.obj.serialNumber );
        Vue.set( kumi, payload.updateProp, payload.updateVal );
     },

    /**
     * Adds an exam to the list of exams the
     * kumi is associated with
     * @param examId
     */
    [mTypes.associateExamWithKumi] : ( state, payload ) => {
//todo Should check that not duplicating?
        let examId = payload.exam.id;
        let kumiId = payload.kumi.id;
        state.examKumiAssociations.push( { examId: examId, kumiId: kumiId } );
    },

    /**
     * Removes the association between a kumi and exam
     * @param examId
     */
    [mTypes.disassociateExamFromKumi]: ( state, payload ) => {
        let examId = payload.exam.id;
        let kumiId = payload.kumi.id;
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
    [mTypes.associateStudentWithKumi]: ( state, payload ) => {
        let student = payload.student;
        let kumi = payload.kumi;

        //store on the student object
        student.associatedKumis.push( kumi );
        //Now, redundantly store it centrally
        //Why? No idea.... Not even sure if anything uses
        //the central store
        // todo Should check that not duplicating?
        state.studentKumiAssociations.push( {
            studentSerialNumber: student.serialNumber,
            kumiSerialNumber: kumi.serialNumber
        } );
    },

    /**
     * Removes the association between the student and a group
     * @param studentId
     */
    [mTypes.disassociateStudentFromKumi]: ( state, payload ) => {
        let student = payload.student;
        let kumi = payload.kumi;
        let index = state.studentKumiAssociations.indexOf( r[ 0 ] );
        state.studentKumiAssociations.splice( index, 1 );
        //remove kumi from array stored in student
        student.associatedKumis.splice( student.associatedKumis.indexOf( kumi ) );
    },

};