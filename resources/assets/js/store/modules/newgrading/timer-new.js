/**
 * Created by adam on 10/7/16.
 */
import * as mTypes from './new-grading-mutation-types';
import * as aTypes from './new-grading-action-types';
import Payload from '../../../models/Payload'
import * as gTypes from "./new-grading-getter-types";


const state = {

    /**
     * whether or not the timer is running.
     * This allows a parent or distant relative
     * to tell the dashboard-timer to start or stop the
     * time by altering this
     */
    timerRunning: false,

};


const mutations = {

    [ mTypes.startExamTimer ]: ( state ) => {
        state.timerRunning = true;
    },

    [ mTypes.stopExamTimer ]: ( state ) => {
        state.timerRunning = false;
    },
};

let timer;

const actions = {


    /**
     * Sets the timer to active and initializes the
     * update loop
     * @param dispatch
     * @param commit
     * @param getters
     */
    [ aTypes.startExamTimer ]: ( { dispatch, commit, getters } ) => {
        var me = this;

        //if no student is active, don't start
        if ( getters[gTypes.isTimerRunning]) return;

        clearInterval( timer );

        //change state
        commit(mTypes.startExamTimer);

        // set a new timer to fire every second.
        timer = setInterval( function () {
            //increment the time
            //tell store to record it
            dispatch( aTypes.incrementGradingTime, 1 );
        }, 1000 );

    },

    [ aTypes.stopExamTimer ]: ( { dispatch, commit, getters } ) =>{
        clearInterval( timer );

        //change state
        commit(mTypes.stopExamTimer);
    },


};

const getters = {

    /**
     * Whether the timer is presently active and running
     * @param state
     * @returns {boolean}
     */
    [ gTypes.isTimerRunning ]: ( state ) => {
        return state.timerRunning;
    }

};


export default {
    state,
    getters,
    actions,
    mutations
}

