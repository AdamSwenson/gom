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
import * as gTypes from '../../getter-types';


module.exports = {

    [ gTypes.getStudentsFromRoster ]: ( state, getters, rootState ) => {
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

    /**
     * Returns a student object by the model's database id
     * Can be used after the model has been synced with or
     * loaded from the db.
     * @returns {*}
     * @param state
     * @param getters
     * @param rootState
     * @param serialNumber
     */
    getStudentFromRosterById: ( state, getters, rootState, id ) => ( id ) => {
        return (function ( state, id ) {
            var r = state.roster.filter( function ( i ) {
                if ( i.id === id ) {
                    return i;
                }
            } );
            return r[ 0 ];
        })( state, id )

    },
    //
    // getSortAsc: ( state ) => {
    //     return state.sortAsc;
    // },
    //
    // getSortedBy: ( state, getters, rootState ) => {
    //     return state.sortedBy;
    // },

    getSortedStudents: ( state, getters, rootState ) => {

        return (function ( state, getters ) {
            //sort the students by the given property
            let sorted = _.sortBy( getters[ gTypes.getStudentsFromRoster ], [ function ( o ) {
                //this getter is defined in display.js
                return o[ getters.getSortedBy ];
            } ] );

            // window.console.log( 'roster', 'sorted', 202, sorted, getters.getSortAsc);
            //they will be ascending when they initially come out
            if ( getters.getSortAsc ) return sorted;

            //if they need to be descending, reverse the list and return it
            return _.reverse( sorted );
        })( state, getters )

    },


    /**
     * Returns the number of students state.roster
     *
     * @param state
     * @param getters
     * @param rootState
     * @returns {Number}
     */
    [ gTypes.getStudentCount ]: ( state, getters, rootState ) => {
        return getters[gTypes.getStudentsFromRoster].length;
    },


};