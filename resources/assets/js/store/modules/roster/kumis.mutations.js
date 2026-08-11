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
} from './kumis.helpers'

const checkIfNew = ( state, kumi ) => {
    return _.findIndex( state.kumis, { id: kumi.id } ) === -1;
};

export default {
// ------------------ kumi properties
    /**
     * Adds a new kumi object to the list of kumis
     * Since kumis may be loaded at different times, this
     * silently fails to add duplicates
     * @param state
     * @param payload
     */
    [mTypes.addKumi]: ( state, payload ) => {
        //prevent any duplicates since multiple processes
        //may load kumis from the server. We do this
        //check here because there may be other parts of
        //the actions handling the loading which still need to
        //happen
        let kumi = payload.obj;
        if( checkIfNew(state, kumi)) state.kumis.push( kumi );
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

    // -------------------------- exam - kumi
    /**
     * Adds an exam to the list of exams the
     * kumi is associated with
     * @param examId
     */
    [mTypes.associateExamWithKumi] : ( state, payload ) => {
        let mp =  { examId: payload.exam.id, kumiId:  payload.kumi.id };
        ///check that not already present in the list
        //using the lodash function because allows to look up the whole object
        let index = _.findIndex(state.examKumiAssociations, mp);
        if(index === -1){
            state.examKumiAssociations.push(mp );
        }
    },


    /**
     * Removes the association between a kumi and exam
     * @param examId
     */
    [mTypes.disassociateExamFromKumi]: ( state, payload ) => {
        let mp =  { examId: payload.exam.id, kumiId:  payload.kumi.id };
        //using the lodash function because allows to look up the whole object
        let index = _.findIndex(state, mp );
        state.examKumiAssociations.splice( index, 1 );
    },


    //--------------- student - kumi
    /**
     * Creates a relationship between a student and a group (kumi)
     * These get used by the roster actions
     * @param state
     * @param kumiId
     * @param studentId
     */
    [mTypes.associateStudentWithKumi]: ( state, payload ) => {
        let student = payload.student;
        let kumi = payload.kumi;

        //check if the kumi is already associated
        if(! student.isInKumiOrKumiList(kumi) ) {

            //store on the student object
            student.associatedKumis.push( kumi );

            //dev LEGACY
            //Now, redundantly store it centrally
            //Why? No idea.... Not even sure if anything uses
            //the central store
            state.studentKumiAssociations.push( {
                studentSerialNumber: student.serialNumber,
                kumiSerialNumber: kumi.serialNumber
            } );
        }
    },


    /**
     * Removes the association between the student and a group
     * These get used by the roster actions
     * @param studentId
     */
    [mTypes.disassociateStudentFromKumi]: ( state, payload ) => {
        let student = payload.student;
        let kumi = payload.kumi;
        //remove kumi from array stored in student
        student.associatedKumis.splice( student.associatedKumis.indexOf( kumi ) , 1 );

        //dev legacy
        //Remove from legacy storage
        let r = {
            studentSerialNumber: student.serialNumber,
            kumiSerialNumber: kumi.serialNumber
        };
        let index = state.studentKumiAssociations.indexOf( r );
        if(index !== -1) state.studentKumiAssociations.splice( index, 1 );
    },

};