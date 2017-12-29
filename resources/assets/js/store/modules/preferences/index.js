
import gradingPrefs from './grading-preferences';
import setupPrefs from './setup-preferences';
import userPrefs from './user-preferences';

const state = {
    ...gradingPrefs.state,
    ...setupPrefs.state,
    ...userPrefs.state,
};
const actions = {
    ...gradingPrefs.actions,
    ...setupPrefs.actions,
    ...userPrefs.actions
};
const mutations = {
    ...gradingPrefs.mutations,
    ...setupPrefs.mutations,
    ...userPrefs.mutations
};
const getters = {
    ...gradingPrefs.getters,
    ...setupPrefs.getters,
    ...userPrefs.getters
};


export default {
    actions,
    getters,
    mutations,
    state,
}