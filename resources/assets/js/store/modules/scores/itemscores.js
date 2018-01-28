/**
 * Created by adam on 7/7/17.
 */
import a from './itemscores.actions';
import g from './itemscores.getters';
import m from './itemscores.mutations';
import loaders from './itemscores.loaders';

const state = {
    //Array of Score objects
    scores: []
};

const mutations = {
    ...m
};

const getters = {
    ...g
};

const actions = {
    ...a,
    ...loaders.actions
};

export default {
    actions,
    getters,
    mutations,
    state
};
