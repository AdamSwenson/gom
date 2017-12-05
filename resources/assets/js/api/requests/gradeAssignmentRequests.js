/**
 * Created by adam on 7/7/17.
 */
import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT, Routes } from '../apiSettings';
import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Exam from '../../models/Exam'
import Item from '../../models/Item'


import { errorHandling } from '../responseHandlers';

const route = 'dev/scores';

module.exports = {

    /**
     * Gets all the grade assignments for the exam
     *
     * @param exam
     * @returns {Promise.<T>|*}
     */
    getGradeAssignments: ( exam ) => {
        let to = 'dev/grade-assignment/exam/' + exam.id;
        let out = {
            requestVersion: REQUEST_VERSION
        };

        return window.axios
            .get( to )
            .then( ( response ) => {
                return response.data;
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );

    },

    getTotalScores: ( exam ) => {
        let to = 'dev/analytics/total-scores/exam/' + exam.id;
        return window.axios
            .get( to )
            .then( function ( response ) {
                return response.data.totalScores;
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );

    },

    /**
     * Gets all item scores for the exam without identifying
     * student information
     * @param exam
     * @returns {Promise.<T>|*}
     */
    updateGradeAssignment: ( store, exam, letterGrade ) => {
        let to = 'dev/grade-assignment/' + letterGrade.id;

        let out = {
            requestVersion: REQUEST_VERSION,
            min_score : letterGrade.minScore
        };

        return window.axios
            .post( to, out )
            .then( ( response ) => {
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

};