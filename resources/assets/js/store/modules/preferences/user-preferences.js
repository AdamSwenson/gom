/**
 * Created by adam on 12/10/17.
 */

import * as ngmTypes from '../newgrading/new-grading-mutation-types';
import * as ngaTypes from '../newgrading/new-grading-action-types';
import * as nggTypes from '../newgrading/new-grading-getter-types';

import Exam from '../../../models/Exam'
import Payload from '../../../models/Payload'

import { getUserPreferences } from "../../../api/requests/preferenceRequests";
import Vue from "vue";

const state = {
    userNameShownToStudents: '',
    userEmailSignature: ''
};

const mutations = {

    updateUserPreference: ( state, payload ) => {
        Vue.set( state, payload.updateProp, payload.updateVal );
    }

};

const actions = {
    loadUserPreferencesFromServer: ( { dispatch, commit, getters } ) => {
        return new Promise( function ( resolve, reject ) {
            let p = getUserPreferences();
            p.then( function ( prefs ) {
                _.forEach( prefs, function ( v, k ) {
                    let pl = Payload.factory( { updateProp: k, updateVal: v, mutateSilently: true } );
                    commit( 'updateUserPreference', pl );
                } );
                resolve();
            } );
        } );
    }
};

const getters = {
    getUserPreferences: ( { state, getters, rootState } ) => {
        return state;
    }
};


export default {
    actions,
    getters,
    mutations,
    state,
}