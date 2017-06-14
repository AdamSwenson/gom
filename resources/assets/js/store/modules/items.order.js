/**
 * This pulls together the various parts of
 * handling item order.
 * If there was something which required multiple
 * portions of the tools to be used, it would
 * be defined in this file
 *
 * Otherwise, it just makes the locations of
 * methods more intelligible and helps clean
 * up the items.js file where everything comes
 * together
 *
 * Created by adam on 4/11/17.
 */


const _ = window._ = require( 'lodash' );
const Vue = require( 'vue' );

import * as mTypes from '../../store/mutation-types'
import * as aTypes from '../../store/action-types'
import * as gTypes from '../../store/getter-types'

import Payload from '../../models/Payload'
import Item from '../../models/Item'
import Exam from '../../models/Exam'
import Node from '../../models/Node'

import * as orderMutations from './items.order.mutations'
import * as orderActions from './items.order.actions'
import * as orderGetters from './items.order.getters'
import * as orderState from './items.order.state'









let getItemFromOrder = ( order, idx ) => {
    let itm = order[ 0 ];
    //idx is a tuple stored as an array
    for (let i = 0; i < idx.length; i++) {
        itm = itm.children[ i ]
    }
    return itm;
};

let getItemFromList = ( orderList, idx ) => {
    let itm = orderList[ 0 ];
    //idx is a tuple stored as an array
    for (let i = 0; i < idx.length; i++) {
        itm = itm[ 1 ][ i ]
    }
    return itm;
};


import {traverseDF, traverseBF, getSerialNumber } from '../../../../../resources/assets/js/models/NodeTools'

/**
 * Only these can call the mutations.
 * That is, no external method should call a mutation.
 * Thus there needs to be at least one action  for each mutation.
 *
 * Since most of this will require at least
 * two steps (find the item in the tree, update it, etc),
 * The mutations will receive the parent node and
 * new child node (or node to be removed, etc).
 *
 * @type {{}}
 */
const actions = orderActions;
const getters = orderGetters;
const mutations = orderMutations;
const state = orderState;

export default {
    actions,
    getters,
    mutations,
    state
}
// {
//     itemMap: new Node( 0, 0 ),
//
//     /*
//      * What we want to have is the ability to store nested
//      * tuples which map the item to a position on an exam
//      * (which is itself formally an item).
//      * order : {
//      *      0 : {
//      *          id: null,
//      *          children: {
//      *              0 : {
//      *                      id: null.
//      *                      children: {}
//      *                 }
//      *          }
//      *      }
//      }
//      *
//      * */
//     //the first value in the array is the item's id
//     //the second value is an array of children
//     // orderMap: new Map(),
//     // orderList: [],
//     //
//     // order: {
//     //     0: {
//     //         id: null,
//     //         children: {
//     //             0: {
//     //                 id: null,
//     //                 children: {}
//     //             }
//     //         }
//     //     }
//     // }
//     // orderMap: new Map(),
//     // order: {}
//
// };

// {
//         insert: ( state, payload ) => {
//             let { index, obj, parent } = payload;
//
//             //type check
//             if ( !parent instanceof Node ) return false;
//             if ( !obj instanceof Node ) return false;
//
//             //if an index was specified, splice it in at the index
//             if ( !_.isUndefined( index ) ) {
//                 return parent.children.splice( index, 0, obj );
//             }
//             //otherwise just push it on the end
//             return parent.children.push( obj );
//
//         },
//
//
//         remove: ( state, payload ) => {
//             let { obj, parent } = payload;
//             //Merge its children into its parent's children
//             parent.children.concat( obj.children );
//             //delete the node
//             let idx = parent.children.indexOf( obj );
//             parent.children.splice( idx, 1 );
//         },
//
//         /*
//          // addMappedItem: ( state, idx, toAdd ) => {
//          //     state.orderMap.set( idx, toAdd );
//          // },
//
//          //these should probably be methods on node
//          //or maybe not since that would make it harder
//          //to remove a child without also removing its
//          //children (if we want that to be an option)
//          //         addChild: ( state, idx, idToAdd ) => {
//          //             let child = [ idToAdd, [] ];
//          //             let itm = orderList[ 0 ];
//          //             //idx is a tuple stored as an array
//          //             for (let i = 0; i < idx.length; i++) {
//          //                 itm = itm[ 1 ][ i ]
//          //             }
//          //             let children = itm[ 1 ];
//          //             children.push( child );
//          //             Vue.set( itm, 1, children );
//          //             //
//          //             //
//          //             // let item = getItemFromList(state.orderList,  idx);
//          //             // if (! _.isEmpty(item)){
//          //             //     let maxIndex = _.last( Object.keys(item.children));
//          //             //     item.children
//          //             // }
//          //
//          //             // let item = getItemFromOrder(state.order,  idx);
//          // // if (! _.isEmpty(item)){
//          // //     let maxIndex = _.last( Object.keys(item.children));
//          // //     item.children
//          // // }
//          //
//          //         },
//          //
//          //         addParent: ( state, existing, toAdd ) => {
//          //
//          //         //
//          //         },
//          // addOlderSibling: ( state, existing, toAdd ) => {
//          // },
//          // addYoungerSibling: ( state, existing, toAdd ) => {
//          // },
//          */
// //
//     }
// ;


