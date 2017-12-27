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
 * @returns {Promise}
 */
const handleLoadResponse = ( store, response ) => {
    return new Promise( function ( resolve, reject ) {

        _.forEach( response.data, function ( r ) {
            // window.console.log( 'studentRequests', 'r', 29, r );
            let student = Student.factory( { r } );
            student.email = r.email;
            student.firstName = r.firstName;
            student.id = r.id;
            student.identifier = !_.isUndefined( r.identifier ) ? r.identifier : r.studentIdentifier;
            student.lastName = r.lastName;

            let payload = Payload.factory( { obj: student, mutateSilently: true } );
            store.commit( mTypes.addStudentToRoster, payload );

            if ( r.kumiId ) {
                //if the server sent us the id of the associated kumi
                //we are going to look up the client side representation
                //and then store it in the student object.
                //NB, there might not be a kumi id for any number of reasons,
                //including that an existing student is being newly associated with
                //a kumi.
                //Remember also that kumis are just groups now
                let kumi = store.getters.getKumiById( r.kumiId );
                if ( _.isUndefined( kumi ) ) {
                    //if a kumi object doesn't exist yet with this id
                    //figure out what the fuck to do.....
                    //the best thing will probably involve
                    //having the kumi loader update the kumi id's of
                    //existing students when it loads. Thus if each
                    //of them (kumi and student loaders) check and update ids
                    // when they are done, we should be okay
                    //todo add promises to help with this
                }

                //Otherwise we are good, so call the mutation
                // this will both add the kumi to the student
                //and store the relationship centrally
                payload.student = student;
                payload.kumi = kumi;
                store.commit( mTypes.associateStudentWithKumi, payload )
            }
        } );
        resolve();
    } );
};

// /**
//  * We will want to update our object with info from
//  * the server upon creation. This handles that.
//  * @param store
//  * @param item
//  * @param response
//  * @returns {Promise}
//  */
// const handleCreateStudentResponse = ( store, student, data ) => {
//     return new Promise( function ( resolve, reject ) {
//         let pl = Payload.factory( {
//             obj: student,
//             //we are just adding the id
//             updateProp: 'id',
//             updateVal: data.id,
//             mutateSilently: true
//         } );
//
//         // window.console.log( 'studentRequests', 'handleCreateStudentResponse', 49, pl, response, response['id'] );
//
//         store.commit( 'updateStudentInRoster', pl );
//
//         resolve( student );
//     } );
//
// };

/**
 * Checks whether both student and kumi have ids
 * and resolves when they do
 * Used when the promises in loading student and kumi
 * can't be chained.
 * @param student
 * @param kumi
 * @param tries
 * @returns {Promise}
 */
const readinessTester = ( student, kumi, tries = 10 ) => {
    return new Promise( function ( resolve, reject ) {
        var check = function ( kumi, student ) {
            // while( kumi.id === -1 || student.id === -1 ) {
            //     setTimeout( function () {
            //         window.console.log( 'studentRequests', 'waiting inside timeout', 115, );
            //     }, ID_WAIT_DELAY );
            //     window.console.log( 'studentRequests', 'waiting outside timeout', 115, );
            // }
            return resolve();
        };

        for (let i = 0; i < tries; i++) {
            //check immediately
            if ( check( student, kumi ) ) i = tries;

            // //set timeout and check again
            // setTimeout( function () {
            //     if ( check( student, kumi ) ) i = tries;
            // }, ID_WAIT_DELAY );
        }
        reject( Error( "Failed to load student or kumi id" ) );
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
            return window.axios
                .get( Routes.loadAllStudents() )
                .then( ( response ) => {
                    // window.console.log( 'studentRequests', '', 28, response );
                    return handleLoadResponse( store, response );
                } )
                .catch( function ( error ) {
                    window.console.log( 'examRequests', 'ERROR', 39, error );
                    // errorHandling( error );
                } );
        }

        else {
            //Get students for a particular exam
            return window.axios
                .get( Routes.loadStudentsForExam( exam ) )
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
     * @returns {Promise}
     */
    updateStudent: ( store, student ) => {
        return window.axios
            .patch( Routes.updateStudent( student ), student )
            .then( ( response ) => {
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
     * @returns {Promise}
     */
    createStudentRequest: ( student ) => {
        let toSend = {
            ...student,
            requestVersion: REQUEST_VERSION,
        };


        return window.axios
            .post( Routes.createStudent(student), toSend )
            .then( ( response ) => {
                // window.console.log( 'studentRequests', 'createStudent', 28, response );
                return response.data;
                //handleCreateStudentResponse( store, student, response.data );
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
     * @returns {Promise}
     */
    associateStudentWithKumiRequest: (  student, kumi ) => {

        let route = Routes.associateStudent( student, kumi ) ;
        window.console.log( 'studentRequests', 'associateStudentWithKumiRequest', 240, student, kumi);
        let out = { requestVersion: REQUEST_VERSION, };
        return window.axios
            .post( route, out )
            .then( ( response ) => {
                window.console.log( 'studentRequests', 'associate Student', 242, response );
            } )
            .catch( function ( error ) {
                //todo add response handling
                window.console.log( 'studentRequests -- associateStudent', 'ERROR', 39, error );
                // errorHandling( error );
            } );
    },


    //dev This is the part I was working on for GOM-266
    // return readinessTester(student, kumi)
    //     .then( function(student, kumi){
    //         window.console.log( 'studentRequests', 'ready', 256,student, kumi );
    //     return makeRequest( Routes.associateStudent( student, kumi ) );
    // });


    // //Check whether both the kumi and student have their ids
    //     if ( kumi.id === -1 || student.id === -1 ) {
    //         //if either of them are not yet set, wait for a bit
    //         //todo Rewrite this to use promises
    //         setTimeout( function () {
    //             return makeRequest( Routes.associateStudent( student, kumi ) );
    //         }, ID_WAIT_DELAY );
    //     } else {
    //         //The ids are good to go, so we can just send it
    //         return makeRequest( Routes.associateStudent( student, kumi ) );
    //     }
    // }

    // });


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
    disassociateStudent: ( student, kumi ) => {

        return window.axios
            .post( Routes.disassociateStudent( student, kumi ) )
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
        return window.axios
            .post( Routes.anonymizeStudents( exam ) )
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

        return window.axios
            .delete( Routes.destroyStudent( student ) )
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