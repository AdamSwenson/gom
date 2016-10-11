/**
 * Created by adam on 10/7/16.
 */

const Times = {
    state: {

        /**
         * Format:
         *     { studentIndex : gradingTime, ... }
         */
        examGradingTimes: {},
    },
    mutations: {
        /**
         * Stores a new time for the student.
         * Overwrites any existing value.
         * Original: data.this.examGradingTimes[ Roster.activeStudent ];
         */
        storeStudentGradingTime( state,  rootState, studentIndex, activeStudentTime ) {
            state.examGradingTimes[ studentIndex ] = activeStudentTime;
        },

        /**
         * Sets the grading time data from the server
         * @param examGradingTimes JSON object
         */
        loadGradingTimes( state, rootState,  examGradingTimesJSON ) {
            state.examGradingTimes = examGradingTimesJSON;
        },

        /**
         * Increases the stored time for a student by the specified
         * amount.
         * Original: data.this.examGradingTimes[ Roster.activeStudent ];
         */
        increaseStudentGradingTime( state,  rootState, studentIndex, timeToAdd ) {
            state.examGradingTimes[ studentIndex ] += timeToAdd;
        },

        /**
         * Increases the stored time for the student currently being graded by the specified
         * amount.
         * Original: data.this.examGradingTimes[ Roster.activeStudent ];
         */
        increaseActiveStudentGradingTime( state, rootState,  timeToAdd ) {
            state.examGradingTimes[ state.activeStudentIndex ] += timeToAdd;
        }

    },
    actions: {  },
    getters: {
        /**
         * Returns the total amount of time spent grading in seconds
         * @returns {number}
         */
        getTotalGradingTime( state, getters, rootState ) {
            var totalTime = 0;
            for ( var i = 0; i < Object.keys( state.examGradingTimes ).length; i ++ ) {
                totalTime += state.examGradingTimes[ i ];
            }
            return totalTime;
        },

        /**
         * Original: data.this.examGradingTimes[ Roster.activeStudent ]
         * @param activeStudent
         * @returns {*}
         */
        getStudentGradingTime( state,  getters, rootState, activeStudent ) {
            return state.examGradingTimes[ activeStudent ];
        },

        /**
         * Convenience method for getting the grading time of the student presently
         * being graded
         * @returns {*}
         */
        getActiveStudentGradingTime( state, getters, rootState ) {
            // if ( ! this.isActive() ) throw "ERROR: getActiveStudentGradingTime | No active student set ";
            if ( state.activeStudentIndex == null ) return '';

            return state.getStudentGradingTime( state.activeStudentIndex );
        }
    }
}
