/**
 * Created by adam on 6/23/17.
 */

import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT, Routes } from './apiSettings';

import { errorHandling, handleResponse } from './responseHandlers';
import { holdForIdLoading } from './apiHelpers';


import examRequests from './requests/examRequests';
import commentRequests from './requests/commentRequests';


const checkItemForId = ( item ) => {
    return item.id >= 0;
};


module.exports = {
    ...examRequests,
    // ...commentRequests,

    /**
     * Handles the call to the server to update
     * properties of an item which already has an id.
     * Uses PUT
     *
     * @param store
     * @param item
     * @returns {Promise}
     */
    updateItem: ( store, item ) => {
        if ( holdForIdLoading( item ) ) {
            //copy so vuex doesn't yell
            let out = Object.assign( {}, item );
            out.examId = store.getters.currentExam.id;
            out.requestVersion = REQUEST_VERSION;

            //put/patch
            return window.axios
                .put( Routes.updateItem( item ), item )
                .then( ( response ) => {
                    handleResponse( store, item, response )
                        .then( function () {
                            // window.console.log( 'requests', 'handleResponse promise resolved', 46 );
                        } )
                        .catch( function ( error ) {
                            throw error;
                        } );
                } )
                .catch( function ( error ) {
                    errorHandling( error );
                } );
        }
    },

    /**
     * Handles the call to the server to update
     * properties of an item which already has an id
     * @param store
     * @param item
     * @returns {Promise}
     */
    updateExam: ( store, exam ) => {
        window.console.log( 'apiPlugin', 'updateExam', 181, exam );
        let out = {
            ...exam,
            examId: store.getters.currentExam.id,
            requestVersion: REQUEST_VERSION
        };

        return window.axios
            .put( Routes.updateExam( exam ), exam )
            .then( ( response ) => {
                handleResponse( store, exam, response )
                    .then( function () {
                        // window.console.log( 'requests', 'handleResponse promise resolved', 46 );
                    } )
                    .catch( function ( error ) {
                        throw error;
                    } );
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
     * @returns {Promise}
     */
    createItem: ( store, item ) => {
        //Make sure the item is kosher
        //If not, something might be expecting a promise
        //so we make one and immediately reject it
        if ( !item && !item.isNew() ) {
            return new Promise( ( resolve, reject ) => {
                reject( Error( "createItem: No item or old item passed to create" ) )
            } );
        }

        let exam = store.getters.currentExam;
        let toSend = {
            ...item,
            requestVersion: REQUEST_VERSION,
            examId: exam.id
        };

        //id === 'undefined' || payload.obj.id === -1)
        //All IModels have an id of -1 when they are initially created.
        //This is replaced with the real id once one is returned from the server.
        //Thus, this request is to create the item.
        //When the server has done this, it will send back an id
        return window.axios
            .post( Routes.createItem(), toSend )
            .then( ( response ) => {
                handleResponse( store, item, response )
                    .then( function () {
                        // window.console.log( 'requests', 'createItem', 'handleResponse promise resolved', 46 );
                    } )
                    .catch( function ( error ) {
                        throw error;
                    } );
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );


    },

    /**
     * Asks the server to update the order of items.
     * Uses route commonBaseRoute + '/' + exam.id + '/order'
     * @param store
     * @returns {Promise}
     */
    updateItemsOrder: ( store ) => {
        //This getter will also check to make sure we have ids
        //if not, it will wait until we have an id for each item
        let ord = store.getters.getOrderForSync;

        let exam = store.getters.currentExam;

        let payload = {
            examId: exam.id,
            requestVersion: REQUEST_VERSION,
            order: ord
        };

        let route = Routes.updateItemsOrder( exam );

        return window.axios
            .post( route, payload )
            .then( ( response ) => {
                // window.console.log( 'apiPlugin', '#### SERVER SAYS ####', 169, response );
                //No need to update our internally stored objects
                //on the basis of the result
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
