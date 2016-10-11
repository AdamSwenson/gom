/**
 * Created by adam on 10/7/16.
 */

/**
 * Created by adam on 10/7/16.
 */
import Student from './Student';

export const Students = {
    state: {
        /**
         * Json of students
         * Format: { studentIndex : { studentId: int, firstName: str, lastName: str, studentIdentifier: str }, ....}
         * @type {{}}
         */
        students: {},

    },
    mutations: {

        loadStudents( state,  rootState, studentJson ) {
            for ( let i = 0; i < Object.keys( studentJson ).length; i ++ ) {
                let s = studentJson[ Object.keys( studentJson )[ i ] ];
                state.students[ s.studentIndex ] = Student.factory( s );
            }
//        this.students = studentJson;
        }


    },
    actions: {  },
    getters: {
        /**
         * Returns a student object with keys:
         *      studentId
         *      studentIdentifier
         *      firstName
         *      lastName
         * @param studentIndex
         * @returns {*}
         */
        getStudent( state,  getters, rootState, studentIndex ) {
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
        getStudents(state,  getters, rootState) {
            return state.students;
        }

    }
}


