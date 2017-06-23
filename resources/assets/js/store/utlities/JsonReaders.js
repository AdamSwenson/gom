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
import * as api from '../../api/controller'
const Vue = require( 'vue' );

const standardTimeout = 1000;

const EXAM_JSON_NAME = 'loadedExam';
const ITEM_ORDER_JSON_NAME = 'loadedItemOrder';
const ITEM_OBJECT_JSON_NAME = 'loadedItemObjects';


module.exports = {


    parseItemOrderData: ( { state, commit, dispatch, getters } ) => {

        //The data needs to be in determinate order for this to work
        let data = JSON.parse( document.getElementById( ITEM_ORDER_JSON_NAME ).getAttribute( 'data' ) );

        window.console.log( 'actions', 'parseItemORDERData', 128, data, getters );
        let pl = Payload.factory({obj: data, mutateSilently: true});
        commit('directLoadOrderFromJson', pl);

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

    },


    parseExamData: ( { state, commit, dispatch, getters } ) => {
        return new Promise( ( resolve, reject ) => {
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

                let examSerialNumber = state.items.items[ 0 ].serialNumber;
                //window.console.log( 'actions', 'esn', 117, examSerialNumber );

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
            return resolve();

        } );
    },


    parseItemObjectData: ( { state, commit, dispatch } ) => {
        return new Promise( ( resolve, reject ) => {

            //Check and see if the server gave us data to start off with.
            //Grab any pre loaded data from the div on the page where the server would've put it
            let data = JSON.parse( document.getElementById( ITEM_OBJECT_JSON_NAME ).getAttribute( 'data' ) );
            window.console.log( 'actions', 'parseItemObjectData', 128, data );

            //if there was item data, load items from it
            if ( typeof data !== 'undefined' ) {
                _.forEach( data, function ( d, i ) {
                    //d.index = i;
                    let item = Item.factory( d ); //.factory( {id: id, index: index} );
                    //set it in the items list without calling the api listener
                    commit( mTypes.setItem, Payload.factory( {
                        obj: item,
                        mutateSilently: true
                    } ) );
                } );
                resolve();
            }

        } );
    }
}
