/**
 * Created by adam on 12/10/17.
 */
import Vue from 'vue';

import * as ngmTypes from '../newgrading/new-grading-mutation-types';
import * as ngaTypes from '../newgrading/new-grading-action-types';
import * as nggTypes from '../newgrading/new-grading-getter-types';

import Exam from '../../../models/Exam'
import Payload from '../../../models/Payload'

import { getGradePreferences } from '../../../api/requests/preferenceRequests';

const state = {
    /** Whether student names are visible during grading */
    areStudentNamesVisible: true,

    isLetterGradeButtonUsed: true,

    shouldDynamicallyCollapseCommentAreas: true,

    isSliderUsed: true,

    isScoreDisplayed: true,

};

const mutations = {
    [ ngmTypes.toggleStudentNameVisibility ]: ( state ) => {
        state.areStudentNamesVisible = !state.areStudentNamesVisible;
    },

    [ngmTypes.updateGradingPreference]: ( state, payload ) => {
        Vue.set( state, payload.updateProp, payload.updateVal );
    }

};

const actions = {
    loadGradingPreferencesFromServer: ( { dispatch, commit, getters } ) => {
        return new Promise( function ( resolve, reject ) {
            let p = getGradePreferences();
            p.then( function ( prefs ) {
                _.forEach( prefs, function ( v, k ) {
                    let pl = Payload.factory( { updateProp: k, updateVal: v, mutateSilently: true } );
                    commit( 'updateGradingPreference', pl );
                } );
                resolve();
            } );
        } );
    }
};

const getters = {
    [ nggTypes.areStudentNamesVisible ]: ( state, getters ) => {
        return state.areStudentNamesVisible;
    },

    [ nggTypes.isLetterGradeButtonUsed ]: ( state, getters ) => {
        return state.isLetterGradeButtonUsed;
    },

    [ nggTypes.isSliderUsed ]: ( state, getters ) => {
        return state.isSliderUsed;
    },

    [ nggTypes.isScoreDisplayed ]: ( state, getters ) => {
        return state.isScoreDisplayed;
    },


    [ nggTypes.shouldDynamicallyCollapseCommentAreas ]: ( state, getters ) => {
        return state.shouldDynamicallyCollapseCommentAreas;
    },


};


export default {
    actions,
    getters,
    mutations,
    state,
}