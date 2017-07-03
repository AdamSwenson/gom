/**
 * Created by adam on 6/22/17.
 */


window._ = require( 'lodash' );

import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'
import Student from '../../models/Student'
import Exam from '../../models/Exam'
import Item from '../../models/Item'
import Node from '../../models/Node'
import Payload from '../../models/Payload'
import * as api from '../../api/old/controller'

import { getItem, getItemFromPayload, buildPayloadFromInput } from './itemHelpers'
import { traverseDF, traverseBF, getNode } from '../../models/NodeTools'


const Vue = require( 'vue' );

const standardTimeout = 1000;

const EXAM_JSON_NAME = 'loadedExam';
const ITEM_ORDER_JSON_NAME = 'loadedItemOrder';
const ITEM_OBJECT_JSON_NAME = 'loadedItemObjects';


module.exports = {
    mutations: {

        /**
         * These are actions which different parts of the gom
         * call to when they initialize.
         *
         */
        /** This is what gets run when the root instance is mounted for the setup page */
        loadInitialData: ( state, payload  ) => {
            let objectData = JSON.parse( document.getElementById( ITEM_OBJECT_JSON_NAME ).getAttribute( 'data' ) );

            let orderData = JSON.parse( document.getElementById( ITEM_ORDER_JSON_NAME ).getAttribute( 'data' ) );

            let examData = JSON.parse( document.getElementById( EXAM_JSON_NAME ).getAttribute( 'data' ) );

            window.console.log( 'JsonReaders', 'loadData', 46, state, objectData, examData, orderData);
            //assume everything is there, just load directly
            let exam = Exam.factory( examData );

            //set it in items
            state.items[ 0 ] = exam;

            //initialize the order store
            state.itemMap = new Node( exam.serialNumber, exam.serialNumber );

            //load in the item objects
            _.forEach( objectData, function ( d, i ) {
                let item = Item.factory( d ); //.factory( {id: id, index: index} );
                state.items.push( item );
            } );

            //load in the order data

            _.forEach( orderData, function ( d, i ) {
                let item = (( state, d ) => {
                    return getItem( state, d.itemId )
                })( state, d );
                //if the parent is null it is the exam, and we can skip
                if ( d.parentId === null ) return true;

                // these are top level
                //and should be added as children of the exam.
                //if the parent is null, we add the exam instead
                //todo this must be fixed since an item could have the same id as an exam
                let parentNode = ( d.parentId === state.items[0].id ) ? state.itemMap : (( state, d ) => {
                    let parentItem = getItem( state, d.parentId );
                    return getNode( state, parentItem.serialNumber );
                })( state, d );

                let itemNode = new Node( item.serialNumber, parentNode.data );


//if an index was specified, splice it in at the index
//                 if ( !_.isUndefined( index ) ) {
//                     parentNode.children.splice( index, 0, itemNode );
//                 }
//                 else {
//otherwise just push it on the end
                parentNode.children.push( itemNode );
            });

            window.console.log( 'JsonReaders', 'setupOnMount', 87, 'READY');
        },


            //todo move to more appropriate location once working
        initializeItemStore: ( state ) => {
            return new Promise( function( resolve, reject )  {
                let exam = new Exam();
                state.items[ 0 ] = exam;
                state.itemMap = new Node( exam.serialNumber, exam.serialNumber );
                resolve();
            });
        },
        directLoadObjectsFromJson: ( state, rootState, payload ) => {
            return new Promise( function( resolve, reject )  {
                // window.console.log( 'items', 'directLoadObjectsFromJson', 278, payload );
                // if ( typeof payload.obj !== 'undefined' ) {
                    _.forEach( payload.obj, function ( d, i ) {
                        let item = Item.factory( d ); //.factory( {id: id, index: index} );
                        // state.items.push(item);
                        //     //set it in the items list without calling the api listener
                        state.commit( mTypes.setItem, Payload.factory( {
                            obj: item,
                            mutateSilently: true
                        } ) );
                    } );
                    resolve();
                // }
            } );
        },

        directLoadOrderFromJson: ( state, payload ) => {
            return new Promise( ( resolve, reject ) => {

                window.console.log( 'items', 'directLoadOrderFromJson', 328, state, payload );

                // if ( ! _.isUndefined( payload.obj) ) {

                _.forEach( payload.obj, function ( d, i ) {
                    window.console.log( 'directLoadOrderFromJson', '', 34, d, i );

                    window.console.log( 'items', 'iii', 335, d );
                    let item = (( state, d ) => {
                        return getItem( state, d.itemId )
                    })( state, d );
                    window.console.log( 'directLoadOrderFromJson', 'state', 259, state );
                    window.console.log( 'directLoadOrderFromJson', 'item', 259, item );
                    //if the parent is null, these are top level
                    //and should be added as children of the exam.
                    //if the parent is null, we add the exam instead
                    let parentNode = ( d.parentId === null ) ? state.itemMap : (( state, d ) => {
                        let parentItem = getItem( state, d.parentId );
                        return getNode( state, parentItem.serialNumber );
                    })( state, d );

                    let itemNode = new Node( item.serialNumber, parentNode.data );
                    // let index = d.itemOrder;

                    window.console.log( 'items', 'direct load itemNode', 256, itemNode );
                    window.console.log( 'items', 'direct load item', 256, item );
                    window.console.log( 'items', 'direct load parentNode', 256, parentNode );


//if an index was specified, splice it in at the index
//                 if ( !_.isUndefined( index ) ) {
//                     parentNode.children.splice( index, 0, itemNode );
//                 }
//                 else {
//otherwise just push it on the end
                    parentNode.children.push( itemNode );

                    // }
                } );
                resolve();
            } );
        }
    },

    actions: {

                    // //todo move to more appropriate location once working
            // commit( 'initializeItemStore', Payload.factory( { mutateSilently: true } ));
            // dispatch( 'parseExamData' );
            // setTimeout(
            //     ()=>{
            //         window.console.log( 'JsonReaders', 'waiting', 121, );}
            // , 1000);
            // dispatch( 'parseItemObjectData' );
            // setTimeout(
            //     ()=>{
            //         window.console.log( 'JsonReaders', 'waiting', 121, );}
            //     , 1000);
            // dispatch( 'parseItemOrderData' );
            // //
            //
            // //wrap in promise? probably not since this doesn't yet hit the server
            // let p = commit( 'initializeItemStore', Payload.factory( { mutateSilently: true } ) );
            // p.then(()=>{
            //     dispatch( 'parseExamData' ).then( () => {
            //         dispatch( 'parseItemObjectData' ).then(
            //             () => {
            //                 dispatch( 'parseItemOrderData' );
            //             } );
            //     } );
            //
            // });
        // },



        parseItemOrderData: ( { state, commit, dispatch, getters } ) => {
            // return new Promise( ( resolve, reject ) => {

                //The data needs to be in determinate order for this to work
                let data = JSON.parse( document.getElementById( ITEM_ORDER_JSON_NAME ).getAttribute( 'data' ) );

                window.console.log( 'actions', 'parseItemORDERData', 128, data, getters );
                // if ( data.length > 0 ) {
                let pl = Payload.factory( { obj: data, mutateSilently: true } );
                commit( 'directLoadOrderFromJson', pl );
                // }
            //     resolve();
            // } );
        },




        // //if there was item data, load items from it
        // if ( typeof data !== 'undefined' ) {
        //     _.forEach( data, function ( d, i ) {
        //         window.console.log( 'JsonReaders', '', 34, d, i );
        //
        //         let item = getters.getItemById( d.itemId );
        //         //if the parent is null, these are top level
        //         //and should be added as children of the exam
        //         let parent = ( d.parentId === null ) ? getters.currentExam : getters.getItemById( d.parentId );
        //
        //         let pl = Payload.factory( {
        //             obj: item,
        //             parent: parent,
        //             index: d.itemOrder,
        //             mutateSilently: true
        //         } );
        //
        //         window.console.log( 'JsonReaders', 'preDispatch', 39, pl );
        //         dispatch( aTypes.addItemToOrder, pl );
        //     } );
        // }
        //
        // dispatch( aTypes.addItemToOrder , pl);
        //
        // var queue = [];
        // queue.push( root );
        // let currentTree = queue.pop();
        //
        // while (currentTree) {
        //     for (var i = 0, length = currentTree.children.length; i < length; i++) {
        //         queue.push( currentTree.children[ i ] );
        //     }
        //
        //     callback( currentTree );
        //     currentTree = queue.pop();
        // }


        parseExamData: ( { state, commit, dispatch, getters } ) => {
            // return new Promise( ( resolve, reject ) => {
                //Check and see if the server gave us data to start off with.
                //Grab any preloaded data from the div on the page where the server would've put it
                let examData = JSON.parse( document.getElementById( EXAM_JSON_NAME ).getAttribute( 'data' ) );
                window.console.log( 'actions', 'parseExamData', 103, examData );

                //there was exam data, load an exam from it
                if ( typeof examData != 'undefined' ) {

                    //We need to do work on the exam in two places.
                    //First, we will update the stored object properties.
                    //Make sure the index is what we expect
                    examData.index = 0;

                    let examSerialNumber = getters.currentExam; //items.items[ 0 ].serialNumber;
                    window.console.log( 'actions', 'esn', 117, examSerialNumber );

                    Exam.fillableProps.forEach(
                        ( prop ) => {
                            // window.console.log( 'actions', 'prop', 119, prop, examData[ prop ] );
                            if ( examData[ prop ] ) {
                                commit( mTypes.updateItem, Payload.factory( {
                                    mutateSilently: true,
                                    index: 0,
                                    updateProp: prop,
                                    updateVal: examData[ prop ]
                                } ) );
                            }
                        } );
                }
                //
                // //Second, we need to make sure that everything is still
                // //cool with the ordering.
                // //In particular we need to be sure that the serial numbers
                // //still correspond
                // let ex = state.items.items[ 0 ];
                // let esn = ex.serialNumber;
                // let im = getters.getRootNode;
                // if ( im.parent === esn && im.data === esn ) return true;
                // //if they've diverged, update them
                // commit( 'setRootNode', Payload.factory( { obj: ex } ) );
                //
            //     return resolve();
            //
            // } );
        },


        parseItemObjectData: ( { state, commit, dispatch, getters } ) => {
            // return new Promise( ( resolve, reject ) => {

                //Check and see if the server gave us data to start off with.
                //Grab any pre loaded data from the div on the page where the server would've put it
                let data = JSON.parse( document.getElementById( ITEM_OBJECT_JSON_NAME ).getAttribute( 'data' ) );
                window.console.log( 'actions', 'parseItemObjectData', 128, data );
                if ( data.length > 0 ) {
                    let pl = Payload.factory( { obj: data, mutateSilently: true } );
                    commit( 'directLoadObjectsFromJson', pl );
                }

                // resolve();
                // //if there was item data, load items fro
                // //if there was item data, load items from it
                // if ( typeof data !== 'undefined' ) {
                //     _.forEach( data, function ( d, i ) {
                //         //d.index = i;
                //         let item = Item.factory( d ); //.factory( {id: id, index: index} );
                //         //set it in the items list without calling the api listener
                //         commit( mTypes.setItem, Payload.factory( {
                //             obj: item,
                //             mutateSilently: true
                //         } ) );
                //     } );
                //     resolve();
                // }

            // } );
        }
    }
}
