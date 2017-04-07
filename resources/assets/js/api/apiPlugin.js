/**
 * Created by adam on 4/1/17.
 */
// import Vue from 'vue'
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

import * as aTypes from '../store/action-types';
import * as mTypes from '../store/mutation-types';
import * as gTypes from '../store/getter-types';

import Payload from '../models/Payload'
import Exam from '../models/Exam'
import Item from '../models/Item'

const errorHandling = ( error ) => {
    if ( error.response ) {
        // The request was made, but the server responded with a status code
        // that falls out of the range of 2xx
        console.log(error.response.data);
        console.log(error.response.status);
        console.log(error.response.headers);
    } else {
        // Something happened in setting up the request that triggered an Error
        console.log('Error', error.message);
    }
    console.log(error.config);
};

const handleResponse = ( store, item, response ) => {
    window.console.log('apiPlugin', 'handleResponse', 43, response, item, store);
    if ( typeof response.data === 'undefined' ) return false;

    //return Item with the new id or other data loaded
    if ( typeof response.data !== 'undefined' ) {

        switch ( item.kind ) {
            case 'exam':
                if ( typeof item.index !== 'undefined' && item.index === 0 ) {
                    Exam.fillableProps.forEach(function ( p ) {
                        if ( p !== 'index' ) {
                            // window.console.log('apiPlugin', 50, p);
                            if ( Object.keys(response.data).includes(p) ) {
                                store.commit(mTypes.updateItemSilently, Payload.factory({
                                    index: item.index,
                                    updateProp: p,
                                    updateVal: response.data[ p ],
                                    mutateSilently: true
                                }));
                            }
                        }
                    });
                }
                break;

            case 'item':
                Item.fillableProps.forEach(function ( p ) {
                    if ( p !== 'index' ) {
                        if ( Object.keys(response.data).includes(p) ) {
                            store.commit(mTypes.updateItemSilently, Payload.factory({
                                index: item.index,
                                updateProp: p,
                                updateVal: response.data[ p ],
                                mutateSilently: true
                            }));
                        }
                    }
                });
                break;
            default:
        }
    }
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
    store.subscribe(( mutation ) => {

        let {type, payload} = mutation;
        switch ( type ) {
            case mTypes.setItem:
                if ( typeof payload !== 'undefined' && !payload.mutateSilently ) {

                    let item = typeof payload.obj !== 'undefined' ? payload.obj : store.getters.getItemByIndex(payload.index);

                    if ( !item instanceof Exam ) {

                        item.examId = store.getters.getExamId;
                    }


                    if ( item && item.isNew() ) {
                        //id === 'undefined' || payload.obj.id === -1)
                        //All IModels have an id of -1 when they are initially created.
                        //This is replaced with the real id once one is returned from the server.
                        //Thus, this request is to create the item.
                        //When the server has done this, it will send back an id
                        window.axios
                            .post('items', item)
                            .then(( response ) => {
                                handleResponse(store, item, response);
                            })
                            .catch(function ( error ) {
                                errorHandling(error);
                            });
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
                let item = typeof payload.obj !== 'undefined' ? payload.obj : store.getters.getItemByIndex(payload.index);

                if ( !item instanceof Exam ) {

                    item.examId = store.getters.getExamId;
                }

                //put/patch
                window.axios
                    .put('items/' + item.id, item)
                    .then(( response ) => {
                        //     handleResponse(store, item, response);
                    })
                    .catch(function ( error ) {
                        errorHandling(error);
                    });
                break;

            case mTypes.demoteItem:
                break;
            case mTypes.promoteItem:
                break;
            default:

        }
    });
};
