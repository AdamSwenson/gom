/**
 * Created by adam on 1/12/17.
 */


import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types'
import * as ngmTypes from '../../new-grading-mutation-types';

import Exam from '../../../models/Exam'
import Payload from '../../../models/Payload'

import {loadExam  } from '../../../api/requests/examRequests';
// import * as api from '../../api/controller'


// const isNew = ( state, exam ) => {
//     return _.findIndex( state.exams, { id: exam.id } ) === -1;
// };



export default {
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
    [ gTypes.getExam ]: ( state, getters, rootState, payload ) =>
        ( payload ) => {
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
    [ gTypes.getAllExams ]: ( state, getters, payload ) => {
        return (function ( state ) {
            let out = [];
            let keys = Object.keys( state.exams );
            for (let i = 0; i < keys.length; i++) {
                out.push( state.exams[ keys[ i ] ] );
            }
            return out;

        })( state );

    },

    [ gTypes.getExamBySerialNumber ]: ( state ) =>
        ( serialNumber ) => Object.values( state.exams ).find(
            ( exam ) => exam.serialNumber === serialNumber
        )
};
