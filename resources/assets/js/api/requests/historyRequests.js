import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT, Routes } from '../apiSettings';

import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Exam from '../../models/Exam'
import Item from '../../models/Item'

import { errorHandling, handleResponse } from '../responseHandlers';
import { holdForIdLoading } from '../apiHelpers';


module.exports = {

    /**
     * Gets score histories for the item on
     * all exams
     *
     * @param store
     * @param item
     */
    getItemHistory: ( store, item ) => {
        window.console.log( 'apiPlugin-commentRequests', 'getItemHistory', 8 );
        let out = {
            requestVersion: REQUEST_VERSION
        };

        window.axios
            .get( Routes.getItemHistory( item ), out )
            .then( ( response ) => {
                //The response will contain exams
                //if we want scores, we can go back again with those
                let exams = [];
                if(response.data.length > 0){
                    _.forEach(response.data, (exam)=>{
                        exams.push(Exam.factory(exam));
                    });
                }
                return exams;

                // handleResponse( store, item, response );
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    /**
     * Returns how the student has done on other exams
     * @param store
     * @param student
     */
    getStudentHistory: ( store, student ) => {

    }
}

