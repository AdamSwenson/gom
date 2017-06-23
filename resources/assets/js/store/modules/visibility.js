/**
 * This maintains the visibility of page elements
 * and their various parts.
 * Since the server doesn't need to know about the state
 * there is no need to work through the stored items
 *
 * Created by adam on 3/23/17.
 */

import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'
import * as gTypes from '../getter-types'
import Payload from '../../models/Payload'

const state = {
    /** List of indexes of items for which the settings panel is visible */
    itemsWithSettingsVisible: [],
    //The root item (the exam) is always visible, but it's settings aren't
    examSettingsVisible: false
};

const mutations = {

    [mTypes.showItemSettings]: ( state, payload ) => {
        console.log( 'show called', payload );
        if ( Payload.checkIfPayload( payload ) ) {
            if ( !state.itemsWithSettingsVisible.includes( payload.serialNumber ) ) {
                state.itemsWithSettingsVisible.push( payload.serialNumber );
            }
        }
    },

    [mTypes.hideItemSettings]: ( state, payload ) => {
        console.log( 'hide called', payload );
        if ( Payload.checkIfPayload( payload ) ) {
            if ( typeof payload.serialNumber != 'undefined' ) {
                //get index of where the item index is stored
                let index = state.itemsWithSettingsVisible.indexOf( payload.serialNumber );
                //this covers index > -1  (not found) and index = 0 (the exam)
                //so neither can be altered
                // if ( index > 0 ) {
                if ( index > -1 )
                    state.itemsWithSettingsVisible.splice( index, 1 );
            }
        }

    },

    /**
     * Changes whether exam settings pane is visible
     * @param state
     * @param payload
     */
    [mTypes.toggleExamSettings]: ( state, payload ) => {
        state.examSettingsVisible = !state.examSettingsVisible;
    }
};

// [mTypes.toggleItemSettings] : ( state, rootState, payload ) => {
//     if(Payload.checkIfPayload(payload)) {
//         if ( typeof payload.index != 'undefined' ) {
//
//         };

const actions = {};

const getters = {

    /**
     * Takes the index of an item as input and returns boolean
     * of whether the settings pane for that item should be showing.
     * @param state
     * @param getters
     * @param rootState
     */
    [gTypes.isItemSettingsVisible]: ( state, getters, rootState ) => ( serialNumber ) => {
        return state.itemsWithSettingsVisible.includes( serialNumber )
    },

    /**
     * Returns boolean of whether the settings pane for the exam should be showing
     * @param state
     * @param getters
     * @param rootState
     */
    [gTypes.isExamSettingsVisible]: ( state ) => {
        return state.examSettingsVisible;
    }

};


export default {
    actions,
    getters,
    mutations,
    state,
}