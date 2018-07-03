/**
 * Created by adam on 6/12/17.
 */

const _ = window._ = require( 'lodash' );
const Vue = require( 'vue' );

import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types'

import Payload from '../../../models/Payload'
import Item from '../../../models/Item'
import Exam from '../../../models/Exam'
import Node from '../../../models/Node'

import { getNode } from '../../../models/NodeTools'

const checkExpectedType = ( toBeSet ) => {
    if ( toBeSet instanceof Node ) return true;

    window.console.log( 'items.order.mutations', 'ERROR', 25, "is not a Node", toBeSet );
    throw new Error( "non node passed to order mutation", toBeSet );
    return false;
};


module.exports = {

    [ mTypes.insertNodeIntoOrder ]: ( state, payload ) => {
        let obj, parent, index;
        // window.console.log( 'items.order.mutations', 'insertNodeIntoOrder', 21, payload );
        try {
            //the payload may have the data stored as either objNode or obj
            //and parentNode or parent.
            let { index, objNode, parentNode } = payload;
            checkExpectedType( parentNode )
            checkExpectedType( objNode )
            obj = objNode;
            parent = parentNode;
        } catch (e) {
            obj = payload.obj;
            parent = payload.parent;
        }

        //if an index was specified, splice it in at the index
        if ( !_.isUndefined( index ) ) {
            parent.children.splice( index, 0, obj );
        }else{
            //otherwise just push it on the end
            parent.children.push( obj );
        }
    },


    [ mTypes.removeNodeFromOrder ]: ( state, payload ) => {
        let { obj, parent } = payload;
        //Merge its children into its parent's children
        parent.children.concat( obj.children );
        //delete the node
        let idx = parent.children.indexOf( obj );
        parent.children.splice( idx, 1 );
    },

    increasePosition: ( state, payload ) => {
        let { objNode, parentNode } = payload;

        let currentIndex = parentNode.children.indexOf( objNode )
        // if ( currentIndex + 1 === parentNode.children.length ) return true;
        //
        // //make sure it is not the last item already
        // if ( parentNode.children.length !== currentIndex + 1 ) {
        //We first pop the item out so that its successor
        //slides down and occupies its current index
        parentNode.children.splice( currentIndex, 1 );
        //Now we push it in at  its
        //original position + 1
        parentNode.children.splice( currentIndex - 1, 0, objNode );
        // }
    },

    /**
     * Moves the item down in the order of its siblings
     * So if x was at Q2E3, after this it would be
     * at Q2E4 and the item previously at E4 would be at E3.
     *
     * @param state
     * @param payload
     */
    decreasePosition: ( state, payload ) => {
        let { objNode, parentNode } = payload;
        let currentIndex = parentNode.children.indexOf( objNode )
        //check whether at the end of the children list
        //if so, ignore the call
        //   if ( currentIndex === 0 ) return true;

        //We first pop the item out so that its successor
        //slides down and occupies its current index
        //Now we push it in at  its
        //original position -1 1
        parentNode.children.splice( currentIndex, 1 ); //remove it
        parentNode.children.splice( currentIndex + 1, 0, objNode ); //push it in

    },

    /**
     * Make the item a sibling of its parent
     * @param state
     * @param payload
     */
    promote: ( state, payload ) => {
        //where it makes no sense to promote
        let { objNode, parentNode } = payload;
        //get parent's parent
        if ( parentNode instanceof Node ) {
            let grandParent = getNode( state, parentNode.parent );

            //check that we aren't at the question level
            // if ( grandParent ) {
            //add to grandparent
            grandParent.children.push( objNode );

            //remove from parent's children list
            parentNode.children.splice( parentNode.children.indexOf( objNode ), 1 );
            // }
        }


    },

    demote: ( state, payload ) => {
        let { objNode, parentNode } = payload;
        let currentIndex = parentNode.children.indexOf( objNode );
        //get the node who will become parent
        let newParent = parentNode.children[ currentIndex - 1 ];
        //remove from parent
        parentNode.children.splice( currentIndex, 1 ); //remove it
        //push it in to its former older sibling's children
        newParent.children.push( objNode );
    },

    //
    // initializeItemStore: ( state ) => {
    //     return new Promise( function ( resolve, reject ) {
    //         let exam = new Exam();
    //         state.items[ 0 ] = exam;
    //         state.itemMap = new Node( exam.serialNumber, exam.serialNumber );
    //         resolve();
    //     } );
    // },

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
