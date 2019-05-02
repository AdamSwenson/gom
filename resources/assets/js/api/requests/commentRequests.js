/**
 * Created by adam on 7/6/17.
 */

import {REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT, Routes} from '../apiSettings';

import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Exam from '../../models/Exam'
import Item from '../../models/Item'

import { errorHandling, handleResponse } from '../responseHandlers';
import { holdForIdLoading } from '../apiHelpers';

// const ROUTE_BASE = 'comments';

// const makeRoute = (item)=>{return ROUTE_BASE + '/' + item.id};

module.exports = {

    /**
     * This is used during the setup process to handle
     * updating the stock comments for an item
     * @param item
     * @param overWriteDefaults If true, the server will update comments on graded exams with the new text
     * @param examId
     */
    updateComment: ( item, overWriteDefaults=false, examId=false ) => {
        window.console.log( 'apiPlugin-commentRequests', 'updateComment', 8 );
        let out = {
            requestVersion: REQUEST_VERSION
        };

        if ( holdForIdLoading( item ) ) {
//copy so vuex doesn't yell
//             let out = Object.assign( {}, item );
            out.item = item;
            out.itemId = item.id;
            out.comments = item.comments;

            //This tells the server to update the text of
            //default (i.e., non-custom) comments assigned
            //to graded students
            if(overWriteDefaults && examId) {
                out.overwriteDefaults = true;
                out.examId = examId;
            }

            //put/patch
            return window.axios
                .post( Routes.updateComment(item), out )
                .then( ( response ) => {
                    // handleResponse( store, item, response );
                } )
                .catch( function ( error ) {
                    errorHandling( error );
                } );
        }
    },

    assignDefaultCommentsToGradedItems: (exam) =>{
        //Update the item_scores table for the exam, adding
//default comments to any scored item which lacks a comment
        return window.axios.put(Routes.assignDefaultCommentsToGradedItemsRequest(exam));
}


}