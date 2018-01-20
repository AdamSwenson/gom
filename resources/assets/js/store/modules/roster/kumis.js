/**
 * This handles kumi object storage and
 * the relationships between kumi and other
 * objects.
 *
 * It does not handle the display properties
 * (e.g., which are selected for display). That
 * is handled in display.js
 *
 *
 * Created by adam on 7/11/17.
 */

const KUMIS_JSON_NAME = 'loadedKumis';

import a from './kumis.actions';
import g from './kumis.getters';
import m from './kumis.mutations';
import Display from './kumis.display';


const state = {
    ...Display.state,

    kumis: [],

    //holds objects with keys examId and kumiId
    examKumiAssociations: [],

    //holds objects with keys studentSN and kumiSN
    studentKumiAssociations: [],

    /**
     * This is either null or a kumi object
     * if it is null, we are supposed to show all kumi and students
     * associated with the exam
     */
    selectedKumi: null
};



const mutations = {
    ...m,
    ...Display.mutations
};

const getters = {
    ...g,
    ...Display.getters
};

const actions = {
    ...a,
    ...Display.actions

};

export default {
    actions,
    getters,
    mutations,
    state
}
