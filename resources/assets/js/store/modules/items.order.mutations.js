/**
 * Created by adam on 6/12/17.
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

const checkExpectedType = ( toBeSet ) => {
    if ( toBeSet instanceof Node ) return true;

    window.console.log( 'items.order.mutations', 'ERROR', 25, "is not a Node", toBeSet );
    throw new Error( "non node passed to order mutation", toBeSet );
    return false;
};


module.exports = {
    [mTypes.insertNodeIntoOrder]: ( state, payload ) => {
        window.console.log( 'items.order.mutations', 'insertNodeIntoOrder', 21, payload );

        let { index, objNode, parentNode } = payload;

        //type check
        if ( !( checkExpectedType( parentNode ) && checkExpectedType( objNode )) ) {
            //Try out the un type checked properties to see if they have
            //nodes
            let { obj, parent } = payload;
            //if not, oh well
            return false;
        }

        //if an index was specified, splice it in at the index
        if ( !_.isUndefined( index ) ) {
            return parentNode.children.splice( index, 0, objNode );
        }

        //otherwise just push it on the end
        return parentNode.children.push( objNode );

    },


    [mTypes.removeNodeFromOrder]: ( state, payload ) => {
        let { obj, parent } = payload;
        //Merge its children into its parent's children
        parent.children.concat( obj.children );
        //delete the node
        let idx = parent.children.indexOf( obj );
        parent.children.splice( idx, 1 );
    },


    setRootNode: ( state, payload ) => {
        let { objNode, obj } = payload;
        // if ( _.isUndefined(objNode) && obj instanceof Exam ) {
        //     objNode = new Node(obj.serialNumber, obj.serialNumber);
        // }
        //
        // if(_.isUndefined(state.itemMap)){
        //     //we can just put it in
        //     state.itemMap = objNode;
        //  }
        // else{
            //we can just directly update the existing node's serial numbers
            state.itemMap.parent = obj.serialNumber;
            state.itemMap.data = obj.serialNumber;
        // }
        //if it already exists, we need to merge the children
        //of the existing exam node into the new node
//
//         else if((! _.isUndefined(state.itemMap.children)) && state.itemMap.children.length > 0){
//             state.itemMap.parent = children
// ;        }
    }
    /*
     // addMappedItem: ( state, idx, toAdd ) => {
     //     state.orderMap.set( idx, toAdd );
     // },

     //these should probably be methods on node
     //or maybe not since that would make it harder
     //to remove a child without also removing its
     //children (if we want that to be an option)
     //         addChild: ( state, idx, idToAdd ) => {
     //             let child = [ idToAdd, [] ];
     //             let itm = orderList[ 0 ];
     //             //idx is a tuple stored as an array
     //             for (let i = 0; i < idx.length; i++) {
     //                 itm = itm[ 1 ][ i ]
     //             }
     //             let children = itm[ 1 ];
     //             children.push( child );
     //             Vue.set( itm, 1, children );
     //             //
     //             //
     //             // let item = getItemFromList(state.orderList,  idx);
     //             // if (! _.isEmpty(item)){
     //             //     let maxIndex = _.last( Object.keys(item.children));
     //             //     item.children
     //             // }
     //
     //             // let item = getItemFromOrder(state.order,  idx);
     // // if (! _.isEmpty(item)){
     // //     let maxIndex = _.last( Object.keys(item.children));
     // //     item.children
     // // }
     //
     //         },
     //
     //         addParent: ( state, existing, toAdd ) => {
     //
     //         //
     //         },
     // addOlderSibling: ( state, existing, toAdd ) => {
     // },
     // addYoungerSibling: ( state, existing, toAdd ) => {
     // },
     */
//
};
