/**
 * Created by adam on 7/31/17.
 */


import g from "./tags.getters";
import a from "./tags.actions";
import m from "./tags.mutations";
import loaders from "./tags.loaders";



const state = {
    tags: [],

    /**
     * object serial numbers are the keys
     * the values are lists of tag serial numbers
     *
     * The storage has no notion of what sort of object
     * the serial number (key) corresponds to. If that is
     * needed, it should be handled elsewhere
     */
    associations: {}
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
}
