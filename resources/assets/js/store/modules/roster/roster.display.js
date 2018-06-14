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
        clearSelectedStudents:  ( state, payload ) =>{
            state.selectedStudents = [];
        },

        deselectStudent:  ( state, payload ) => {
            let idx = state.selectedStudents.indexOf( payload.obj );
            state.selectedStudents.splice( idx, 1 );
        },

        /**
         * Alters which field the list of students
         * is sorted by
         */
        setSortedBy: ( state, payload ) => {
            state.sortedBy = payload.updateVal;
        },

        selectStudent: ( state, payload ) =>{
            state.selectedStudents.push( payload.obj );
        },

        /**
         * If the student was in the selected list, this removes them
         * If they were not selected, this adds them
         * @param state
         * @param payload
         */
        toggleStudent:  ( state, payload ) =>{
            let student = payload.obj;
            let idx = state.selectedStudents.indexOf( student );
            if ( idx === -1 ) {
                //was not previously selected
                //so add it to the selected list
                state.selectedStudents.push( student );
            } else {
                //was previously selected, so remove it
                state.selectedStudents.splice( idx, 1 );
            }
        },


        /**
         * Toggles between sorting the student list
         * ascending and descending
         * @param state
         */
        toggleSortAscending: ( state ) => {
            state.sortAsc = !state.sortAsc;
        },

    },

    actions: {},

    getters: {

        getSortAsc: ( state ) => {
            return state.sortAsc;
        },

        getSortedBy: ( state, getters, rootState ) => {
            return state.sortedBy;
        },

        getSelectedStudents: ( state, getters ) => {
            return state.selectedStudents;
        },


    }
};