// {
//
//     [aTypes.addItemToOrder]: ( { state, dispatch, commit, getters }, payload ) => {
//         let { index, obj, id, parent } = payload;
//
//         //Sort out whether obj and parent are nodes or items
//         let toAddSerialNumber = getSerialNumber(obj);
//         let parentSerialNumber = getSerialNumber(parent)
//             let n = new Node(toAddSerialNumber, parentSerialNumber );
//
//         let f = function ( currentNode ) {
//             if ( currentNode.data === parentSerialNumber ) {
//                 let pl = Payload.factory( { index: index, obj: n, parent: currentNode } );
//
//                 commit( 'insert', pl );
//                 return false;
//             }
//             return true;
//         }
//
//         traverseDF( state.itemMap, f );
//
//     },
//
//     [aTypes.removeItemFromOrder]: ( { state, dispatch, commit, getters }, payload ) => {
//         let {serialNumber} = payload;
//         // let  serialNumber = getSerialNumber(payload);
//         let toRemove = getters[ gTypes.getItemNodeFromOrder ]( serialNumber );
//         let parent = getters[ gTypes.getItemNodeFromOrder ]( toRemove.parent );
//         let pl = Payload.factory( { obj: toRemove, parent: parent } );
//         commit( 'remove', pl );
//     },
//
// };
//r{
//
//     /**
//      * Returns the children array of
//      * the exam stored as itemMap. It includes the exam
//      * @param state
//      * @param getters
//      * @returns {Node}
//      */
//     [gTypes.getItemMapCopy]: ( state, getters ) => {
//         return Object.assign( new Node(), state.itemMap );// ['parent','data', 'dataType', 'children']);
//     },
//
//     [gTypes.getItemNodeFromOrder]: ( state, getters, serialNumber ) => {
//         return (function ( state, serialNumber ) {
//             let callback = function ( node ) {
//                 if ( !callback.found ) callback.found = [];
//                 // window.console.log( 'orderings', 'callback', 253, node.data, serialNumber );
//                 if ( node.data === serialNumber ) {
//                     callback.found.push( node );
//                     // window.console.log( 'orderings.spec', 'callback.found', 78, node, callback.found );
//                     return true;
//                 }
//                 return false;
//             };
//             traverseBF( state.itemMap, callback );
//             let result = callback.found[ 0 ];
//             return result;
//         })( state, serialNumber )
//     },
//
//     /**
//      * Find the number of parents the node has
//      * @param state
//      * @param getters
//      * @param serialNumber
//      */
//     [gTypes.getHeightOfNode]: ( state, getters, serialNumber ) => {
//         let level = 0;
//
//         return (function recurse( serialNumber ) {
//             // window.console.log( 'items.order', 'recurse', 245, serialNumber, level);
//             //look up the node whose serial number we've just  been handed.
//             let node = getters[gTypes.getItemNodeFromOrder](state, getters, serialNumber);
//             //break condition is that we've hit the exam
//             //which is of course the only item which is its
//             //own parent
//             if (node.parent === node.data) return level;
//             //Otherwise, increment the level counter
//             // and re-run on the parent
//             level += 1;
//             return recurse(node.parent);
//         })( serialNumber );
//     },
//
//
//
//     /**
//      * Find the index position of the node in its parent's children array
//      * @param state
//      * @param getters
//      * @param serialNumber
//      */
//     [gTypes.getDepthOfNode]: ( state, getters, serialNumber ) => {
//         //look up the node whose serial number we've just  been handed.
//         let node = getters[gTypes.getItemNodeFromOrder](state, getters, serialNumber);
//         let parent = getters[gTypes.getItemNodeFromOrder](state, getters, node.parent);
//         if(parent){
//             for(let index=0; index<parent.children.length; index++){
//                 if(parent.children[index] === node){
//                     return index;
//                 }
//             }
//         }
//     }
//
// };


