/**
 * This is the older student storage
 * system, still used in grading etc
 *
 * For setup, use roster.js
 *
 * Created by adam on 10/7/16.
 */

/**
 * Created by adam on 10/7/16.
 */
import Student from '../../../models/Student'
import Payload from '../../../models/Payload'
import * as mTypes from '../../mutation-types'
import * as lmTypes from '../../legacy-mutation-types';
import * as laTypes from '../../legacy-action-types'


const state = {
    /**
     * Json of students
     * Format: { studentIndex : { studentId: int, firstName: str, lastName: str, studentIdentifier: str }, ....}
     * @type {{}}
     */
    students: {},
};

const mutations = {

    /**
     * Adds or updates a student record in state.students
     * @param state
     * @param rootState
     * @param payload
     */
    [lmTypes.setStudent]: ( state, rootState, payload ) => {
        Payload.checkIfPayload( payload );
        state.students[ payload.index ] = payload.obj;
    },

    /**
     * Removes a student and their index from state.students
     * @param state
     * @param rootState
     * @param payload
     */
    [lmTypes.toggleRemoveControls]: ( state, rootState, payload ) => {
        Payload.checkIfPayload( payload );
        delete state.students[ payload.index ];
    }

};

const actions = {
    // ...StudentImporter,

    /**
     * Consume a json object and populate state.students
     *
     * @param state
     * @param payload
     */
    [laTypes.loadStudents]: ( {state, commit}, payload ) => {

        for ( let i = 0; i < Object.keys( payload ).length; i++ ) {
            actions[ laTypes.addStudent ]( {state, commit}, payload[ i ] );
        }
    },

    /**
     * Push a student into the state.students object
     * @param state
     * @param commit
     * @param payload
     */
    [laTypes.addStudent]: ( {state, commit}, payload ) => {
        /*
         create a student object out of the payload.
         the factory will not require any properties to
         be set. That lets us use it in very incremental ways.
         todo the factory will sanitize values
         */
        let student = Student.factory( payload )
        if ( student instanceof Student ) {
            let pl = new Payload();
            pl.id = student.id;
            pl.index = student.index;
            pl.obj = student;
            commit( lmTypes.setStudent, pl );
        }

//todo error handling if a student wasn't returned
    }
};

const getters = {
    /**
     * Returns a student object with keys:
     *      studentId
     *      studentIdentifier
     *      firstName
     *      lastName
     * @param studentIndex
     * @returns {*}
     */
    getStudent: ( state, getters, rootState, studentIndex ) => {
        return state.students[ studentIndex ];
    },


    /**
     * Returns a json containing student objects with student indexes as keys.
     * The contained object has the keys:
     *      studentId
     *      studentIdentifier
     *      firstName
     *      lastName
     * @returns {*}
     */
    getStudents: ( state, getters, rootState ) => {
        return state.students;
    },



}


export default {
    actions,
    getters,
    mutations,
    state,
}


