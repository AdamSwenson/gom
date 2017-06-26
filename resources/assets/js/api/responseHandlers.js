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

module.exports = {
    handleItemResponse: ( store, item, response ) => {
        // return new Promise( ( resolve, reject ) => {
        Item.fillableProps.forEach( function ( p ) {
            if ( p !== 'index' ) {
                if ( Object.keys( response.data ).includes( p ) ) {
                    store.commit( mTypes.updateItemSilently, Payload.factory( {
                        obj: item,
                        updateProp: p,
                        updateVal: response.data[ p ],
                        mutateSilently: true
                    } ) );

                }
            }
        } );

        _.forEach( Item.aliasMap, function ( v, k ) {
            // if ( Object.keys( response.data ).includes( k ) ) {
            //     store.commit( mTypes.updateItemSilently, Payload.factory( {
            //        obj:item,
            //         updateProp: v,
            //         updateVal: response.data[ k ],
            //         mutateSilently: true
            //     } ) );
            // }
        } );
        // resolve();
        // } );
    },

    handleExamResponse: ( store, item, response ) => {
        return new Promise( ( resolve, reject ) => {
            if ( typeof item.index !== 'undefined' && item.index === 0 ) {
                Exam.fillableProps.forEach( function ( p ) {
                    if ( p !== 'index' ) {
                        // window.console.log('apiPlugin', 50, p);
                        if ( Object.keys( response.data ).includes( p ) ) {
                            let jsProp = (p === 'max_score') ? 'maxScore' : p;
                            store.commit( mTypes.updateItemSilently, Payload.factory( {
                                index: item.index,
                                updateProp: jsProp,
                                updateVal: response.data[ p ],
                                mutateSilently: true
                            } ) );
                        }
                    }
                } );
                resolve();
            }
        } );
    },

    handleResponse: ( store, item, response ) => {
        // return new Promise( ( resolve, reject ) => {
        // window.console.log('apiPlugin', 'handleResponse', 43, response, item, store);
        if ( typeof response.data === 'undefined' ) return false;

        //return Item with the new id or other data loaded
        if ( typeof response.data !== 'undefined' ) {

            switch ( item.kind ) {
                case 'exam':
                    handleExamResponse( store, item, response );
                    // .then( ( resolve ) => {
                    //     resolve();
                    // } );
                    break;

                case 'item':
                    handleItemResponse( store, item, response );
                    // resolve();
                    // .then( ( resolve ) => {
                    //     resolve();
                    // } );

                    break;
                default:
                    reject()
            }

        }
        // } );
    },


 errorHandling : ( error ) => {
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
