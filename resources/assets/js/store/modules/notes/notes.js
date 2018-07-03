/**
 * Created by adam on 7/31/17.
 */
import a from "./notes.actions";
import g from "./notes.getters";
import m from "./notes.mutations";

const state = {
    notes: [],
    newNote : false,
    newNoteSerialNumber: -1,

};

const mutations = {
    ...m,
};

const getters = {
    ...g,
};

const actions = {
    ...a,
};

export default {
    actions,
    getters,
    mutations,
    state
}
