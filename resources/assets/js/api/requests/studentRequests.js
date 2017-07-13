/**
 * Created by adam on 7/6/17.
 */

import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT } from '../apiSettings';

import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Student from '../../models/Student'
import Exam from '../../models/Exam'
import Item from '../../models/Item'
import Kumi from '../../models/Kumi'

const STUDENT_BASE_ROUTE = 'dev/students';
const ROSTER_BASE_ROUTE = 'dev/roster';

/**
 * Process the result of a response where we need to
 * insert new students into store
 * @param store
 * @param response
 */
const handleLoadResponse = ( store, response ) => {
    _.forEach( response.data, function ( r ) {
        // window.console.log( 'examRequests', 'r', 29, r);
        let student = Student.factory( { r } );
        student.id = r.id;
        student.firstName = r.firstName;
        student.lastName = r.lastName;
        student.identifier = r.identifier;
        let payload = Payload.factory( { obj: student, mutateSilently: true } );
        store.commit( 'addStudentToRoster', payload );
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
const handleCreateStudentResponse = ( store, student, response ) => {
    return new Promise( ( resolve, reject ) => {
        let pl = Payload.factory( {
            obj: student,
            updateProp: 'id',
            updateVal: response.data.id,
            mutateSilently: true
        } );

        window.console.log( 'studentRequests', 'handleCreateStudentResponse', 49, pl, response, response['id'] );

        store.commit( 'updateStudentInRoster',  pl);

        //
        //
        // Student.fillableProps.forEach( function ( p ) {
        //     if ( Object.keys( response ).includes( p ) ) {
        //         store.commit( 'updateStudentInRoster', Payload.factory( {
        //             obj: student,
        //             updateProp: p,
        //             updateVal: response[ p ],
        //             mutateSilently: true
        //         } ) );
        // }
        // } );
        resolve();
    }    );

};

module.exports = {

    loadAllStudents: ( store, exam ) => {
        window.console.log( 'apiPlugin-studentRequests', 'loadAllStudents', 8 );
        let out = {
            requestVersion: REQUEST_VERSION
        };

        //Request is for every student belonging to the user
        if ( _.isUndefined( exam ) ) {
            window.axios
                .get( STUDENT_BASE_ROUTE )
                .then( ( response ) => {
                    window.console.log( 'studentRequests', '', 28, response );
                    handleLoadResponse( store, response );
                } )
                .catch( function ( error ) {
                    window.console.log( 'examRequests', 'ERROR', 39, error );
                    // errorHandling( error );
                } );
        }
        else {
            //Get students for a particular exam
            window.axios
                .get( ROSTER_BASE_ROUTE + '/exam/' + exam.id )
                .then( ( response ) => {
                    window.console.log( 'examRequests', '', 28, response );
                    handleLoadResponse( store, response );
                } )
                .catch( function ( error ) {
                    window.console.log( 'examRequests', 'ERROR', 39, error );
                    // errorHandling( error );
                } );
        }
    },

    loadStudent: ( store, student ) => {
    },

    /**
     * Update intrinsic properties of an existing student.
     * This does not affect their associations with a class or exam.
     * @param store
     * @param student
     */
    updateStudent: ( store, student ) => {
        window.axios
            .post( BASE_ROUTE )
            .then( ( response ) => {
                window.console.log( 'studentRequests', 'updateStudent', 28, response );
            } )
            .catch( function ( error ) {
                window.console.log( 'studentRequests', 'ERROR', 39, error );
                // errorHandling( error );
            } );
    },

    /**
     * Creates a student with the given properties in the database.
     * Does not associate the student with a class or exam.
     * @param store
     * @param student
     */
    createStudent: ( store, student ) => {
        // if ( student && student.isNew() ) {
            let toSend = {
                ...student,
                requestVersion: REQUEST_VERSION,
            };

            window.axios
                .post( STUDENT_BASE_ROUTE, toSend )
                .then( ( response ) => {
                    // window.console.log( 'studentRequests', 'createStudent', 28, response );
                    handleCreateStudentResponse( store, student, response );
                } )
                .catch( function ( error ) {
                    window.console.log( 'studentRequests', 'ERROR', 39, error );
                    // errorHandling( error );
                } );
        // }
    },

    /**
     * Creates an association between an existing student and a class/ exam.
     * Does not create or alter any info about the student.
     * @param store
     * @param student
     * @param exam
     * @param kumi
     */
    associateStudent: ( store, student, kumi ) => {
        let route = `${ROSTER_BASE_ROUTE}/${student.id}/assoc/${kumi.id}`;
        let out = {
            kumiId: 1
        };
        window.axios
            .post( route, $out )
            .then( ( response ) => {
                window.console.log( 'studentRequests', 'createStudent', 28, response );
            } )
            .catch( function ( error ) {
                //todo add response handling
                window.console.log( 'studentRequests', 'ERROR', 39, error );
                // errorHandling( error );
            } );
    },

    /**
     * Remove the association between the student, class, and exam
     *
     * Does not delete the student (so would still show up if
     * queried for the student alone or all student belonging to user).
     *
     * Nor does this affect student data. So if the student were to change
     * class sections (kumi's), we would first disassociate them from the exam/kumi
     * and then associate them with the new kumi. None of their scores or other
     * data will be affected.
     *
     * @param store
     * @param student
     */
    disassociateStudent: ( store, student ) => {
        let route = `${ROSTER_BASE_ROUTE}/${student.id}/diss/{exam.id}`;

        window.axios
            .post( route )
            .then( ( response ) => {
                window.console.log( 'examRequests', 'createStudent', 28, response );
            } )
            .catch( function ( error ) {
                //todo add response handling
                window.console.log( 'examRequests', 'ERROR', 39, error );
                // errorHandling( error );
            } );
    },

    /**
     * Requests that identifying information about a student
     * be permanently removed.
     * Retains student score data and other optional
     * non-identifying information about the student for use in
     * statistics etc.
     *
     * @param store
     * @param student
     */
    anonymizeStudents: ( store, exam ) => {
        let route = `${ROSTER_BASE_ROUTE}/anon/{exam.id}`;

        window.axios
            .post( route )
            .then( ( response ) => {
                window.console.log( 'examRequests', 'anonymize students', 28, response );
            } )
            .catch( function ( error ) {
                //todo add response handling
                window.console.log( 'examRequests', 'ERROR', 39, error );
                // errorHandling( error );
            } );
    },


    /**
     * Requests the permanent removal of all data about the student
     * @param store
     * @param student
     */
    destroyStudent: ( store, student ) => {
        let route = `${STUDENT_BASE_ROUTE}/${student.id}`;

        window.axios
            .delete( route )
            .then( ( response ) => {
                window.console.log( 'examRequests', 'anonymize students', 28, response );
            } )
            .catch( function ( error ) {
                //todo add response handling
                window.console.log( 'examRequests', 'ERROR', 39, error );
                // errorHandling( error );
            } );
    }
}