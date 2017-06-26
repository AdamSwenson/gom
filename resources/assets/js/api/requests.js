/**
 * Created by adam on 6/23/17.
 */

import {errorHandling, handleResponse} from './responseHandlers';

const REQUEST_VERSION = 1;

module.exports = {

    /**
     * Handles the call to the server to update
     * properties of an item which already has an id
     * @param store
     * @param item
     */
    updateItem: ( store, item ) => {
        // if ( !item instanceof Exam ) {

        item.examId = store.getters.currentExam.id;
        item.requestVersion = REQUEST_VERSION;
        // }
        //put/patch
        window.axios
            .put( 'items/' + item.id, item )
            .then( ( response ) => {
                handleResponse( store, item, response );
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },
    /**
     * Handles the call to the server to update
     * properties of an item which already has an id
     * @param store
     * @param item
     */
    updateExam: ( store, exam ) => {
        window.console.log( 'apiPlugin', 'updateExam', 181, exam );
        let out = {
            ...exam,
            examId: store.getters.currentExam.id,
            requestVersion: REQUEST_VERSION
        };
        // }
        //put/patch
        window.axios
            .put( 'editexam/' + exam.id, exam )
            .then( ( response ) => {
                handleResponse( store, exam, response );
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    /**
     * Handles the actual call to the server to create an
     * item which doesn't have an id yet.
     * @param store
     * @param item
     */
    createItem: ( store, item ) => {
        if ( item && item.isNew() ) {
            let exam = store.getters.currentExam;
            let toSend = {
                ...item,
                requestVersion: REQUEST_VERSION,
                examId: exam.id
            };

            // }

            //id === 'undefined' || payload.obj.id === -1)
            //All IModels have an id of -1 when they are initially created.
            //This is replaced with the real id once one is returned from the server.
            //Thus, this request is to create the item.
            //When the server has done this, it will send back an id
            window.axios
                .post( 'items', toSend )
                .then( ( response ) => {
                    handleResponse( store, item, response );
                } )
                .catch( function ( error ) {
                    errorHandling( error );
                } );
        }

    },
    /**
     * Asks the server to update the order of items
     * @param store
     */
    updateItemsOrderNEW: ( store ) => {
        let ord = store.getters.getOrderForSync;
        // let sortedIds = store.getters.getSortedIds;
        let exam = store.getters.currentExam;

        let payload = {
            examId: exam.id,
            requestVersion: REQUEST_VERSION,
            order: ord
        };

        window.console.log( 'apiPlugin', 'updateItemsOrder', 178, payload );

        let route = 'items/' + exam.id + '/order';
        window.axios
            .post( route, payload )
            .then( ( response ) => {
                window.console.log( 'apiPlugin', '#### SERVER SAYS ####', 169, response );
                //  handleResponse(store, items, response);
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    }

};
/**
 //  * Asks the server to update the order of items
 //  * @param store
 //  */
// const updateItemsOrder = ( store ) => {
//     let items = store.getters.getAllItems;
//     let examId = store.getters.currentExam.id;
//     //if(typeof exam === 'undefined') return false;
//     let payload = {
//         examId: examId,
//         requestVersion: REQUEST_VERSION,
//         order: []
//     };
//
//     //build an array of ids to send
//     //note that we start at 1 so the exam id
//     //is not included
//     for (let i = 1; i < items.length; i++) {
//         if ( !_.isUndefined( items[ i ].id ) ) {
//             payload.order.push( items[ i ].id );
//         }
//     }
//
//     // window.console.log( 'apiPlugin', 'updateItemsOrder', 178, payload );
//
//     if ( items && examId ) {
//         let route = 'items/' + examId + '/order';
//         window.axios
//             .put( route, payload )
//             .then( ( response ) => {
//                 window.console.log( 'apiPlugin', '####', 169, response );
//                 //  handleResponse(store, items, response);
//             } )
//             .catch( function ( error ) {
//                 errorHandling( error );
//             } );
//
//     }
// };
