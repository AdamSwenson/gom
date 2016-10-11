export const elementScores = {
    state: {
        /** Format: { studentIndex : { elementIndex : elementScore},  ... } */
        elementScores: {},
    },
    
    mutations: {
        loadElementScores( state, rootState,  studentElementScores ) {
            state.elementScores = studentElementScores;
        },

        /**
         * Stores a student's score on a particular element
         * @param studentIndex
         * @param elementIndex
         * @param score
         */
        storeElementScore( state, rootState,  studentIndex, elementIndex, score ) {
            state.elementScores[ studentIndex ][ elementIndex ] = score;
        },

        storeElementScoreForActiveStudent( state, elementIndex, score ) {
            state.storeElementScore( state.activeStudentIndex, elementIndex, score );
        }
    },
    actions: {  },
    getters: {

        /**
         * Retrieves element score for a student
         * Original: data.state.elementScores[ Roster.activeStudent ][ index ];
         * @param studentIndex
         * @param elementIndex
         * @returns {*}
         */
        getElementScore( state, getters, rootState, studentIndex, elementIndex ) {
            return state.elementScores[ studentIndex ][ elementIndex ];
        },

        getElementScoreForActiveStudent( state,  getters, rootState, elementIndex ) {
            if ( state.activeStudentIndex == null ) return '';
            return state.elementScores[ state.activeStudentIndex ][ elementIndex ];
        },


    }
}
