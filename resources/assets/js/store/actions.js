//Root actions for the vuex instance

import * as types from './mutation-types'


/**
 * Sets the id of the exam currently being worked on
 * @param commit
 * @param examId
 */
export const setExamId = ({commit}, examId) => {
    commit('_setExamId', examId);
};

export const activeStudentIdGetDecor = ({state, commit}, payload) => {

};