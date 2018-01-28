/**
 * Created by adam on 12/10/17.
 */

import * as ngmTypes from '../../new-grading-mutation-types';
import * as ngaTypes from '../../new-grading-action-types';
import * as nggTypes from '../../new-grading-getter-types';

import Exam from '../../../models/Exam'
import Payload from '../../../models/Payload'

import { getUserPreferences } from "../../../api/requests/preferenceRequests";
import Vue from "vue";

const state = {
    userNameShownToStudents: '',
    userEmailSignature: ''
};

const mutations = {

    [ngmTypes.updateUserPreference] : ( state, payload ) => {
        Vue.set( state, payload.updateProp, payload.updateVal );
    }

};

const actions = {
    [ngaTypes.loadUserPreferencesFromServer] : ( { dispatch, commit, getters } ) => {
        return new Promise( function ( resolve, reject ) {
            let p = getUserPreferences();
            p.then( function ( prefs ) {
                window.console.log( 'user-preferences', 'p', 33, prefs);
                _.forEach( prefs, function ( v, k ) {
                    let pl = Payload.factory( { updateProp: k, updateVal: v, mutateSilently: true } );
                    commit( ngmTypes.updateUserPreference, pl );
                } );
                resolve();
            } );
        } );
    }
};

const getters = {
    getUserPreferences: ( { state, getters, rootState } ) => {
        return state;
    },

    /**
     * One getter to rule them all. Given the string name of the
     * user preference to retrieve, it, uh, retrieves it.
     * @param state
     * @param getters
     * @param rootState
     * @param preferenceName
     * @returns {function(*)}
     */
    [nggTypes.getUserPreference ] : (state, getters, rootState, preferenceName) => (preferenceName) => {
        return state[preferenceName];
    }

};


export default {
    actions,
    getters,
    mutations,
    state,
}