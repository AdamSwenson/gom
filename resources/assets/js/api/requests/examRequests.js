/**
 * Created by adam on 7/6/17.
 */

import {REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT} from '../apiSettings';

import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Exam from '../../models/Exam'
import Item from '../../models/Item'



module.exports = {

    loadAllExams: ( store ) => {
        window.console.log( 'apiPlugin-examRequests', 'loadAllExams', 8 );
        let out = {
            requestVersion: REQUEST_VERSION
        };

        window.axios
            .get( 'dev/exams/' )
            .then( ( response ) => {
                window.console.log( 'examRequests', '', 28, response);
                // _.forEach( response.data, function ( e ) {
                    _.forEach( response.data, function ( r ) {
                        // window.console.log( 'examRequests', 'r', 29, r);
                        let exam = Exam.factory( { r } );
                        exam.id = r.id;
                        exam.name = r.name;
                        exam.term = r.term;
                        let payload = Payload.factory( { obj: exam, mutateSilently: true } );
                        store.commit( mTypes.addExam, payload );
                    } );
                // });
            } )
            .catch( function ( error ) {
                window.console.log( 'examRequests', 'ERROR', 39, error );
                // errorHandling( error );
            } );
    },

}