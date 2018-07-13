/**
 * Created by adam on 6/12/17.
 */


const _ = window._ = require( 'lodash' );
// const Vue = require( 'vue' );

import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types'

import Payload from '../../../models/Payload'
import Item from '../../../models/Item'
import Exam from '../../../models/Exam'
import Node from '../../../models/Node'
import { traverseDF, traverseBF, getSerialNumber } from '../../../models/NodeTools'

import { updateItemsOrderRequest } from '../../../api/requests/itemRequests';

module.exports = {

    /**
     * Pushes an item into the itemMap
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param payload
     * @returns {Promise<any>}
     */
    [ aTypes.addItemToOrder ]: ( { state, dispatch, commit, getters }, payload ) => {
        return new Promise( function ( resolve, reject ) {
            // window.console.log( 'items.order.actions', aTypes.addItemToOrder, 31, payload );

            let { obj, parent, index, mutateSilently } = payload;
            let exam = getters[ gTypes.getActiveExam ];

            //Sort out whether obj and parent are nodes or items
            let toAddSerialNumber = _.isNumber( obj ) ? obj : obj.serialNumber;
            let parentSerialNumber = _.isNumber( parent ) ? parent : getSerialNumber( parent );

            // window.console.log( 'items.order.actions', 'psn', 39,payload, parent, parentSerialNumber );

            let newNode = new Node( toAddSerialNumber, parentSerialNumber );
            let parentNode = getters[ gTypes.getItemNodeFromOrder ]( parentSerialNumber );
            // window.console.log( 'items.order.actions', 'n', 39, newNode, parentNode );

            let pl = Payload.factory( {
                objNode: newNode,
                parentNode: parentNode,
                index: index,
                mutateSilently: mutateSilently
            } );
            // window.console.log( 'items.order.actions', 'pl', 47, pl );

            //push it into local ordering
            commit( mTypes.insertNodeIntoOrder, pl );

            let ordering = getters.getOrderForSync;

            //send to server
            updateItemsOrderRequest( exam, ordering ).then( function () {
                //todo add error handling.

                //todo this isn't the resolve we use because it somehow prevents the tests from finishing. Since there's no error handling yet, there's no harm leaving it outside for now
                //resolve
            } );
            resolve();
        } );
    },


    /**
     * Removes an item from the exam
     * That is, it removes the association between an item
     * and its parent with the result that the item is no
     * longer present on the exam.
     *
     * The item and all associated score data remain intact.
     */
    [ aTypes.removeItemFromOrder ]: ( { state, dispatch, commit, getters }, payload ) => {
        let serialNumber = payload.obj.serialNumber;
        let toRemove = getters[ gTypes.getItemNodeFromOrder ]( serialNumber );
        let parent = getters[ gTypes.getItemNodeFromOrder ]( toRemove.parent );
        let pl = Payload.factory( { obj: toRemove, parent: parent } );
        commit( mTypes.removeNodeFromOrder, pl );
    },

    /**
     * Handles all changes in item ordering.
     * payload should contain a key `type` with
     * one of the values:
     *      promote
     *      demote
     *      increasePosition
     *      decreasePosition
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param payload
     * @returns {Promise<any>}
     */
    [ aTypes.updateItemOrder ]: ( { state, dispatch, commit, getters }, payload ) => {
        return new Promise( function ( resolve, reject ) {
            // window.console.log( 'items.order.actions', aTypes.updateItemOrder, 31, payload );

            //fire the mutation whose name was passed in as type
            commit( payload.type, payload );

            let ordering = getters.getOrderForSync;
            let exam = getters[ gTypes.getActiveExam ];

            //send to server
            updateItemsOrderRequest( exam, ordering )
                .then( function () {
                    //todo as above, this is the appropriate place. However, it kills tests and there is no error handling.
                    //resolve();
                } );
            resolve();

        } );
    },
};
//
//
//
// let exam = getters[gTypes.getActiveExam];
//
// //Sort out whether obj and parent are nodes or items
// let toAddSerialNumber = _.isNumber( obj ) ? obj : obj.serialNumber; // getSerialNumber( obj );
// let parentSerialNumber = _.isNumber( parent ) ? parent : getSerialNumber( parent );
// // window.console.log( 'items.order.actions', 'psn', 39,payload, parent, parentSerialNumber );
//
// let newNode = new Node( toAddSerialNumber, parentSerialNumber );
// let parentNode = getters[gTypes.getItemNodeFromOrder]( parentSerialNumber );
// // window.console.log( 'items.order.actions', 'n', 39, newNode, parentNode );
// let pl = Payload.factory( {
//     objNode: newNode,
//     parentNode: parentNode,
//     index: index,
//     mutateSilently: mutateSilently
// } );
// window.console.log( 'items.order.actions', 'pl', 47, pl );
//
// //push it into local ordering
// commit( mTypes.insertNodeIntoOrder, pl );
//
// let ordering = getters.getOrderForSync;
//
// //send to server
// updateItemsOrder(exam, ordering)
//     .then(function (  ) {
//         resolve();
//     });


