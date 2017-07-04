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
    /** List of indexes of identifiers for which the settings panel is visible */
    itemsWithSettingsVisible: [],

    /** List of serial numbers of identifiers whose children are hidden */
    itemsWithChildrenHidden: [],

    //The root item (the exam) is always visible, but it's settings aren't
    examSettingsVisible: false,

    examChildrenVisible: true
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

    toggleChildrenVisibility : (state, payload) => {
        if(state.itemsWithChildrenHidden.includes( payload.serialNumber )){
            //remove the item from the list of hidden
            let index = state.itemsWithChildrenHidden.indexOf( payload.serialNumber );
            state.itemsWithChildrenHidden.splice( index, 1 );
        }else{
            state.itemsWithChildrenHidden.push(payload.serialNumber)
        }
    },

    /**
     * Changes whether exam settings pane is visible
     * @param state
     * @param payload
     */
    [mTypes.toggleExamSettings]: ( state, payload ) => {
        state.examSettingsVisible = !state.examSettingsVisible;
    },

    toggleExamChildrenVisibility: (state) =>{
        state.examChildrenVisible = !state.examChildrenVisible;
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

    isItemChildrenVisible : ( state, getters, rootState ) => ( serialNumber ) => {
        return ! state.itemsWithChildrenHidden.includes( serialNumber )
    },


    /**
     * Returns boolean of whether the settings pane for the exam should be showing
     * @param state
     * @param getters
     * @param rootState
     */
    [gTypes.isExamSettingsVisible]: ( state ) => {
        return state.examSettingsVisible;
    },

    isExamChildrenVisible: (state) => {
        return state.examChildrenVisible;
    }


};


export default {
    actions,
    getters,
    mutations,
    state,
}