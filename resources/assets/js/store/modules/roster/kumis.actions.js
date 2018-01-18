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

const KUMIS_JSON_NAME = 'loadedKumis';

import { loadExamKumi } from '../../../api/requests/kumiRequests';

module.exports = {


    /**
     * Requests all kumis for the exam
     * then adds them to the kumi store by calling addKumi
     * on each object returned;
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param exam
     * @returns {Promise<any>}
     */
    loadKumisForExamFromServer( { state, dispatch, commit, getters }, exam ) {
        return new Promise( function ( resolve, reject ) {
            let p = loadExamKumi( exam );
            return p.then( function ( data ) {
                _.forEach( data, ( d ) => {
                    let k = Kumi.factory( d );
                    let pl = Payload.factory( { obj: k, mutateSilently: true } );
                    commit( 'addKumi', pl );
                } );
                resolve();
            } );
        } );
    },


    processKumiFromJson( { state, dispatch, commit, getters } ) {
        let exam = getters.getCurrentExam;
        let kumiData = JSON.parse( document.getElementById( KUMIS_JSON_NAME ).getAttribute( 'data' ) );

        _.forEach( kumiData, function ( d, i ) {
            //first make a kumi from the loaded data and push it into storage
            let kumi = Kumi.factory( { d } );
            //Now associate the kumi with the exam
            let pl = Payload.factory( {
                obj: kumi,
                kumi: kumi,
                examId: exam.id,
                kumiId: kumi.id,
                mutateSilently: true
            } );
            commit( 'addKumi', pl );
            commit( 'associateExamWithKumi', pl );
            if ( i === 0 ) {
                //set the first kumi as the one to display
                commit( 'toggleKumi', pl )
            }
        } );
    }
    ,

    /**
     * Removes all associations between an exam and a kumi.
     * Also removes all student associations with the kumi
     *
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param payload
     */
    removeKumi( { state, dispatch, commit, getters }, payload ) {
    }

};

