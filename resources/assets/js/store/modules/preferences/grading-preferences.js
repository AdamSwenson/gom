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

    areGradedStudentRowsVisible: true,

    isLetterGradeButtonUsed: true,

    shouldDynamicallyCollapseCommentAreas: true,

    shouldTimerAutomaticallyStart: true,

    isSliderUsed: true,

    isScoreDisplayed: true,

    showTimer: true,

};

const mutations = {
    /**
     * Not used because no api listener set
     * @deprecated
     * @param state
     */
    [ ngmTypes.toggleGradedStudentRowVisibility ]: ( state ) => {
        state.areGradedStudentRowsVisible = !state.areGradedStudentRowsVisible;
    },

    /**
     * Not used because no api listener set
     * @deprecated
     * @param state
     */
    [ ngmTypes.toggleStudentNameVisibility ]: ( state ) => {
        state.areStudentNamesVisible = !state.areStudentNamesVisible;
    },

    [ ngmTypes.updateGradingPreference ]: ( state, payload ) => {
        Vue.set( state, payload.updateProp, payload.updateVal );
    }

};

const actions = {
    [ ngaTypes.loadGradePreferencesFromServer ]: ( { dispatch, commit, getters } ) => {
        return new Promise( function ( resolve, reject ) {
            let p = getGradePreferences();
            p.then( function ( prefs ) {
                _.forEach( prefs, function ( v, k ) {
                    let pl = Payload.factory( { updateProp: k, updateVal: v, mutateSilently: true } );
                    commit( ngmTypes.updateGradingPreference , pl );
                } );
                resolve();
            } );
        } );
    }
};

const getters = {
    [ nggTypes.areGradedStudentRowsVisible ]: ( state, getters ) => {
        return state.areGradedStudentRowsVisible;
    },

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

    [nggTypes.shouldTimerAutomaticallyStart] : ( state, getters ) => {
        return state.shouldTimerAutomaticallyStart;
    },

    /**
     * One getter to rule them all. Given the string name of the
     * grading preference to retrieve, it, uh, retrieves it.
     * @param state
     * @param getters
     * @param rootState
     * @param preferenceName
     * @returns {function(*)}
     */
    [ nggTypes.getGradingPreference ]: ( state, getters, rootState, preferenceName ) => ( preferenceName ) => {
        return state[ preferenceName ];
    }

};


export default {
    actions,
    getters,
    mutations,
    state,
}