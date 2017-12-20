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

const makeRoute = ( exam, item, student ) => {
    return route + '/' + exam.id + '/' + item.id + '/' + student.id;
};

module.exports = {
    /**
     * Requests that a score be saved for the item.
     * Does not update comment text.
     * That needs to be handled separately.
     * @param exam
     * @param item
     * @param student
     * @param scoreObject
     * @returns {Promise<T> | *}
     */
    saveItemScoreRequest: ( exam, item, student, score ) => {
        let to = makeRoute( exam, item, student );

        let out = {
            requestVersion: REQUEST_VERSION,
            score : score
        };

        return window.axios
            .post( to, out )
            .then( ( response ) => {
                window.console.log( 'scoreRequests---saveItemScoreRequest', 28, response );
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    /**
     * Requests that comment text be saved for the item
     * Does not update the score. That must be handled
     * separately.
     *
     * @param exam
     * @param item
     * @param student
     * @param scoreObject
     * @returns {Promise<T> | *}
     */
    saveCommentTextRequest: ( exam, item, student, text ) => {
        let to = makeRoute( exam, item, student );

        let out = {
            requestVersion: REQUEST_VERSION,
            commentText : text
        };

        return window.axios
            .post( to, out )
            .then( ( response ) => {
                window.console.log( 'scoreRequests---saveCommentTextRequest', 28, response );
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },


    /**
     * Gets all item scores for all students on the exam
     * @param exam
     * @returns {Promise<T> | *}
     */
    getAllScoresForExamRequest: ( exam ) => {
        // let to = route + '/exam/' + exam.id;
        let out = {
            requestVersion: REQUEST_VERSION
        };

        return window.axios
            .get( Routes.getExamScoreRequest( exam ) )
            .then( ( response ) => {
                // window.console.log( 'scoreRequests---getExamScoreRequest', 28, response );
                return response.data;
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },


    /**
     * Gets all scores for the student, regardless of exam
     * or item
     * @param student
     * @returns {Promise<T> | *}
     */
    getStudentScoreRequest: ( student ) => {

        return window.axios
            .get( Routes.getStudentScoreRequest( student ) )
            .then( ( response ) => {
                window.console.log( 'scoreRequests---getStudentScoreRequest', 28, response );
                return response.data;
                // _.forEach( response.data, function ( e ) {
                _.forEach( response.data, function ( r ) {
                    // window.console.log( 'examRequests', 'r', 29, r);
                    // let exam = Exam.factory( { r } );
                    // exam.id = r.id;
                    // exam.name = r.name;
                    // exam.term = r.term;
                    // let payload = Payload.factory( { obj: exam, mutateSilently: true } );
                    // store.commit( mTypes.addExam, payload );
                } );
                // });
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    getItemScoreRequest: ( item ) => {

        return window.axios
            .get( Routes.getItemScoreRequest( item ) )
            .then( ( response ) => {
                window.console.log( 'scoreRequests---getItemScoreRequest', 28, response );
                // _.forEach( response.data, function ( e ) {
                _.forEach( response.data, function ( r ) {
                    // window.console.log( 'examRequests', 'r', 29, r);
                    // let exam = Exam.factory( { r } );
                    // exam.id = r.id;
                    // exam.name = r.name;
                    // exam.term = r.term;
                    // let payload = Payload.factory( { obj: exam, mutateSilently: true } );
                    // store.commit( mTypes.addExam, payload );
                } );
                // });
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    }
};