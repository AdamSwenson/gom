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
import Vue from 'vue';
import * as mTypes from '../../mutation-types';
import * as aTypes from '../../action-types';
import * as gTypes from '../../getter-types';

import Payload from '../../../models/Payload';
import Kumi from '../../../models/Kumi';
import Student from '../../../models/Student';

import { createKumiRequest, disassociateKumiAndExam } from '../../../api/requests/kumiRequests';
import { disassociateStudent } from "../../../api/requests/studentRequests";

const KUMIS_JSON_NAME = 'loadedKumis';


module.exports = {


    /**
     * Creates a new kumi and gets the id from the server
     * before storing it centrally.
     *
     * ANY PROCESS WISHING TO CREATE A KUMI SHOULD
     * DISPATCH THIS ACTION
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param payload
     */
    createKumi( { state, dispatch, commit, getters } ) {
        return new Promise( function ( resolve, reject ) {
            let exam = getters[ gTypes.getActiveExam ];
            let kumi = new Kumi();
            createKumiRequest( kumi, exam )
                .then( function ( data ) {
                    kumi.id = data.id;
                    commit( mTypes.addKumi, Payload.factory( {
                        obj: kumi,
                        mutateSilently: true
                    } ) );
                    resolve( kumi );
                } );
        } );
    },


    /**
     * Removes all associations between an exam and a kumi.
     * Also removes all student associations (from this roster)
     * with the kumi
     *
     * NB, it does not delete the kumi itself. Nor does it disassociate
     * any students who weren't on this exam. So if someone had created
     * a kumi for students needing intervention (which would link them
     * across exams), it and its relationships to other students
     * would be unaffected
     *
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param payload
     */
    removeKumi( { state, dispatch, commit, getters }, payload ) {
        return new Promise( function ( resolve, reject ) {

            //We first remove the associations between the kumi
            //and the exam
            let { kumi, exam } = payload;
            disassociateKumiAndExam( kumi, exam )
                .then( function () {
                    commit( mTypes.disassociateExamFromKumi, payload );
                } );

            //now we need to remove the student associations
            let students = getters.getStudentsForKumi( kumi );
            //if there are none, then we are done
            if ( _.isUndefined( students ) || students.length === 0 ) return resolve();

            //Otherwise we ask the server to remove any relationship for each one
            dispatch( 'removeStudentsFromKumis',
                Payload.factory( {
                        students: student,
                        kumis: [ kumi ]
                    } ) ).then( function () {
                resolve();
            } );

        } );
    }


}
;

