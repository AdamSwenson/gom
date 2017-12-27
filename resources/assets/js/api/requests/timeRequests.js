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

/** We don't want to hit the server every second. This is how many requests to skip */
const RECORD_EVERY = 30;

module.exports = {

    /**
     * Gets all item scores for the exam with identifying
     * student information
     * @param exam
     * @returns {Promise.<T>|*}
     */
    getTotalGradingTime: ( exam ) => {
        let to = 'time/exam/' + exam.id;
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

    getAllGradingTimes: ( exam ) => {
        let to = 'dev/time/exam/' + exam.id;
        return window.axios
            .get( to )
            .then( function ( response ) {
                return response.data.gradingTimes;
            } );

    },

    getStudentGradingTime: ( exam, student ) => {
        let to = 'dev/time/exam/' + exam.id + '/student/' + student.id;
        return window.axios
            .get( to )
            .then( function ( response ) {
                return response.data;
            } );
    },

    setStudentGradingTime: ( exam, student, time ) => {
        if ( time % RECORD_EVERY === 0 ) {
            let out = { time: time };
            let to = 'dev/time/exam/' + exam.id + '/student/' + student.id;
            return window.axios
                .post( to, out )
                .then( function ( response ) {
                    return response.data;
                } );
        }

    }

};