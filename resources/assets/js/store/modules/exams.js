/**
 * Created by adam on 1/12/17.
 */


import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'
import * as gTypes from '../getter-types'

import Exam from '../../models/Exam'
import Payload from '../../models/Payload'

// import * as api from '../../api/controller'

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

    /**
     * Push an exam into storage
     * Payload should have keys: obj
     *
     * @param state
     * @param rootState
     * @param payload Expecting Exam object to be in payload.obj
     */
    [mTypes.addExam]: ( state, payload ) => {
        Payload.checkIfPayload( payload );
        if ( payload.obj instanceof Exam ) {
            //push into exams storage
            state.exams[ payload.obj.id ] = payload.obj;
        }

    },

    /**
     * Pushes a mapping of index to id into indexMap
     * Payload should have keys: examIndex, examId
     *
     * @param state
     * @param rootState
     * @param payload Array with keys: examIndex, examId
     */
    [mTypes.addIndexMapping]: ( state, rootState, payload ) => {
        Payload.checkIfPayload( payload );

        state.indexMap[ payload.index ] = payload.id;
    },

    /**
     * Consume a json object and populate the exams object
     * by overwriting it.
     * @param state
     * @param rootState
     * @param payload
     */
    [mTypes.loadExams]: ( state, rootState, payload ) => {
        Payload.checkIfPayload( payload );
        //add exams
        state.exams = payload.obj;
    }

};

const actions = {

    /**
     * Adds the exam in the payload to the store. Also
     * adds the exam index to the indexMap so can look up
     * the id for older components.
     * @param state
     * @param commit
     * @param payload Keys: examId, examIndex, obj
     */
    [aTypes.addNewExam]: ( { state, commit }, payload ) => {
        let { examId, examIndex, obj, examObject } = payload;

        obj = typeof examObject != 'undefined' ? examObject : obj;
        //check and see if an exam object has already been passed in
        if ( !obj instanceof Exam ) {
            //create a new exam
            let { name, year, term } = payload;
            let examJson = { name, year, term, examIndex };
            obj = Exam.factory( examJson );
        }

        //assemble the expected payload
        // let out = { examId: examId, examIndex: examIndex, obj: obj };
        let out = Payload.factory( { id: obj.id, index: obj.index, obj: obj } );
        //Add to the exams store
        commit( mTypes.addExam, out );

        //Add to the mapping store
        commit( mTypes.addIndexMapping, out );

        //request that the server create an exam
        // api.createModel(Exam);

    },

    /**
     * Consume a json object and populate the exams store
     * by pushing exams into it.
     * @param state
     * @param rootState
     * @param payload
     */
    [aTypes.loadExams]: ( state, rootState, payload ) => {
        //check if payload has correct structure
        //todo

        //push each record from the payload into the store
        for (let i = 0; i < payload.length; i++) {
            let record = payload[ i ];
            //check if record has correct structure
            //todo

            //add to exams and add index mapping
            [ aTypes.addNewExam ]( state, rootState, record );
        }
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
    [gTypes.getExam]: ( state, getters, payload ) => {
        //finds the exam and returns it
        const lookupByExamId = ( state, examId ) => {
            return state.exams[ examId ];
        };

        //Try looking up first by exam Id
        if ( typeof (payload.examId) != 'undefined' ) {
            return lookupByExamId( state, payload.examId );
        }

        //other lookup methods
    },

    /**
     * Return list of exam objects
     * @param state
     * @param getters
     * @param payload
     * @returns {{}}
     */
    [gTypes.getAllExams]: ( state, getters, payload ) => {
        return (function ( state ) {
            let out = [];
            let keys = Object.keys( state.exams );
            for (let i = 0; i < keys.length; i++) {
                out.push( state.exams[ keys[ i ] ] );
            }
            return out;

        })( state );

    }
};

export default {
    actions,
    getters,
    mutations,
    state,
}