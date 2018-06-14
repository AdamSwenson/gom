/**
 * Created by adam on 1/12/17.
 */


import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types'
import * as ngmTypes from '../../new-grading-mutation-types';

import Exam from '../../../models/Exam'
import Payload from '../../../models/Payload'


module.exports  = {

    /**
     * Push an exam into storage
     * Payload should have keys: obj
     *
     * @param state
     * @param rootState
     * @param payload Expecting Exam object to be in payload.obj
     */
    [ mTypes.addExam ]: ( state, payload ) => {
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
    [ mTypes.addIndexMapping ]: ( state, payload ) => {
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
    [ mTypes.loadExams ]: ( state, payload ) => {
        Payload.checkIfPayload( payload );
        //add exams
        state.exams = payload.obj;
    }

};

