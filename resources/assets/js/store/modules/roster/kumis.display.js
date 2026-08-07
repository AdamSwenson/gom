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
import Student from "../../../models/Student";

export default {


    state: {

        //The kumis by which we are filtering students by
        kumisToFilterStudentsBy: [],

        /** whether the kumi list is visible */
        kumiSelectVisible: false,

        /** Kumis which have been selected for reasons other
         * than filtering which students are displayed.
         * This often will include selecting a group of kumis
         * to be altered, or to have their associations altered
         */
        selectedKumis: [],

        /** Whether the modal that allows one to edit and remove kumi is shown */
        isKumiEditModalVisible: false,

    },

    mutations: {


        /**
         * Add a kumi to the selected Kumis list
         * @param state
         * @param payload
         */
        selectKumi: function ( state, payload ) {
            state.selectedKumis.push( payload.obj );
        },

        /**
         * Remove a kumi from the selected kumis list
         * @param state
         * @param payload
         */
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
            let idx = state.kumisToFilterStudentsBy.indexOf( kumi );

            if ( idx === -1 ) {
                //was not previously selected
                //so add it to the selected list
                state.kumisToFilterStudentsBy.push( kumi );
            } else {
                //was previously selected, so remove it
                state.kumisToFilterStudentsBy.splice( idx, 1 );
            }
        },

        /**
         * Toggles whether a kumi selector is visible
         * @param state
         * @param payload
         */
        toggleKumiSelectVisibility: function ( state, payload ) {
            state.kumiSelectVisible = !state.kumiSelectVisible;
        },


        /**
         * Removes all kumi filters on students
         * @param state
         * @param payload
         */
        clearKumisToFilterStudentsBy: function ( state, payload ) {
            state.kumisToFilterStudentsBy = [];
        },

        /**
         * Empties the selected kumis list
         * @param state
         * @param payload
         */
        clearSelectedKumis: function ( state, payload ) {
            state.selectedKumis = [];
        },

        /**
         * Shows or hides the edit kumi modal
         * @param state
         */
        toggleEditKumiModal: function ( state ) {
            state.isKumiEditModalVisible = !state.isKumiEditModalVisible;
        }

    },

    actions: {},

    getters: {

        getSelectedKumis: function ( state, getters ) {
            return state.selectedKumis;
        },

        getKumisToFilterStudentsBy: function ( state, getters ) {
            return state.kumisToFilterStudentsBy;
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
            return state.kumisToFilterStudentsBy.filter( ( i ) => {
                if ( i.serialNumber === kumi.serialNumber ) {
                    return i;
                }
            } );
        },

        //
        // /**
        //  * Returns true if the specified student is in the
        //  * presently selected kumi or, if all kumis are selected.
        //  * Returns false otherwise
        //  * @param state
        //  * @param getters
        //  * @param rootState
        //  * @param student
        //  * @returns {boolean}
        //  */
        // isStudentInSelectedKumis: ( state, getters, rootState, student ) => ( student ) => {
        //     let kumis = getters.getSelectedKumis;
        //     //if the kumis are null or empty, then
        //     // no student could be associated with any kumi in that list
        //     if ( _.isNull( kumis ) || _.isUndefined( kumis ) || kumis.length === 0 ) return false;
        //     return student.isInKumiOrKumiList( kumis );
        // },


    }
};