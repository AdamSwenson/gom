/**
 * Created by adam on 12/10/17.
 */

import * as ngmTypes from '../newgrading/new-grading-mutation-types';
import * as ngaTypes from '../newgrading/new-grading-action-types';
import * as nggTypes from '../newgrading/new-grading-getter-types';

import Exam from '../../../models/Exam'
import Payload from '../../../models/Payload'
import { getSetupPreferences } from "../../../api/requests/preferenceRequests";
import Vue from "vue";

const state = {

};

const mutations = {

    updateSetupPreference: ( state, payload ) => {
        Vue.set( state, payload.updateProp, payload.updateVal );
    }

};

const actions = {
    loadSetupPreferencesFromServer: ( { dispatch, commit, getters } ) => {
        return new Promise( function ( resolve, reject ) {
            let p = getSetupPreferences();
            p.then( function ( prefs ) {
                _.forEach( prefs, function ( v, k ) {
                    let pl = Payload.factory( { updateProp: k, updateVal: v, mutateSilently: true } );
                    commit( 'updateSetupPreference', pl );
                } );
                resolve();
            } );
        } );
    }
};

const getters = {
    [nggTypes.getSetupPreferences]: ( { state, getters, rootState } ) => {
        return state;
    }
};


export default {
    actions,
    getters,
    mutations,
    state,
}