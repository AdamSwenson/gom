/**
 * Created by adam on 7/7/17.
 */
import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT } from '../apiSettings';
import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Exam from '../../models/Exam'
import Item from '../../models/Item'


import { errorHandling } from '../responseHandlers';

const route = 'dev/scores';

module.exports = {
    saveScore: (score) =>{
        let to = route;
        let out = {
            requestVersion: REQUEST_VERSION
        };

        window.axios
            .post( to )
            .then( ( response ) => {
                window.console.log( 'scoreRequests---getExamScoreRequest', 28, response );
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

    getExamScoreRequest: ( exam ) => {
        let to = route + '/exam/' + exam.id;
        let out = {
            requestVersion: REQUEST_VERSION
        };

        window.axios
            .get( to )
            .then( ( response ) => {
                window.console.log( 'scoreRequests---getExamScoreRequest', 28, response );
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


    getStudentScoreRequest: ( student ) => {
        let to = route + '/student/' + student.id;

        window.axios
            .get( to )
            .then( ( response ) => {
                window.console.log( 'scoreRequests---getStudentScoreRequest', 28, response );
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
        let to = route + '/item/' + item.id;

        window.axios
            .get( to )
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