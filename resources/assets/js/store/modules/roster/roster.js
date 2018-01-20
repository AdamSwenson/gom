
import a from "./roster.actions";
import g from "./roster.getters";
import m from "./roster.mutations";
import Display from "./roster.display";
import Loaders from "./loaders";

/**
 * This is the new version of students.
 *
 * More precisely, it is a list of students for a
 * given exam or item.
 *
 * It does not handle the display properties
 * (e.g., which are selected for display). That
 * is handled in display.js
 *
 * We may decide to keep the students store around
 * for things which require access to students outside
 * of an exam or item
 *
 * Created by adam on 7/8/17.
 */

const state = {
    ...Display.state,

    /**
     * List of student objects
     * */
    roster: [],

};

const actions = {
    ...a,
    ...Display.actions,
    ...Loaders.actions,
};

const mutations = {
    ...m,
    ...Display.mutations
};

const getters = {
    ...g,
    ...Display.getters
};


export default {
    actions,
    getters,
    mutations,
    state
}
