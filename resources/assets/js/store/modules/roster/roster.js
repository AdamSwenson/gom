/**
 * This is the new version of students.
 * More precisely it is a list of students for a
 * given exam or item.
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

const k = Kumi.factory({'name' : 'k1'});

module.exports = {


    state: {
        /**
         * List of student objects
         * */
        roster: [
            Student.factory( { lastName: 'Smith', firstName: 'Jill' } ),
            Student.factory( { lastName: 'Jillson', firstName: 'Smithy' } )
        ],
    },

    mutations: {

        /**
         * Adds or updates a student record in state.students
         * @param state
         * @param rootState
         * @param payload
         */
        addStudentToRoster: ( state, payload ) => {
            Payload.checkIfPayload( payload );
            let student = payload.obj;
            state.roster.push( student );
        },

        removeStudentFromRoster: ( state, payload ) => {
            Payload.checkIfPayload( payload );
            let student = payload.obj;
            state.roster.splice( idx, 1 );
        },

        //This is to avoid confusion with updateStudent which
        //the old version uses
        updateStudentInRoster: (state, payload)=>{
            window.console.log( 'roster', 'updateStudentInRoster', 60, payload);
            Payload.checkIfPayload( payload );
            let student = payload.obj;
            let idx = state.roster.indexOf( student );

            Vue.set( state.roster[idx], payload.updateProp, payload.updateVal );

        }

    },

    actions: {
        ...StudentImporter
    },

    getters: {

        getStudentsFromRoster: ( state, getters, rootState ) => {
            return state.roster;
        },


        /**
         * Returns a student object by the model serial number.
         * Can be used at any time.
         * @param studentIndex
         * @returns {*}
         */
        getStudentFromRosterBySerialNumber: ( state, getters, rootState, serialNumber ) => (serialNumber) => {
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
        }
    }
}

