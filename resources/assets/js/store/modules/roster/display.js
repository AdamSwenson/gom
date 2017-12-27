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

        /** The students whose rows have been selected */
        selectedStudents: [],

        /** The direction to sort the roster */
        sortAsc: true,

        /**
         * The currently selected field by which
         * the roster is sorted
         */
        sortedBy: 'lastName',


    },

    mutations: {

        toggleStudent: function ( state, payload ) {
            let student = payload.obj;
            let idx = state.selectedStudents.indexOf( student );
            window.console.log( 'display', 'toggleStudent', 30, student, idx );
            if ( idx === -1 ) {
                //was not previously selected
                //so add it to the selected list
                state.selectedStudents.push( student );
                window.console.log( 'display', 'toggleStudent', 35, state.selectedStudents );
            } else {
                //was previously selected, so remove it
                state.selectedStudents.splice( idx, 1 );
            }
        },

        selectStudent: function ( state, payload ) {
            state.selectedStudents.push( payload.obj );
        },

        deselectStudent: function ( state, payload ) {
            let idx = state.selectedStudents.indexOf( payload.obj );
            state.selectedStudents.splice( idx, 1 );
        },

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

        clearSelectedStudents: function ( state, payload ) {
            state.selectedStudents = [];
        },


        /**
         * Alters which field the list of students
         * is sorted by
         */
        setSortedBy: ( state, payload ) => {
            state.sortedBy = payload.updateVal;
        },

        /**
         * Toggles between sorting the student list
         * ascending and descending
         * @param state
         */
        toggleSortAscending: ( state ) => {
            state.sortAsc = !state.sortAsc;
        },



        /**
         * @deprecated
         * @param state
         * @param payload
         */
        updateSelectedKumi: function ( state, payload ) {
            let kumi = payload.obj;
            let idx = state.displayedKumis.indexOf( kumi );

            if ( idx === -1 ) {
                //was not previously selected
                //so add it to the selected list
                state.displayedKumis.push( kumi );
            }
        }


    },

    actions: {},

    getters: {

        getSortAsc: ( state ) => {
            return state.sortAsc;
        },

        getSortedBy: ( state, getters, rootState ) => {
            return state.sortedBy;
        },

        getSelectedStudents: function ( state, getters, ) {
            return state.selectedStudents;
        },

        getSelectedKumis: function ( state, getters ) {
            return state.selectedKumis;
        },

        getDisplayedKumis: function ( state, getters ) {
            return state.displayedKumis;
        },

        isKumiSelectVisible: function ( state, getters ) {
            return state.kumiSelectVisible;
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