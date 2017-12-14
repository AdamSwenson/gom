/**
 * Created by adam on 7/6/17.
 */

import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT, Routes } from '../apiSettings';

import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Exam from '../../models/Exam'
import Item from '../../models/Item'
import { errorHandling, handleResponse } from "../responseHandlers";


module.exports = {

    loadAllExams: ( store ) => {
        window.console.log( 'apiPlugin-examRequests', 'loadAllExams', 8 );
        let out = {
            requestVersion: REQUEST_VERSION
        };

        window.axios
            .get( Routes.loadAllExams() )
            .then( ( response ) => {
                // _.forEach( response.data, function ( e ) {
                _.forEach( response.data, function ( r ) {
                    // window.console.log( 'examRequests', 'r', 29, r);
                    let exam = Exam.factory( { r } );
                    exam.id = r.id;
                    exam.name = r.name;
                    exam.term = r.term;
                    exam.maxScore = r.maxScore;
                    let payload = Payload.factory( { obj: exam, mutateSilently: true } );
                    store.commit( mTypes.addExam, payload );
                } );
                // });
            } )
            .catch( function ( error ) {
                window.console.log( 'examRequests', 'ERROR', 39, error );
                // errorHandling( error );
            } );
    },

    /**
     * Handles the call to the server to update
     * properties of an item which already has an id
     * @param store
     * @param item
     * @returns {Promise}
     */
    updateExam: ( store, exam ) => {
        window.console.log( 'apiPlugin', 'updateExam', 181, exam );
        // let examId = ! _.isUndefined(exam.id) ? exam.id : store.getters.currentExam.id;
        let out = {
            ...exam,
            examId: exam.id,
            requestVersion: REQUEST_VERSION
        };

        return window.axios
            .put( Routes.updateExam( exam ), out )
            .then( ( response ) => {
                handleResponse( store, exam, response )
                    .then( function () {
                        // window.console.log( 'requests', 'handleResponse promise resolved', 46 );
                    } )
                    .catch( function ( error ) {
                        throw error;
                    } );
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    /**
     * Gets the full exam object from the server.
     * Returns a populated exam object
     * @param examId
     * @returns {Promise<T> | *}
     */
    loadExam: ( examId ) => {
        let out = {
            requestVersion: REQUEST_VERSION
        };

        return window.axios
            .get( Routes.getExam( examId ), out )
            .then( ( response ) => {
                return response.data;
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );

    }
}