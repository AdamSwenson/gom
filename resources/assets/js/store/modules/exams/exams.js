/**
 * Created by adam on 1/12/17.
 */


import g from "./exams.getters";
import a from "./exams.actions";
import m from "./exams.mutations";
import loaders from "./exams.loaders";


// const isNew = ( state, exam ) => {
//     return _.findIndex( state.exams, { id: exam.id } ) === -1;
// };


/**
 * The older version used an index value to do lots of stuff.
 * Given the prospect of using a websocket connection or connecting
 * to canvas or other 3rd party system, it now makes more sense
 * to use the db's id as the primary locator in the store. Thus
 * state.exams has the exam's database id as key and an Exam object
 * as value. That is:
 *      state.exams[Exam.id] = Exam
 *
 * To maintain compatibility, indexMap holds a mapping from the old
 * examIndex to the database id
 *
 * @type {{exams: {}, indexMap: {}}}
 */
const state = {
    /**
     * Object indexed by exam id holding exam objects
     */
    exams: {},

    /**
     * Mapping from older examIndex to new exam id value
     */
    indexMap: {}

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
