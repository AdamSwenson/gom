/**
 * Created by adam on 4/1/17.
 */
// require('../development/init-bootstrap-vue');
// window.console.log( 'apiPlugin', 'vue', 5, Vue );

// import Vue from 'vue';

// import axios from 'axios'
// import VueAxios from 'vue-axios'
//
// axios.defaults.headers.common = {
//     'X-CSRF-TOKEN': window.Laravel.csrfToken,
//     'X-Requested-With': 'XMLHttpRequest'
// };
//
// axios.defaults.baseURL = routeRoot;
// // axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector("[name=csrf-token]").content;
// // axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
//
// // This wrapper bind axios to Vue or this if you're using single file component.
// Vue.use(VueAxios, axios);

window._ = require( 'lodash' );

import {REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT} from './apiSettings';

import * as aTypes from '../store/action-types';
import * as mTypes from '../store/mutation-types';
import * as gTypes from '../store/getter-types';

import Payload from '../models/Payload'
import Exam from '../models/Exam'
import Item from '../models/Item'

import { createItem, updateExam, updateItem, updateItemsOrder } from './requests'
import {updateComment} from '../api/requests/commentRequests';

/**
 * Returns true if the mutation needs to
 * be synced with the server.
 * Returns false if we are to ignore it
 * @param mutation
 */
const shouldTellServerAboutThis = ( mutation ) => {
    let { type, payload } = mutation;

    //Check if mutateSilently has been set
    //If it has, respect its privacy
    if ( typeof payload !== 'undefined' && payload.mutateSilently ) {
        return false;
    }
    return true;

};

/**
 *This subscribes the api package which
 * handles data exchange with the server
 * to mutations in the store.
 * Called when the store is initialized
 */
export default function ( store ) {

    // Called after every mutation.
    // The mutation comes in the format of { type, payload }.
    // Thus this will catch the new item on the first mutation committing
    // it.
    store.subscribe( ( mutation ) => {
        let { type, payload } = mutation;

        window.console.log( 'apiPlugin', 'subscription detected mutation', 77, mutation, payload );


        //Check if mutateSilently has been set
        //If it has, respect its privacy
        // window.console.log( 'apiPlugin', '', 234, mutation );
        if ( !shouldTellServerAboutThis( mutation ) ) return false;

        window.console.log( 'apiPlugin', 'subscription detected mutation', 77, mutation, payload );

        let item = payload ? payload.getStoredObject( store ) : null;

        switch ( type ) {

            /**
             * This mutation type indicates that we are supposed to ask
             * the server to create something for us
             */
            case mTypes.addNewItem:
                if ( item ) {
                    createItem( store, item );
                    // payload.callback();
                }
                break;

            //this is the operation of pushing an item into the array
            case mTypes.setItem:
                if ( item ) {
                    if ( !item instanceof Exam ) {
                        Item.setExamId( store.getters.currentExam.id );

                        item.examId = store.getters.currentExam.id;
                    }
                    if ( item.isNew() ) {
                        createItem( store, item );
                        payload.callback();
                    }
                    else {
                        updateItem( store, item );
                        payload.callback();
                    }
                }
                break;

            //Now we allow the request to continue in case it wasn't just
            //asking to create something. If the model already has an id,
            //the type property will tell us which mutation was called so we can
            //make the appropriate api request
            // switch ( type ) {
            //We do NOT listen any further to
            //case mTypes.setItem:
            //That way we can avoid a loop because
            //we have to set the result of the request for ids somehow
            //Note: we were listening above, so calling setItem the first time

            case mTypes.updateItem:
                //on update calls, the object might not have been assembled.
                //so we need to try to get the item from the index too
                // let item = _.isObject( payload.obj ) ? payload.obj : store.getters.getItemByIndex( payload.index );
                window.console.log( 'apiPlugin', 'updateItem', 128, item, payload );
                if ( item instanceof Exam ) {
                    updateExam( store, item );
                }
                else if ( item instanceof Item ) {
                    updateItem( store, item );
                }

                // payload.callback();
                break;

            case mTypes.updateComment:
                window.console.log( 'apiPlugin', 'calling update comment', 140, );
                updateComment(store, item);
                break;

            case mTypes.insertNodeIntoOrder:
                updateItemsOrder( store );
                break;

            case mTypes.updateOrder:
                window.console.log( 'apiPlugin', 'updateOrder', 315, type, payload );
                updateItemsOrder( store );
                break;

            case mTypes.demoteItem:
                updateItemsOrder( store );
                break;
            case mTypes.promoteItem:
                updateItemsOrder( store );
                break;
            case 'increasePosition':
                updateItemsOrder( store );
                break;
            case 'decreasePosition':
                updateItemsOrder( store );
                break;
            default:

        }

        //todo temp disabled so can better see traffic
        // updateItemsOrder(store);

    } );

};

// const conn = {
//
//     /**
//      * Asks the server to create the given model.
//      * The server returns an id for the model.
//      * This returns the id
//      *
//      */
//     createModel: ( item ) => {
//         let api = 'items'; //hits the resource's store method (create would've returned the form to create)
//
//         window.axios
//             .post(api, item)
//             .then(( response ) => {
//                 // handleResponse(item, response);
//                 return response;
//             })
//             .catch(function ( error ) {
//                 errorHandling(error);
//             });
//     },
//
//     /**
//      * Asks the server to update the given item
//      * @param Item
//      */
//     updateModel: ( Model ) => {
//         if ( Model.id && Model.id > 0 ) {
//
//             let api = 'items/' + Model.id;
//
//             window.axios
//                 .put(api, Model)
//                 .then(( response ) => {
//                     return response;
//                     // if (response.status == 200 ){
//                     //    return callback(response);
//                     // }
//                     //
//                     // console.log( response.data )
//                     // //return Item with the new id loaded
//                     // return Model;
//                 })
//                 .catch(function ( error ) {
//                     errorHandling(error);
//                     console.log(error);
//                 });
//         }
//     }
// };
