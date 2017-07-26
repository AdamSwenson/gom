/**
 * Created by adam on 7/6/17.
 */

import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT, Routes } from '../apiSettings';

import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Student from '../../models/Student'
import Exam from '../../models/Exam'
import Item from '../../models/Item'
import Kumi from '../../models/Kumi'

const ID_WAIT_DELAY = 3000;

/**
 * Process the result of a response where we need to
 * insert new students into store
 * @param store
 * @param response
 */
const handleLoadResponse = ( store, response ) => {
    _.forEach( response.data, function ( r ) {
        // window.console.log( 'examRequests', 'r', 29, r );
        let student = Student.factory( { r } );
        student.email = r.email;
        student.firstName = r.firstName;
        student.id = r.id;
        student.identifier = ! _.isUndefined(r.identifier) ? r.identifier : r.studentIdentifier;
        student.lastName = r.lastName;

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
const handleCreateStudentResponse = ( store, student, data ) => {
    return new Promise( ( resolve, reject ) => {
        let pl = Payload.factory( {
            obj: student,
            updateProp: 'id',
            updateVal: data.id,
            mutateSilently: true
        } );

        // window.console.log( 'studentRequests', 'handleCreateStudentResponse', 49, pl, response, response['id'] );

        store.commit( 'updateStudentInRoster', pl );

        resolve();
    } );

};

module.exports = {

    /**
     * Sends request for all students associated with the exam
     * or all students belonging to the user, depending on
     * whether the exam is included.
     *
     * @param store
     * @param exam
     */
    loadAllStudents: ( store, exam ) => {
        // window.console.log( 'apiPlugin -- studentRequests', 'loadAllStudents', 8 );
        let out = {
            requestVersion: REQUEST_VERSION
        };

        //Request is for every student belonging to the user
        if ( _.isUndefined( exam ) ) {
            window.axios
                .get( Routes.loadAllStudents() )
                .then( ( response ) => {
                    // window.console.log( 'studentRequests', '', 28, response );
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
                    // window.console.log( 'examRequests', '', 28, response );
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
            .patch( Routes.updateStudent(student), student )
            .then( ( response ) => {
                // window.console.log( 'studentRequests', 'updateStudent', 28, response );
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
            .post( Routes.createStudent(), toSend )
            .then( ( response ) => {
                // window.console.log( 'studentRequests', 'createStudent', 28, response );
                handleCreateStudentResponse( store, student, response.data );
            } )
            .catch( function ( error ) {
                window.console.log( 'studentRequests', 'ERROR', 39, error );
                // errorHandling( error );
            } );
    },

    /**
     * Creates an association between an existing student and a class/ exam.
     * Does not create or alter any info about the student.
     * @param store
     * @param student
     * @param exam
     * @param kumi
     */
    associateStudent: ( store, student ) => {
        let kumi = store.getters.getSelectedKumi;
        //handles the actual request so that we can deal
        //with the need to wait for an id
        let makeRequest = ( route, out ) => {
            window.axios
                .post( route, out )
                .then( ( response ) => {
                    // window.console.log( 'studentRequests', 'associateStudent', 28, response );
                    store.commit( 'associateStudentWithKumi', Payload.factory( { student: student, kumi: kumi } ) );
                } )
                .catch( function ( error ) {
                    //todo add response handling
                    window.console.log( 'studentRequests -- associateStudent', 'ERROR', 39, error );
                    // errorHandling( error );
                } );
        };
        let out = {
            requestVersion: REQUEST_VERSION,
        };

        //Check whether both the kumi and student have their ids
        if ( kumi.id === -1 || student.id === -1 ) {

            setTimeout( function () {
//                let route = `${ROSTER_BASE_ROUTE}/${student.id}/assoc/${kumi.id}`;

                makeRequest( Routes.associateStudent(student, kumi), out );
            }, ID_WAIT_DELAY );
        } else {
         //   let route = `${ROSTER_BASE_ROUTE}/${student.id}/assoc/${kumi.id}`;
            makeRequest( Routes.associateStudent(student, kumi), out );
        }
        // window.console.log( 'studentRequests', 'associateStudent', 162, student );

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
        let kumi = store.getters.getCurrentlySelectedKumi;
        // let route = `${ROSTER_BASE_ROUTE}/${student.id}/diss/${kumi.id}`;

        window.axios
            .post( Routes.disassociateStudent(student, kumi) )
            .then( ( response ) => {
                window.console.log( 'studentRequests', 'disassociateStudent', 214, response );
            } )
            .catch( function ( error ) {
                //todo add response handling
                window.console.log( 'studentRequests', 'ERROR', 39, error );
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
        // let route = `${ROSTER_BASE_ROUTE}/anon/{exam.id}`;

        window.axios
            .post( Routes.anonymizeStudents(exam) )
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
        // let route = `${STUDENT_BASE_ROUTE}/${student.id}`;

        window.axios
            .delete( Routes.destroyStudent(student) )
            .then( ( response ) => {
                window.console.log( 'examRequests', 'anonymize students', 28, response );
            } )
            .catch( function ( error ) {
                //todo add response handling
                window.console.log( 'examRequests', 'ERROR', 39, error );
                // errorHandling( error );
            } );
    }
};