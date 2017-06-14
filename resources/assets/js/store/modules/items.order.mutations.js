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


module.exports = {
    [mTypes.insertNodeIntoOrder]: ( state, payload ) => {
            let { index, obj, parent } = payload;

            //type check
            if ( !parent instanceof Node ) return false;
            if ( !obj instanceof Node ) return false;

            //if an index was specified, splice it in at the index
            if ( !_.isUndefined( index ) ) {
                return parent.children.splice( index, 0, obj );
            }
            //otherwise just push it on the end
            return parent.children.push( obj );

        },


        [mTypes.removeNodeFromOrder]: ( state, payload ) => {
            let { obj, parent } = payload;
            //Merge its children into its parent's children
            parent.children.concat( obj.children );
            //delete the node
            let idx = parent.children.indexOf( obj );
            parent.children.splice( idx, 1 );
        },

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
