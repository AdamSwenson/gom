/**
 * Created by adam on 1/12/17.
 */


import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'
import Exam from '../models/Exam'

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
 exams : {},

    /**
     * Mapping from older examIndex to new exam id value
     */
 indexMap: {}
};

const mutations = {

    /**
     * Push an exam into storage
     *
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.addExam](state, rootState, payload)
    {

        if(payload.obj instanceof Exam){
            //push into exams storage
            state.exams[payload.obj.id] = payload.obj;
        }

    },

    /**
     * Pushes a mapping of index to id into indexMap
     * @param state
     * @param rootState
     * @param payload Should have keys: examIndex, examId
     */
    [mTypes.addIndexMapping](state, rootState, payload)
    {
        let { examIndex, examId } = payload;
        state.indexMap[examIndex] = examId;
    },

    /**
     * Consume a json object and populate the exams object
     * by overwriting it.
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.populateExams](state,rootState, payload)
    {

    }

};

const actions = {

    /**
     * Adds the exam in the payload to the store. Also
     * adds the exam index to the indexMap so can look up
     * the id for older components.
     * @param state
     * @param commit
     * @param payload
     */
    [aTypes.addNewExam]({state, commit}, payload)
    {
        let { examId, examIndex, obj } = payload;

        //check and see if an exam object has already been passed in
        if(! obj instanceof Exam){
            //create a new exam
            let { name, year, term } = payload;
            obj = Exam.factory({ name, year, term }, examIndex );
        }
        //assemble the expected payload
        let out = { examId: examId, examIndex: examIndex, obj: obj };

        //Add to the exams store
        commit(mTypes.addExam, out);

        //Add to the mapping store
        commit(mTypes.addIndexMapping, {examId: examId, examIndex: examIndex});
    }
};

const getters = {
    /**
     * Returns the desired exam object
     * Payload can have any of the following identifiers,
     * used in descending order:
     *      examId,
     *      examIndex
     *      todo Add others
     * @param state
     * @param getters
     * @param payload Object containing exam identifier
     */
 getExam: (state, getters, payload) =>
 {
     //finds the exam and returns it
     const lookupByExamId = (state, examId) => {

     };
     //Try looking up first by exam Id
     if(typeof (payload.examId) != 'undefined'){
            return
     }

     //other lookup methods


 },

    getAllExams: (state, getters, payload)=>{
     return state.exams;
    }
};

export default {
    actions,
    getters,
    mutations,
    state,
}