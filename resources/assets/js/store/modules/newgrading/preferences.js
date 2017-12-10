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
    isBlind: false,

};

const mutations = {
    [ mTypes.toggleStudentNameVisibility ]: ( state ) => {
        state.isBlind = !state.isBlind;
    },

};

const actions = {};

const getters = {
    [mTypes.areStudentNamesVisibile] : ( state, getters ) => {
        return this.isBlind;
    }
};


export default {
    actions,
    getters,
    mutations,
    state,
}