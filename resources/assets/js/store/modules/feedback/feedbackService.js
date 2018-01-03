/**
 * Created by adam on 11/30/17.
 */

/**
 * This holds information about how many students or
 * completed exams need to be graded and how many have been
 * graded
 */

import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types';
import * as nggTypes from "../newgrading/new-grading-getter-types";


const actions = {};

const getters = {

    getFeedbackForStudent : (state, getters, rootState, student) => (student) => {
let scores = [];
        let items = '';
        nggTypes.getItemScoreObject


    }


};


export default {
    actions,
    getters,
    mutations,
    state,
}