// /**
//  * Given a serial number, returns true if that serial number is
//  * in the tree and false otherwise.
//  * @param state
//  * @param getters
//  */
// containsSerialNumber: ( state, getters ) => ( serialNumber ) => {
//     //todo
// },
//
// /**
//  * Looks up the serial number of the item which is
//  * occupying the position identified by the index.
//  * @param index
//  */
// getItemSerialNumberFromIndex: ( state, getters ) => ( index ) => {
//     //remove the payload wrapper if necessary
//     if ( Payload.checkIfPayload( index ) ) {
//         index = index.index;
//     }
//
//     //if this is a single member array, we can treat
//     //it like a numeric input under the older system
//     if ( _.isArray( index ) && index.length === 1 ) {
//         index = index[ 0 ];
//     }
//
//     //Now we're ready to deal with the input
//     return function ( state, index ) {
//         //There are two cases to consider
//         //We deal first with the easy case in which the index
//         //is a number or string representation of a number
//         //and not a composite
//         if ( !_.isArray( index ) ) {
//             //if was just a string or integer this is fine
//             //also if the input was an array with only one item
//             var r = state.orderings.filter( function ( i ) {
//                 if ( i.index === index ) {
//                     return i;
//                 }
//             } );
//             return r[ 0 ];
//         }
//
//         else {
//             //we need to do something different
//             //because it is an array
//             if ( _.isArray( index ) ) {
//                 let idx = index.join( '-' );
//             }
//
//         }
//
//     }( state, index );
//
// },
//
// /**
//  * Given an item's permanent unique identifier, it returns
//  * up the item's location
//  * @param serialNumber
//  */
// getIndexFromItemSerialNumber: ( state, getters ) => ( serialNumber ) => {
//     let callback = ( node ) => {
//         if ( node.serialNumber === serialNumber ) {
//             return node;
//         }
//     }
//     // this is a recurse and immediately-invoking function
//     (function recurse( currentNode ) {
//         // step 2
//         for (var i = 0, length = currentNode.children.length; i < length; i++) {
//             // step 3
//             recurse( currentNode.children[ i ] );
//         }
//
//         // step 4
//         callback( currentNode );
//
//         // step 1
//     })( this._root );
//
// },
//
// getAllNodesAtLevel: ( state, getters ) => ( level ) => {
//     if ( level === 0 ) {
//         //special case because 0,0 is the exam
//         //so we need to subtract 1
//     } else {
//         //All other cases we can just return the count
//     }
//
// },
//
// /**
//  * Returns the total number of items at the specified
//  * level.
//  * Level 0 : Questions
//  * Level 1 : Elements
//  * ...
//  * @param state
//  * @param getters
//  */
// getCountOfLevel: ( state, getters ) => ( level ) => {
//     if ( level === 0 ) {
//         //special case because 0,0 is the exam
//         //so we need to subtract 1
//     } else {
//         //All other cases we can just return the count
//     }
//
// },
//
//
// getMappedItem: ( state, getters ) => ( idx ) => {
//     return state.orderMap.get( idx );
// },
//
// // getItemFromOrder: ( state, getters ) => ( idx ) => {
// //     let itm = state.order[ 0 ];
// //     //idx is a tuple stored as an array
// //     for (let i = 0; i < idx.length; i++) {
// //         itm = itm.children[ i ]
// //     }
// //     return itm;
// // },
//
// getItemByIdx: ( state, getters ) => ( idx ) => {
//     let stringKey = Item.buildKeyFromIdx( idx );
//
//     return function ( state, idx ) {
//         var r = state.items.filter( function ( i ) {
//             if ( i.idxStore === stringKey ) {
//                 return i;
//             }
//             return r[ 0 ];
//         } )
//     };
// },
//
//
// getSiblingsAndChildrenByIdx: ( state, getters ) => ( idx ) => {
//     let stringKey = Item.buildKeyFromIdx( idx );
//
//     return function ( state, idx ) {
//         var r = state.items.filter( function ( i ) {
//             if ( _.startsWith( stringKey, idx ) ) {
//                 return i;
//             }
//             return r[ 0 ];
//         } )
//     }
// }

