/**
 * This holds data which determines the
 * display state of the roster.
 *
 * That is, it contains the selected students or other
 * properties which alter the display of the
 * rows in the student table
 *
 * Created by adam on 9/21/17.
 *
 *
 */
import Vue from 'vue'

import Payload from '../../../models/Payload';
import * as mTypes from '../../mutation-types';

module.exports = {


    state: {

        //The kumis by which we are filtering
        displayedKumis: [],

        /** whether the kumi list is visible */
        kumiSelectVisible: false,

        /** Kumis which have been selected for whatever reason */
        selectedKumis: [],

        /** Whether the modal that allows one to edit and remove kumi is shown */
        isKumiEditModalVisible : false,

    },

    mutations: {


        selectKumi: function ( state, payload ) {
            state.selectedKumis.push( payload.obj );
        },

        deselectKumi: function ( state, payload ) {
            let idx = state.selectedKumis.indexOf( payload.obj );
            state.selectedKumis.splice( idx, 1 );
        },

        /**
         * Toggle whether the kumi is displayed
         * @param state
         * @param payload
         */
        toggleKumi: function ( state, payload ) {
            let kumi = payload.obj;
            let idx = state.displayedKumis.indexOf( kumi );

            if ( idx === -1 ) {
                //was not previously selected
                //so add it to the selected list
                state.displayedKumis.push( kumi );
            } else {
                //was previously selected, so remove it
                state.displayedKumis.splice( idx, 1 );
            }
        },

        toggleKumiSelectVisibility: function ( state, payload ) {
            state.kumiSelectVisible = !state.kumiSelectVisible;
        },

        clearDisplayedKumis: function ( state, payload ) {
            state.displayedKumis = _.take( state.displayedKumis );
        },

        clearSelectedKumis: function ( state, payload ) {
            //we always keep the first kumi because that ties the
            //student to the exam
            state.selectedKumis = _.take( state.selectedKumis );
        },

        toggleEditKumiModal : function ( state ) {
            state.isKumiEditModalVisible = ! state.isKumiEditModalVisible;
        }

    },

    actions: {},

    getters: {

        getSelectedKumis: function ( state, getters ) {
            return state.selectedKumis;
        },

        getDisplayedKumis: function ( state, getters ) {
            return state.displayedKumis;
        },

        isKumiSelectVisible: function ( state, getters ) {
            return state.kumiSelectVisible;
        },

        isKumiEditModalVisible: function ( state ) {
          return state.isKumiEditModalVisible;
        },

        /**
         * Given a kumi object, this returns true if the kumi is
         * among those selected. It returns false otherwise
         * @param state
         * @param getters
         * @param rootState
         * @param kumi
         * @returns {function(*)}
         */
        isKumiDisplayed: ( state, getters, rootState, kumi ) => ( kumi ) => {
            return state.displayedKumis.filter( ( i ) => {
                if ( i.serialNumber === kumi.serialNumber ) {
                    return i;
                }
            } );
        }
    }
};