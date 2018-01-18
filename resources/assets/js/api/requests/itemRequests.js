import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT, Routes } from '../apiSettings';

import { errorHandling, handleResponse } from '../responseHandlers';

/**
 * This is the new module to use for item requests
 * as of 2018-01-17
 *
 * @type {{getItemsForExam: function(*)}}
 */

module.exports = {

    /**
     * Requests that the server create an item
     * with the properties of the object provided.
     * It returns the axios.data object.
     *
     * When calling this method, the next step will
     * usually be setting the item's id from the object
     * this method returns.
     *
     * @param item
     * @returns {Promise<T> | *}
     */
    createItem: ( item) => {

        let toSend = {
            //we will send the entire
            // new item. This is in case
            // we eventually have some defaults for the user
            // set on the client-side.
            ...item,
            requestVersion: REQUEST_VERSION,
             };

        //All IModels have an id of -1 when they are initially created.
        //This is replaced with the real id once one is returned from the server.
        //Thus, this request is to create the item.
        //When the server has done this, it will send back an id
        return window.axios
            .post( Routes.createItem(), toSend )
            .then( ( response ) => {
                window.console.log( 'itemRequests', 'axios', 44, response );
                return response.data;
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );


    },




    getItemsForExam: ( exam ) => {
        let to = 'items/exam/' + exam.id;

        return window.axios.get( to )
            .then( function ( response ) {
// //The returned array  will have the keys
//             //  'itemObjects'
//             //  'itemOrder'

            return response.data;

        } ).catch( function () {

        } );
    },

    /**
     * Asks the server to update the order of items.
     * Uses route commonBaseRoute + '/' + exam.id + '/order'
     * @param store
     * @returns {Promise}
     */
    updateItemsOrder: ( exam, ordering ) => {

        let payload = {
            examId: exam.id,
            requestVersion: REQUEST_VERSION,
            order: ordering
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