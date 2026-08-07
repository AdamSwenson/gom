/**
 * Requests for data related to progress in
 * grading an exam.
 */


import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT, Routes } from '../apiSettings';
import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Exam from '../../models/Exam'
import Item from '../../models/Item'


import { errorHandling } from '../responseHandlers';

const route = 'dev/numgraded/exam/';

export default {

    /**
     * Returns the number of students whose work has been
     * graded Gets all item scores for the exam without identifying
     * student information
     * @param exam
     * @returns {Promise.<T>|*}
     */
    getGradingProgressForExam: (exam ) => {
        let to = route + exam.id;
        let out = {
            requestVersion: REQUEST_VERSION
        };

        return window.axios
            .get( to )
            .then( ( response ) => {
                // window.console.log( 'statsRequests---getExamStats', 35, response );
                return response.data;
                 } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

};