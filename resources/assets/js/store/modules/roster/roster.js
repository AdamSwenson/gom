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
    /**
     * List of student objects
     * */
    roster: [],

};


import actions from './roster.actions';
import getters from './roster.getters';
import mutations from './roster.mutations';

export default {
    actions,
    getters,
    mutations,
    state
}
