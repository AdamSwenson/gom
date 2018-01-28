/**
 * Created by adam on 10/7/16.
 */
import * as ngmTypes from '../../new-grading-mutation-types';
import * as ngaTypes from '../../new-grading-action-types';
import Payload from '../../../models/Payload'
import * as nggTypes from "../../new-grading-getter-types";


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

    [ ngmTypes.startExamTimer ]: ( state ) => {
        state.timerRunning = true;
    },

    [ ngmTypes.stopExamTimer ]: ( state ) => {
        state.timerRunning = false;
    },
};

let timer;

const actions = {


    /**
     * Sets the timer to active and initializes the
     * update loop.
     *
     *
     * @param dispatch
     * @param commit
     * @param getters
     */
    [ ngaTypes.startExamTimer ]: ( { dispatch, commit, getters } ) => {
        var me = this;

        //if no student is active, don't start
        // if ( getters[nggTypes.isTimerRunning]) return;

        clearInterval( timer );

        //change state
        commit(ngmTypes.startExamTimer);

        // set a new timer to fire every second.
        timer = setInterval( function () {
            //increment the time
            //tell store to record it
            dispatch( ngaTypes.incrementGradingTime, 1 );
        }, 1000 );

    },

    [ ngaTypes.stopExamTimer ]: ( { dispatch, commit, getters } ) =>{
        clearInterval( timer );

        //change state
        commit(ngmTypes.stopExamTimer);
    },


};

const getters = {

    /**
     * Whether the timer is presently active and running
     * @param state
     * @returns {boolean}
     */
    [ nggTypes.isTimerRunning ]: ( state ) => {
        return state.timerRunning;
    }

};


export default {
    state,
    getters,
    actions,
    mutations
}

