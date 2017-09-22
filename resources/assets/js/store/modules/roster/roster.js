/**
 * This is the new version of students.
 *
 * More precisely it is a list of students for a
 * given exam or item.
 *
 * We may decide to keep the students store around
 * for things which require access to students outside
 * of an exam or item
 *
 * Created by adam on 7/8/17.
 */
import Vue from 'vue'
import Student from '../../../models/Student'
import Payload from '../../../models/Payload'

import Kumi from '../../../models/Kumi'

import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'

import StudentImporter from './studentFileImporter'


module.exports = {


    state: {
        /**
         * List of student objects
         * */
        roster: [
            // Student.factory( { lastName: 'Smith', firstName: 'Jill' } ),
            // Student.factory( { lastName: 'Jillson', firstName: 'Smithy' } )
        ],

    },

    mutations: {

        /**
         * Adds or updates a student record in state.students.
         * NB, this does not add it to the associated class
         * @param state
         * @param payload
         */
        [mTypes.addStudentToRoster]: ( state, payload ) => {
            Payload.checkIfPayload( payload );
            let student = payload.obj;
            state.roster.push( student );
        },

        /**
         * Disassociates a student from the roster
         * Does not delete the student object
         * (the difference is handled by apiPlugins detecting the different
         * mutation)
         *
         * @param state
         * @param payload
         */
        removeStudentFromRoster: ( state, payload ) => {
            Payload.checkIfPayload( payload );
            let student = payload.obj;
            let idx = state.roster.indexOf( student );
            state.roster.splice( idx, 1 );
        },

        /**
         * Deletes a student from the database completely!!!
         * @param state
         * @param payload
         */
        deleteStudent: ( state, payload ) => {
            Payload.checkIfPayload( payload );
            let student = payload.obj;
            let idx = state.roster.indexOf( student );
            state.roster.splice( idx, 1 );
        },


        //This is to avoid confusion with updateStudent which
        //the old version uses
        updateStudentInRoster: ( state, payload ) => {
            // window.console.log( 'roster', 'updateStudentInRoster', 60, payload);
            Payload.checkIfPayload( payload );
            let student = payload.obj;
            let idx = state.roster.indexOf( student );

            Vue.set( state.roster[ idx ], payload.updateProp, payload.updateVal );
        },
    },

    actions: {
        ...StudentImporter,
        /**
         * One stop shop for everything which happens when a new student
         * object is created
         *
         * @param state
         * @param dispatch
         * @param commit
         * @param getters
         * @param payload
         */
        [aTypes.handleNewStudentStorageAndAssociation] : ( { state, dispatch, commit, getters }, payload ) => {
            let p = new Promise( ( resolve, reject ) => {
                commit( mTypes.addStudentToRoster, payload );
                resolve();
            } );


            let kumi = [];
            kumi = kumi.concat(getters.getDisplayedKumis);
            window.console.log( 'roster', '', 115, kumi);
            kumi = kumi.concat(getters.getSelectedKumis);
            window.console.log( 'roster', 'd', 117,kumi );
            return p.then( () => {
                return new Promise( ( resolve, reject ) => {
                    _.forEach(kumi, function(k){
                        payload.kumi = k;
                        //Create an association between the newly created
                        //student and the currently selected kumi, both
                        //locally and on server
                        commit( mTypes.associateStudentWithKumi, payload );
                    });
                    resolve();
                } );
            } );
        },

        // /**
        //  * Adds a student record to state.roster.
        //  * NB, this does not create any associations
        //  * @param state
        //  * @param payload
        //  */
        // storeNewlyCreatedStudent: ( { state, dispatch, commit, getters }, payload ) => {
        //     return new Promise( ( resolve, reject ) => {
        //         commit( mTypes.addStudentToRoster, payload );
        //         resolve()
        //     } );
        // },

        // /**
        //  * Creates association with kumi for an existing student
        //  * @param state
        //  * @param dispatch
        //  * @param commit
        //  * @param getters
        //  * @param payload
        //  * @returns {Promise}
        //  */
        // addStudentToKumi: ( { state, dispatch, commit, getters }, payload ) => {
        //     return new Promise( ( resolve, reject ) => {
        //         if ( _.isUndefined( payload.student ) && !_.isUndefined( payload.obj ) ) payload.student = payload.obj;
        //
        //         commit( mTypes.associateStudentWithKumi, payload );
        //         resolve()
        //     } );
        // },

    },

    getters: {

        getStudentsFromRoster: ( state, getters, rootState ) => {
            return state.roster;
        },


        /**
         * Returns a student object by the model serial number.
         * Can be used at any time.
         * @returns {*}
         * @param state
         * @param getters
         * @param rootState
         * @param serialNumber
         */
        getStudentFromRosterBySerialNumber: ( state, getters, rootState, serialNumber ) => ( serialNumber ) => {
            return (function ( state, serialNumber ) {
                var r = state.roster.filter( function ( i ) {
                    if ( i.serialNumber === serialNumber ) {
                        return i;
                    }
                } );
                return r[ 0 ];
            })( state, serialNumber )

        },

        //
        // /**
        //  * Returns the student object with the specified database id.
        //  * NB, may fail if called before the student has been stored in
        //  * the db.
        //  *
        //  * @returns {*}
        //  */
        // getStudentFromRosterById: ( state, getters, rootState, studentId ) => {
        //     return (function ( state, studentId ) {
        //         var r = state.roster.filter( function ( i ) {
        //             if ( i.id === studentId ) {
        //                 return i;
        //             }
        //         } );
        //         return r[ 0 ];
        //     })( state, studentId )
        // },
        //
        // /**
        //  * Returns the student object with the user specified identifier.
        //  * @todo This may not be unique. What to do?
        //  * @todo Make the characteristics of the identifier as arbitrary as possible
        //  */
        // getStudentFromRosterByIdentifier: ( state, getters, rootState, identifier ) => {
        //     return (function ( state, identifier ) {
        //         var r = state.roster.filter( function ( i ) {
        //             if ( i.identifier === identifier ) {
        //                 return i;
        //             }
        //         } );
        //         return r[ 0 ];
        //     })( state, identifier )
        // },

        getStudentCount: ( state, getters, rootState ) => {
            return state.roster.length;
        },


    }
};

