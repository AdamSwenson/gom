/**
 * This holds data which determines the
 * display state of the roster. That is,
 * it contains the selected students or other
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
        selectedStudents: [],

        //The kumis by which we are filtering
        displayedKumis: [],

        //selected for whatever reason
        selectedKumis: [],

        //whether the kumi list is visible
        kumiSelectVisible: false
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
            state.displayedKumis = [];
            },

        clearSelectedKumis: function ( state, payload ) {
            //we always keep the first kumi because that ties the
            //student to the exam
            state.selectedKumis = _.take(state.selectedKumis);
        },

        clearSelectedStudents: function ( state, payload ) {
            state.selectedStudents = [];
        },


        [mTypes.updateSelectedKumi]: ( state, payload ) => {
            //if no payload arrived, use the 0th kumi
            //this is so we don't have to look up the 0th kumi and do
            //it from another module
            // let kumi = !_.isUndefined( payload ) && !_.isUndefined( payload.obj ) ? payload.obj : state.kumis[ 0 ];
            // state.displayedKumis.push(payload);
        }

    },
//
    actions: {
//        clearSelectedKumis: function({ state, dispatch, commit, getters } ){
// //            state.displayedKumis = [];
//         },

    },

    getters: {
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
        }
    }
};
//
// export default {
//     actions,
//     getters,
//     mutations,
//     state
// }