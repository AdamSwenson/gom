/**
 * Created by adam on 1/12/17.
 */


import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types'
import * as ngmTypes from '../../new-grading-mutation-types';

import Exam from '../../../models/Exam'
import Payload from '../../../models/Payload'

import { loadExam, releaseExamToStudents, revokeExamAccess } from '../../../api/requests/examRequests';


module.exports = {

    /**
     * Adds the exam in the payload to the store. Also
     * adds the exam index to the indexMap so can look up
     * the id for older components.
     * @param state
     * @param commit
     * @param payload Keys: examId, examIndex, obj
     */
    [ aTypes.addNewExam ]: ( { state, commit }, payload ) => {
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
    [ aTypes.loadExams ]: ( { state, rootState }, payload ) => {
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
    },

    /**
     * Grants students access to their feedback and grade
     * @param state
     * @param rootState
     * @param payload
     */
    [ aTypes.grantExamAccess ]: ( { state, rootState, commit }, payload ) => {
        let exam = payload.obj;
        let p = releaseExamToStudents( exam );

        p.then( ( exam ) => {
            //change the released property of the exam
            //once it is successful
            payload.updateProp = 'released';
            payload.updateVal = true;
            commit( mTypes.updateExam, payload );
        } );
    },

    /**
     * Removes all student access to their feedback and grades
     */
    [ aTypes.revokeExamAccess ]: ( { state, rootState, commit }, payload ) => {
        let exam = payload.obj;
        let p = revokeExamAccess( payload.obj );

        p.then( ( exam ) => {
            //change the released property of the exam
            //once it is successful
            payload.updateProp = 'released';
            payload.updateVal = false;
            commit( mTypes.updateExam, payload );
        } );
    },


};
