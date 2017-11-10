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
        // let to = route + '/exam/' + exam.id;
        let out = {
            requestVersion: REQUEST_VERSION
        };

        return window.axios
            .get( 'dev/stats/exam/' + exam.id )
            .then( ( response ) => {
                // window.console.log( 'statsRequests---getExamStats', 35, response );
                store.dispatch( 'processAxiosResponse', response );

            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    getExamStatsSummary: ( exam ) => {
    },

    /**
     * Requests summarized scores for the item
     * This will include things like mean, median, sd
     * @param item
     */
    getItemSummaryStats: ( item ) => {
        // 'dev/stats/summary/exam/{exam}'

        return window.axios
            .get( 'dev/stats/summary/item/' + item.id )
            .then( ( response ) => {
                // window.console.log( 'statsRequests---getItemStats', 69, response );
                store.dispatch( 'processAxiosResponse', response );
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    // /**
    //  * Requests summarized scores for the item
    //  * This will include things like mean, median, sd
    //  * @param item
    //  */
    // getItemSummaryForExam: ( item , exam) => {
    //     // 'dev/stats/summary/exam/{exam}'
    //
    //     return window.axios
    //         .get( 'dev/stats/summary/exam/' + exam.id + 'item/' + item.id )
    //         .then( ( response ) => {
    //             window.console.log( 'statsRequests---getItemStats', 69, response );
    //             store.dispatch( 'processAxiosResponse', response );
    //         } )
    //         .catch( function ( error ) {
    //             errorHandling( error );
    //         } );
    // },
    //
    // /**
    //  * Requests summarized scores for the item on the
    //  * given kumi
    //  * This will include things like mean, median, sd
    //  * @param item
    //  */
    // getItemSummaryForKumi: ( item , kumi) => {
    //     return window.axios
    //         .get( 'dev/stats/summary/kumi/' + kumi.id + 'item/' + item.id )
    //         .then( ( response ) => {
    //             window.console.log( 'statsRequests---getItemStats', 69, response );
    //             store.dispatch( 'processAxiosResponse', response );
    //         } )
    //         .catch( function ( error ) {
    //             errorHandling( error );
    //         } );
    // },


    /**
     * This gets every score for the item ever without
     * identifying student info.
     * Each score includes the exam id and kumis
     * @param student
     * @returns {Promise.<T>|*}
     */
    getItemScoresForStats: ( store, item ) => {

        return window.axios
            .get( 'dev/stats/item/' + item.id )
            .then( ( response ) => {
                // window.console.log( 'statsRequests---getItemStats', 69, response );
                store.dispatch( 'processAxiosResponse', response );
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

};