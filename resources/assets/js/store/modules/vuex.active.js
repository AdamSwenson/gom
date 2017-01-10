/**
 * Created by adam on 10/7/16.
 */

export const activeStudent = {
    state: {
        /** The db id of the student currently being graded */
        Id: null,

        /**
         * The index of the student currently being graded
         */
        Index: null,

        /** The time spent grading the current student */
        Time: null,

    },
    mutations: {
        setActiveStudent( state, rootState, studentIndex, studentId=null ) {
            state.Index = studentIndex;
            if ( studentId === null || typeof studentId == 'undefined' ) {
                let student = state.students[ studentIndex ];
                // window.console.log( 'jjj', student );
                studentId = student.studentId;
            }

            state.Id = studentId;
        },

    },
    actions: {  },
    getters: {
        getActiveStudentId(state, getters, rootState) {
            return state.Id;
        },

        getActiveStudentIndex(state, getters, rootState) {
            return state.Index;
        },

        /**
         * Returns the student object corresponding to the currently selected student.
         * @returns {Student}
         */
        getActiveStudent(state, getters, rootState) {
            return state.getStudent( state.Index );
        }

    }
}