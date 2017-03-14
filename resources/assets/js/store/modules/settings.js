/**
 * This handles various global settings like whether
 * the delete buttons are visible
 *
 * Created by adam on 3/10/17.
 */


import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'
import Payload from '../../models/Payload'

const state = {
    deleteButtonsVisible: false,
    reorderModeOn: false,
    sampleFeedbackVisible: false
};

const mutations = {
    [mTypes.toggleDeleteButtonVisibility]: ( state, payload ) => {
        state.deleteButtonsVisible = !state.deleteButtonsVisible;
    },

    [mTypes.toggleReorderMode]: ( state, payload ) => {
        state.reorderModeOn = !state.reorderModeOn;
    },

    [mTypes.toggleSampleFeedback]: ( state, payload ) => {
        state.sampleFeedbackVisible = !state.sampleFeedbackVisible;
    }

};

const actions = {};

const getters = {
    isDeleteVisible: ( state, getters) => {
        return state.deleteButtonsVisible
    },

    isReorderModeOn: ( state, getters) => {
        return state.reorderModeOn
    },

    isSampleFeedbackVisible: (state, getters)=>{
        return state.sampleFeedbackVisible;
    }
}

export default {
    actions,
    getters,
    mutations,
    state,
}
