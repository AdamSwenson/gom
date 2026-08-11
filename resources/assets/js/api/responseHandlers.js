/**
 * Created by adam on 6/23/17.
 */

window._ = require( 'lodash' );
import * as aTypes from '../store/action-types';
import * as mTypes from '../store/mutation-types';
import * as gTypes from '../store/getter-types';

import Payload from '../models/Payload'
import Exam from '../models/Exam'
import Item from '../models/Item'

/**
 * Calls a silent mutation on the item to update it
 * after the server has updated
 * @param store
 * @param item
 * @param response
 * @returns {Promise}
 */
const handleItemResponse = ( store, item, response ) => {
    return new Promise( ( resolve, reject ) => {
        Item.fillableProps.forEach( function ( p ) {
            if ( p !== 'index' ) {
                if ( Object.keys( response ).includes( p ) ) {
                    store.commit( mTypes.updateItem, Payload.factory( {
                        obj: item,
                        updateProp: p,
                        updateVal: response[ p ],
                        mutateSilently: true
                    } ) );

                }
            }
        } );
        resolve( item );
    } );

};

const handleExamResponse = ( store, item, response ) => {
    return new Promise( ( resolve, reject ) => {
        if ( typeof item.index !== 'undefined' && item.index === 0 ) {
            Exam.fillableProps.forEach( function ( p ) {
                if ( p !== 'index' ) {
                    // window.console.log('apiPlugin', 50, p);
                    if ( Object.keys( response.data ).includes( p ) ) {
                        let jsProp = (p === 'max_score') ? 'maxScore' : p;
                        store.commit( mTypes.updateItem, Payload.factory( {
                            index: item.index,
                            updateProp: jsProp,
                            updateVal: response.data[ p ],
                            mutateSilently: true
                        } ) );
                    }
                }
            } );
            resolve( item );
        }
    } );
};

const responseHandlers = {


    /**
     * Handles exam and item requests.
     * Will call silent mutation to update the relevant object
     * on success.
     * @param store
     * @param item
     * @param response
     * @returns {Promise}
     */
    handleResponse: ( store, item, response ) => {
        return new Promise( function ( resolve, reject ) {
            // window.console.log('apiPlugin', 'handleResponse', 43, response, item, store);

            //check if there was a data field wrapping the response data.
            //if there was, set the json object as response
            if ( typeof response.data !== 'undefined' ) response = response.data;

            //return Item with the new id or other data loaded
            switch ( item.kind ) {
                case 'exam':
                    let p = handleExamResponse( store, item, response );
                    p.then( function ( resolve ) {
                        // window.console.log( 'responseHandlers', 'exam response resolved', 73 );
                        resolve();
                    } );

                    break;

                case 'item':
                    //this returns a promise
                    handleItemResponse( store, item, response )
                        //this is what we do when it succeeds
                        .then( function () {
                            // window.console.log( 'responseHandlers', 'item response resolved', 81 );
                            //we resolve our outer promise
                            resolve();
                        } )
                        .catch( function () {
                            reject( Error( "Error in handling item response" ) );
                        } );
                    break;
                default:
                    reject( Error( "Invalid item kind" ) );
            }

        } );
    },


    errorHandling: ( error ) => {
        if ( error.response ) {
            // The request was made, but the server responded with a status code
            // that falls out of the range of 2xx
            console.log( error.response.data );
            console.log( error.response.status );
            console.log( error.response.headers );
        } else {
            // Something happened in setting up the request that triggered an Error
            console.log( 'Error', error.message );
        }
        console.log( error.config );
    }

};

export const { handleResponse, errorHandling } = responseHandlers;
