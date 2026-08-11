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
import Kumi from '../../models/Kumi'

// const BASE_ROUTE = 'dev/kumis';

/**
 * Process the result of a response where we need to
 * insert new students into store
 * @param store
 * @param response
 */
const handleLoadKumiResponse = ( store, response ) => {
    _.forEach( response.data, function ( r ) {
        // // window.console.log( 'examRequests', 'r', 29, r);
        // let student = Student.factory( { r } );
        // student.id = r.id;
        // student.firstName = r.firstName;
        // student.lastName = r.lastName;
        // student.identifier = r.identifier;
        // let payload = Payload.factory( { obj: student, mutateSilently: true } );
        // store.commit( 'addStudentToRoster', payload );
    } );
};

/**
 * We will want to update our object with info from
 * the server upon creation. This handles that.
 * @param store
 * @param item
 * @param response
 * @returns {Promise}
 */
const handleCreateKumiResponse = ( store, kumi, data ) => {
    // window.console.log( 'kumiRequests', 'handleCreateKumiResponse', 46, store, kumi, data );
    return new Promise( ( resolve, reject ) => {
        store.commit( 'updateKumi', Payload.factory( {
            obj: kumi,
            updateProp: 'id',
            updateVal: data.id,
            mutateSilently: true
        } ) );

        resolve();

        //
        // Kumi.fillableProps.forEach( function ( p ) {
        //     if ( p !== 'index' ) {
        //         if ( Object.keys( response ).includes( p ) ) {
        //             store.commit( mTypes.updateKumi, Payload.factory( {
        //                 obj: kumi,
        //                 updateProp: p,
        //                 updateVal: response[ p ],
        //                 mutateSilently: true
        //             } ) );
        //         }
        //     }
        // } );
        // resolve( item );
    } );

};


const kumiRequests = {

    loadKumiForExam: ( exam ) => {
        // window.console.log( 'apiPlugin -- studentRequests', 'loadAllStudents', 8, exam );
        let out = {
            requestVersion: REQUEST_VERSION
        };
        return window.axios
            .get( Routes.loadExamKumi( exam ) )
            .then( ( response ) => {
                return response.data;
            } )
            .catch( function ( error ) {
                //todo add response handling
                window.console.log( 'kumiRequests', 'ERROR', 39, error );
                // errorHandling( error );
            } );

    },

    loadAllKumi: ( store ) => {
        let route = 'dev/kumi';
        window.axios
            .get( Routes.loadAllKumi() )
            .then( ( response ) => {
                // window.console.log( 'kumiRequests', 'loadAllKumi', 28, response );
            } )
            .catch( function ( error ) {
                //todo add response handling
                window.console.log( 'kumiRequests', 'ERROR', 39, error );
                // errorHandling( error );
            } );

    },
    //
    // associateKumi: ( kumi, exam ) => {
    //     // let route = 'dev/kumis/' + kumi.id + 'exam/' + exam.id + '/new';
    //
    //     let toSend = {
    //         ...kumi,
    //         ...exam,
    //         requestVersion: REQUEST_VERSION,
    //     };
    //
    //     window.axios
    //         .post( Routes.associateKumi( kumi, exam ), toSend )
    //         .then( ( response ) => {
    //             // window.console.log( 'kumiRequests', 'associateKumi', 28, response );
    //         } )
    //         .catch( function ( error ) {
    //             //todo add response handling
    //             window.console.log( 'kumiRequests--associateKumi', 'ERROR', 39, error );
    //             // errorHandling( error );
    //         } );
    //
    // },

    /**
     * Requests the server creates a new kumi for the
     * object provided. Returns response.data
     * @param kumi
     * @param exam
     * @returns {Promise<T> | *}
     */
    createKumiRequest: ( kumi, exam = null ) => {
        if ( Payload.checkIfPayload( kumi ) ) {
            kumi = kumi.obj; //in case someone sent a payload object
        }

        let toSend = {
            ...kumi,
            requestVersion: REQUEST_VERSION,
        };

        if ( exam ) toSend[ 'examId' ] = exam.id;

        return window.axios
            .post( Routes.createKumi(), toSend )
            .then( ( response ) => {
                return response.data;
                // window.console.log( 'kumiRequests', 'createKumi', 28, response );
                // handleCreateKumiResponse( store, kumi, response.data );
            } )
            .catch( function ( error ) {
                //todo add response handling
                window.console.log( 'kumiRequests--createKumi', 'ERROR', 39, error );
                // errorHandling( error );
            } );

    },

    updateKumi: ( store, kumi ) => {
        if ( Payload.checkIfPayload( kumi ) ) {
            kumi = kumi.obj; //in case someone sent a payload object
        }
        // let route = BASE_ROUTE + '/' + kumi.id;
        let toSend = {
            ...kumi,
            requestVersion: REQUEST_VERSION,
        };
        window.axios
            .put( Routes.updateKumi( kumi ), toSend )
            .then( ( response ) => {
                // window.console.log( 'kumiRequests', 'updateKumi', 28, response );
            } )
            .catch( function ( error ) {
                //todo add response handling
                window.console.log( 'kumiRequests -- updateKumi', 'ERROR', 39, error );
                // errorHandling( error );
            } );

    },

    disassociateKumiAndExam: ( kumi, exam ) => {
        let to = Routes.disassociateKumi(kumi, exam);
        // let to = 'dev/kumis/' + kumi.id + '/exam/' + exam.id;
        return window.axios
            .delete( to )
            .then( ( response ) => {
                // window.console.log( 'kumiRequests', 'destroyKumi', 28, response );
            } )
            .catch( function ( error ) {
                window.console.log( 'kumiRequests', 'ERROR', 39, error );
                // errorHandling( error );
            } );
    },
    destroyKumi: ( store, kumi ) => {
        window.axios
            .delete( Routes.destroyKumi( kumi ) )
            .then( ( response ) => {
                // window.console.log( 'kumiRequests', 'destroyKumi', 28, response );
            } )
            .catch( function ( error ) {
                //todo add response handling
                window.console.log( 'kumiRequests', 'ERROR', 39, error );
                // errorHandling( error );
            } );
    }
};

export const { loadKumiForExam, loadAllKumi, createKumiRequest, updateKumi, disassociateKumiAndExam, destroyKumi } = kumiRequests;
