/**
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


import {traverseDF, traverseBF} from '../../../../../resources/assets/js/models/NodeTools'



// const traverseDF = ( root, callback ) => {
//     let stillLooking = true;
//
//     // this is a recurse and immediately-invoking function
//     (function recurse( currentNode ) {
//         // while(stillLooking) {
//         // step 2
//         for (var i = 0, length = currentNode.children.length; i < length; i++) {
//             if ( callback( currentNode ) ) {
//                 return currentNode;
//             } else {
//
//                 // step 3
//                 recurse( currentNode.children[ i ] );
//             }
//
//         }
//         // }
//         // window.console.log( 'orderings', 'recurse', 47, callback(currentNode));
//         // step 4
//         if ( callback( currentNode ) ) {
//             // window.console.log( 'orderings', 'recurse', 50, 'FOUND IT!', currentNode );
//             stillLooking = false;
//             return currentNode;
//         }
//
//         // step 1
//     })( root );
//
// };

// const traverseBF = ( root, callback ) => {
//     var queue = [];
//     queue.push( root );
//     let currentTree = queue.pop();
//
//     while (currentTree) {
//         for (var i = 0, length = currentTree.children.length; i < length; i++) {
//             queue.push( currentTree.children[ i ] );
//         }
//
//         callback( currentTree );
//         currentTree = queue.pop();
//     }
// };


const state = {
    itemMap: new Node( 0, 0 ),

    /*
     * What we want to have is the ability to store nested
     * tuples which map the item to a position on an exam
     * (which is itself formally an item).
     * order : {
     *      0 : {
     *          id: null,
     *          children: {
     *              0 : {
     *                      id: null.
     *                      children: {}
     *                 }
     *          }
     *      }
     }
     *
     * */
    //the first value in the array is the item's id
    //the second value is an array of children
    // orderMap: new Map(),
    // orderList: [],
    //
    // order: {
    //     0: {
    //         id: null,
    //         children: {
    //             0: {
    //                 id: null,
    //                 children: {}
    //             }
    //         }
    //     }
    // }
    // orderMap: new Map(),
    // order: {}

};

const mutations = {
    add: ( state, payload ) => {
        //we will have to find the parent
        //then add the new node to its children

        let { parent, obj } = payload;
        let { serialNumber } = obj;

        let n = new Node( serialNumber, parent.serialNumber );

        if ( state.itemMap.data === parent.serialNumber ) {
            state.itemMap.children.push( n );
        } else {


            state.itemMap.children.filter( function ( node ) {
                if ( node.serialNumber === parent.SerialNumber ) {
                    node.children.push( n );
                    return true;
                }
            } );
        }
        //
        //
        // if ( !_.isUndefined( index ) ) {
        //     //we are supposed to put the item
        //     //in a particular location
        //     state.itemMap.children[ index ] = n;
        // } else {
        //     //we are supposed to append it on the
        //     //last item or somehow devine location
        // }

    },


    remove: ( state, payload ) => {
        let { toRemove, parent } = payload;
        //Merge its children into its parent's children
        parent.children.concat( toRemove.children );
        //delete the node
        toRemove.destroy();

    },


    addMappedItem: ( state, idx, toAdd ) => {
        state.orderMap.set( idx, toAdd );
    },

    addChild: ( state, idx, idToAdd ) => {
        let child = [ idToAdd, [] ];
        let itm = orderList[ 0 ];
        //idx is a tuple stored as an array
        for (let i = 0; i < idx.length; i++) {
            itm = itm[ 1 ][ i ]
        }
        let children = itm[ 1 ];
        children.push( child );
        Vue.set( itm, 1, children );
        //
        //
        // let item = getItemFromList(state.orderList,  idx);
        // if (! _.isEmpty(item)){
        //     let maxIndex = _.last( Object.keys(item.children));
        //     item.children
        // }

        // let item = getItemFromOrder(state.order,  idx);
// if (! _.isEmpty(item)){
//     let maxIndex = _.last( Object.keys(item.children));
//     item.children
// }

    },

    addParent: ( state, existing, toAdd ) => {


    },
    addOlderSibling: ( state, existing, toAdd ) => {
    },
    addYoungerSibling: ( state, existing, toAdd ) => {
    },

    //
};

const actions = {

    //only these can call the mutations.
    //so there needs to be one for each mutation


    addItem: ( { state, dispatch, commit, getters }, payload ) => {
        let { index, obj } = payload;
        let { serialNumber } = obj;
        let n = new Node( serialNumber );
        if ( !_.isUndefined( index ) ) {
            //we are supposed to put the item
            //in a particular location
            state.itemMap.children[ index ] = n;
        } else {
            //we are supposed to append it on the
            //last item or somehow devine location
        }

    },
    removeItem: ( { state, dispatch, commit, getters }, payload ) => {
    },

};

const getters = {

    /**
     * Returns the children array of
     * the exam stored as itemMap. It includes the exam
     * @param state
     * @param getters
     * @returns {Node}
     */
    [gTypes.getItemMapCopy]: (state, getters)=>{
        return Object.assign(new Node(), state.itemMap);// ['parent','data', 'dataType', 'children']);
    },

    getItemNodeFromOrder: ( state, getters, serialNumber ) => {
        return (function ( state, serialNumber ) {
            let callback = function ( node ) {
                if ( !callback.found ) callback.found = [];
                // window.console.log( 'orderings', 'callback', 253, node.data, serialNumber );
                if ( node.data === serialNumber ) {
                    callback.found.push( node );
                    // window.console.log( 'orderings.spec', 'callback.found', 78, node, callback.found );
                    return true;
                }
                return false;
            };
            traverseBF( state.itemMap, callback );
            let result = callback.found[ 0 ];
            return result;
        })( state, serialNumber )
    }


};


//     return function ( state, serialNumber ) {
//         var r = state.itemMap.children.filter( function ( i ) {
//             if ( i.data === serialNumber ) {
//                 return i;
//             }
//         } );
//         return r[ 0 ];
//     }( state, serialNumber )
// },
//
// return (( serialNumber ) => {
//     window.console.log( 'qqqqqq', 'jjjj', 249, serialNumber );
//     return state.itemMap.filter( ( serialNumber ) => {
//         state.itemMap.forEach( ( itemNode ) => {
//             if ( itemNode.data === serialNumber ) {
//                 return itemNode;
//             }
//         } );
//     } );
// })( serialNumber );


//
// let callback = function( node ) {
//     if ( ! callback.found ) callback.found = [];
//
//     if ( node.data === serialNumber ){
//         callback.found.push(node);
//     }
// };
//
// traverseDF( state.itemMap, callback );
// // if(callback.found.length > 0){
// //
// //     let item = getters.getItemBySerialNumber()
// // }
// //
// let result = callback.found.length >0 ? callback.found[0] : null;
// window.console.log( 'orderings', 'callback.found', 258, result);
//
// return result;


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


export default {
    actions,
    getters,
    mutations,
    state,
    traverseBF,
    traverseDF
}