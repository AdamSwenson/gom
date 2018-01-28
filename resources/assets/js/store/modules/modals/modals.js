/**
 * Created by adam on 1/24/18.
 */

import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'

const state = {

    /** Whether to display the error modal */
    isErrorModalVisible: false,

    /** Whether the confirmation dialog is displayed*/
    isConfirmationModalVisible: false,

    modalText: '',

    modalData: null
};

const mutations = {

    toggleErrorModal: function ( state, payload ) {

        //set the text if the modal is not visible
        if ( !state.isErrorModalVisible && !_.isUndefined( payload ) ) state.modalData = payload;

        state.isErrorModalVisible = !state.isErrorModalVisible;
    },

    toggleConfirmationModal: function ( state, payload ) {
        //set the text if the modal is not visible
        if ( !state.isConfirmationModalVisible && !_.isUndefined( payload ) ) state.modalData = payload;

        state.isConfirmationModalVisible = !state.isConfirmationModalVisible;
    },

    setModalData: function ( state, payload ) {
        state.modalData = payload;
    }

};

const actions = {};

const getters = {
    /**
     * Returns the PayloadModal object that has been stored
     * @param state
     * @returns {null|*}
     */
    getModalData: function ( state ) {
        return state.modalData;
    },

    /**
     * Used to control the error modal
     * @param state
     * @returns {boolean}
     */
    isErrorModalVisible: function ( state ) {
        return state.isErrorModalVisible;
    },

    /**
     * Used to control the confirmation modal
     * @param state
     * @returns {boolean}
     */
    isConfirmationModalVisible: function ( state ) {
        return state.isConfirmationModalVisible;
    }
};


export default {
    actions,
    getters,
    mutations,
    state,
}