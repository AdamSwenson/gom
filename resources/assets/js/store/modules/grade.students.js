/**
 * Created by adam on 10/7/16.
 */

/**
 * Created by adam on 10/7/16.
 */
import Student from './../models/Student';
import * as types from '../mutation-types'
import * as aTypes from '../action-types'

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
     * Populate the state.students object with a json of students
     * @param state
     * @param payload
     */
    [types.loadStudents](state, payload) {
        for (let i = 0; i < Object.keys(payload).length; i++) {
            let s = payload[Object.keys(payload)[i]];
            state.students[s.studentIndex] = Student.factory(s);
        }
    },



};

const actions = {
    [aTypes.addStudent]({ commit }, studentJson){
        commit(types.loadStudents, studentJson);
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
    getStudent(state, getters, studentIndex) {
        return state.students[studentIndex];
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
    getStudents(state, getters) {
        return state.students;
    }
}


export default {
    actions,
    getters,
    mutations,
    state,
}


