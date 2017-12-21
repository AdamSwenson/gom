/**
 * Created by adam on 12/10/17.
 */

import * as mTypes from './new-grading-mutation-types';
import * as aTypes from './new-grading-action-types';
import * as gTypes from './new-grading-getter-types';

import Exam from '../../../models/Exam'
import Payload from '../../../models/Payload'

const state = {
    /** Whether student names are visible during grading */
    areStudentNamesVisible: true,

    isLetterGradeButtonUsed : true,

    shouldDynamicallyCollapseCommentAreas : true,

    isSliderUsed : true,

    isScoreDisplayed : true,

};

const mutations = {
    [ mTypes.toggleStudentNameVisibility ]: ( state ) => {
        state.areStudentNamesVisible = !state.areStudentNamesVisible;
    },

};

const actions = {};

const getters = {
    [gTypes.areStudentNamesVisible] : ( state, getters ) => {
        return state.areStudentNamesVisible;
    }
};


export default {
    actions,
    getters,
    mutations,
    state,
}