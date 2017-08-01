/**
 * Created by adam on 7/28/17.
 */

import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'

const STATUS_SUCCESS = 200;
const STATUS_ERROR = 500;

const state = {
    /** Whether the last request succeeded or failed
     * Possible vals:
     *       200  Success
     *       500  Failure
     */
    lastRequestStatus: STATUS_SUCCESS,

    numberActiveRequests: 0
};

const mutations = {
    /**
     * Increase the number of ongoing requests
     * by one
     * @param state
     */
    startRequest: ( state ) => {
        state.numberActiveRequests += 1;
    },

    /**
     * Removes the request from the ongoing requests
     * and sets the last request status to success
     */
    stopRequestSuccess: ( state ) => {
        state.numberActiveRequests -= 1;
        state.lastRequestStatus = STATUS_SUCCESS;
    },

    /**
     * Removes the request from the list of ongoing
     * requests and sets the last request status to error (500)
     */
    stopRequestError: () => {
        state.numberActiveRequests -= 1;
        state.lastRequestStatus = STATUS_ERROR;
    }
};

const actions = {};

const getters = {
    /**
     * Returns true if at least one ajax request has been sent to the
     * server and no response (of any status) has been received
     */
    isRequestInProgress: (state) => {
        return state.numberActiveRequests > 0;
    },

    /**
     * Returns true if the most recent ajax response
     * was an error code
     */
    isResponseError: () => {
        return state.lastRequestStatus === STATUS_ERROR;
    },



};


export default {
    actions,
    getters,
    mutations,
    state,
}