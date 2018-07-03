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
     * Gets all item scores for the exam without identifying
     * student information
     * @param exam
     * @returns {Promise.<T>|*}
     */
    getExamScoresForStats: ( store, exam ) => {
        let to = 'dev/stats/exam/' + exam.id;
        let out = {
            requestVersion: REQUEST_VERSION
        };

        return window.axios
            .get( to )
            .then( ( response ) => {
                // window.console.log( 'statsRequests---getExamStats', 35, response );
                store.dispatch( 'processScoreForStatsResponse', response );
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    /**
     * This gets every score for the item ever without
     * identifying student info.
     * Each score includes the exam id and kumis
     * @param student
     * @returns {Promise.<T>|*}
     */
    getItemScoresForStats: ( item ) => {

        return window.axios
            .get( 'dev/stats/item/' + item.id )
            .then( ( response ) => {
                return response.data;
                // window.console.log( 'statsRequests---getItemStats', 69, response );
                // store.dispatch( 'processScoreForStatsResponse', response );
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    getItemScoreSummaryForExam: ( exam, item ) => {
        let to = 'dev/stats/summary/exam/' + exam.id + '/item/' + item.id;
        return window.axios
            .get( to )
            .then( ( response ) => {
                // window.console.log( 'examSummary', 173, response );
                //me.isExamSummaryLoading = false;
                return response.data;
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } )
    },

    /**
     * Requests summarized scores for the item for each
     * kumi it is associated with
     * This will include things like mean, median, sd
     * along with the kumi id and name
     * @param item
     */
    getItemScoreSummariesByKumis: ( item ) => {
        let to = 'dev/stats/summary/kumi/item/' + item.id;
        return window.axios
            .get( to )
            .then( ( response ) => {
                // window.console.log( 'getItemScoreSummariesByKumis', 82, response );
                return response.data;
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );

    },


    /**
     * Requests summarized scores for the item across all exams
     * This will include things like mean, median, sd
     * @param item
     */
    getItemSummaryStats: ( item ) => {
        let to = 'dev/stats/summary/item/' + item.id;

        return window.axios
            .get( to )
            .then( ( response ) => {
                return response.data;
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    /**
     * Gets the summary statistics for all total scores
     * on the exam
     * @param exam
     * @returns {Promise<T> | *}
     */
    getTotalScoreSummaryStats : (exam )=>{
        let to = 'dev/stats/summary/exam/' + exam.id;

        return window.axios
            .get( to )
            .then( ( response ) => {
                return response.data;
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );

    }
};