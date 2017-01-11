/**
 * Created by adam on 10/7/16.
 */
import * as types from '../mutation-types'
// const Times = {

const state = {
    /**
     * Format:
     *     { studentIndex : gradingTime, ... }
     */
    examGradingTimes: {},

};

const mutations = {
    /**
     * Add a grading time to the store
     * @param examGradingTimes JSON object
     */
        [types.addGradingTime](state, payload) {
        if(typeof(payload.studentIndex) != 'undefined' && typeof(payload.timeToAdd) != 'undefined') {
            let studentIndex = payload.studentIndex;
            let timeToAdd = payload.timeToAdd;
            state.examGradingTimes[studentIndex] += timeToAdd;
        }
        //add processing from other allowed input configs
    },

    /**
     * Removes a grading time data object
     * @param examGradingTimes JSON object
     */
        [types.removeGradingTime](state, payload) {
            //state.examGradingTimes = payload;

    },

    /**
     * Sets the grading time data from the server
     * @param examGradingTimes JSON object
     */
        [types.loadGradingTimes](state, payload) {
        state.examGradingTimes = payload;
    },


    /**
     * Increases the stored time for the student currently being graded by the specified
     * amount.
     * Original: data.this.examGradingTimes[ Roster.activeStudent ];
     */
        [types.increaseActiveStudentGradingTime](state, payload) {
        state.examGradingTimes[state.activeStudentIndex] += payload.timeToAdd;
    }

};

const actions = {
    /**
     * Stores a new time for the student.
     * Overwrites any existing value.
     * Original: data.this.examGradingTimes[ Roster.activeStudent ];
     */
        [types.storeStudentGradingTime]({ commit}, payload) {
        // studentIndex, activeStudentTime
            payload = { studentIndex: 2, timeToAdd: 3.4};
            commit('addGradingTime', payload);
//        state.examGradingTimes[studentIndex] = activeStudentTime;
    },



    /**
     * Increases the stored time for a student by the specified
     * amount.
     * Original: data.this.examGradingTimes[ Roster.activeStudent ];
     */
        [types.increaseStudentGradingTime]({commit}, payload) {
        // studentIndex, timeToAdd
            payload = { 'studentIndex': 1, 'timeToAdd': 3.2};
            store.commit(types.addGradingTime, payload);
    },


};

const getters = {
    /**
     * Returns the total amount of time spent grading in seconds
     * @returns {number}
     */
    getTotalGradingTime(state, getters) {
        var totalTime = 0;
        for (var i = 0; i < Object.keys(state.examGradingTimes).length; i++) {
            totalTime += state.examGradingTimes[i];
        }
        return totalTime;
    },

    /**
     * Original: data.this.examGradingTimes[ Roster.activeStudent ]
     * @param activeStudent
     * @returns {*}
     */
    getStudentGradingTime(state, getters) {
        let activeStudent = getters.getActiveStudentIndex();
        return state.examGradingTimes[activeStudent];
    },

    /**
     * Convenience method for getting the grading time of the student presently
     * being graded
     * @returns {*}
     */
    getActiveStudentGradingTime(state, getters) {
        // if ( ! this.isActive() ) throw "ERROR: getActiveStudentGradingTime | No active student set ";
        if (state.activeStudentIndex == null) return '';

        return state.getStudentGradingTime(state.activeStudentIndex);
    }
};


export default {
    state,
    getters,
    actions,
    mutations
}

