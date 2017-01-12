/**
 * Created by adam on 10/7/16.
 */

/**
 * Created by adam on 10/7/16.
 */
import Student from './../models/Student';
import * as mTypes from '../mutation-types'
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
        [mTypes.populateStudents](state, rootState, payload)
    {
            state.students = payload;
    },

    /**
     * Updates a student record in state.students
     * @param state
     * @param rootState
     * @param payload
     */
        [mTypes.setStudent](state, rootState, payload)
    {
        let {studentIndex, studentObject} = payload;
        state.students[studentIndex] = studentObject;
    }


};

const actions = {

    /**
     * Consume a json object and populate state.students by overwriting
     * TODO fix so doesn't just overwrite
     * @param state
     * @param payload
     */
        [aTypes.loadStudents]({state, commit}, payload)
    {
        for (let i = 0; i < Object.keys(payload).length; i++) {
            let s = payload[Object.keys(payload)[i]];
            this[aTypes.addStudent]({state, commit}, {index: s.studentIndex, content: s });
            // state.students[s.studentIndex] = Student.factory(s);
        }
    },

    /**
     * Push a student into the state.students object
     * @param state
     * @param commit
     * @param payload
     */
    [aTypes.addStudent]({state, commit}, payload)
    {
        let {index, content} = payload;
        let out = {
            studentIndex: index,
            studentObject: Student.factory(content)
        };
        commit(mTypes.setStudent, out);
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


