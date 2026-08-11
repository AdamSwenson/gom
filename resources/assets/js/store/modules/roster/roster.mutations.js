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


import * as mTypes from '../../mutation-types'


const isNew = ( state, student ) => {
    return _.findIndex( state.roster, { id: student.id } ) === -1;
};

export default {

    /**
     * Adds a student record to state.roster.
     * NB, this does not add it to the associated class.
     *
     * Since students may be loaded at different times, this
     * silently fails to add duplicates
     *
     * @param state
     * @param payload
     */
    [ mTypes.addStudentToRoster ]: ( state, payload ) => {
        Payload.checkIfPayload( payload );
        let student = payload.obj;
        //make sure that not duplicating
        if(isNew(state, student)) state.roster.push( student );
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
    [mTypes.removeStudentFromRoster] : ( state, payload ) => {
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
    [mTypes.deleteStudent] : ( state, payload ) => {
        Payload.checkIfPayload( payload );
        let student = payload.obj;
        let idx = state.roster.indexOf( student );
        state.roster.splice( idx, 1 );
    },

    /**
     * This updates the properties of a currently existing
     * student object
     * It is named this to avoid confusion with updateStudent which
     * the old version uses
     * @param state
     * @param payload
     */
    [mTypes.updateStudentInRoster] : ( state, payload ) => {
        // window.console.log( 'roster', 'updateStudentInRoster', 60, payload);
        Payload.checkIfPayload( payload );
        let student = payload.obj;
        let idx = state.roster.indexOf( student );

        Vue.set( state.roster[ idx ], payload.updateProp, payload.updateVal );
    },
};