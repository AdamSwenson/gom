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
import { traverseDF, traverseBF, getSerialNumber, getNode } from '../../models/NodeTools'

module.exports = {

    /**
     * Returns the children array of
     * the exam stored as itemMap. It includes the exam
     * @param state
     * @param getters
     * @returns {Node}
     */
    [ gTypes.getItemMapCopy ]: ( state, getters ) => {
        return Object.assign( new Node(), state.itemMap );// ['parent','data', 'dataType', 'children']);
    },

    /**
     * Returns a node representation of an item
     * Does not return an item object
     * @param state
     * @param getters
     * @param rootState
     * @param serialNumber
     */
    [ gTypes.getItemNodeFromOrder ]: ( state, getters, rootState, serialNumber ) => ( serialNumber ) => {

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
            traverseDF( state.itemMap, callback );
            return callback.found[ 0 ];

        })( state, serialNumber )

        //    return state.itemMap ? getNode(state, serialNumber) : null;
    },

    /**
     * Find the number of parents the node has
     * @param state
     * @param getters
     * @param serialNumber
     */
    [ gTypes.getHeightOfNode ]: ( state, getters, rootState, serialNumber ) => ( serialNumber ) => {
        // return 1;
        // [gTypes.getHeightOfNode]: ( state, getters) => ( serialNumber ) => {
        return (function ( state, serialNumber ) {

            let level = 0;

            let node = getNode( state, serialNumber );
            if ( node ) {
                while (node.parent !== node.data) {
                    let parent = node.parent;
                    //get the parent node
                    //set it as node so that we operate on it next time
                    node = getNode( state, parent );
                    //increment level
                    level += 1;
                }
            }
            return level;
        })( state, serialNumber );
        //
        //
        // return (function recurse( serialNumber ) {
        //     // window.console.log( 'items.order', 'recurse', 245, serialNumber, level);
        //     //look up the node whose serial number we've just  been handed.
        //     let node = getters[ gTypes.getItemNodeFromOrder ](state, getters, serialNumber);
        //     //break condition is that we've hit the exam
        //     //which is of course the only item which is its
        //     //own parent
        //     if ( node.parent === node.data ) return level;
        //     //Otherwise, increment the level counter
        //     // and re-run on the parent
        //     level += 1;
        //     return recurse( node.parent );
        // })( serialNumber );
    },

    /**
     * Find the index position of the node in its parent's children array
     * @param state
     * @param getters
     * @param serialNumber
     */
    [ gTypes.getDepthOfNode ]: ( state, getters, rootState, serialNumber ) => ( serialNumber ) => {
        //look up the node whose serial number we've just  been handed.
        let node = getNode( state, serialNumber );
//        let node = getters[ gTypes.getItemNodeFromOrder ](state, getters, serialNumber);
        if ( node ) {
            let parent = getNode( state, node.parent );
            // let parent = getters[ gTypes.getItemNodeFromOrder ](state, getters, node.parent);
            if ( parent ) {
                for (let index = 0; index < parent.children.length; index++) {
                    if ( parent.children[ index ].data === node.data ) {
                        return index;
                    }
                }
            }
        }
        return 0;
    },

    getRootNode: ( state, getters, rootState ) => {
        return state.itemMap;
    },

    getRootNodeSerialNumber: ( state, getters, rootState ) => {
        return state.itemMap.data;
    },

    /**
     * Returns item objects which have only the exam
     * as a parent.
     * DOES NOT RETURN NODES
     * @param state
     * @param getters
     * @returns {Array}
     */
    getQuestionLevelItems: ( state, getters ) => {
        let items = [];
        if ( state.itemMap.children ) {
            _.forEach( state.itemMap.children, function ( node ) {
                items.push( getters[ gTypes.getItemBySerialNumber ]( node.data ) );
            } );
        }
        return items;
    },

    /**
     * Given an item object, this first looks up the
     * related node and then returns item objects for
     * each of its children.
     * DOES NOT RETURN NODES
     * @param state
     * @param getters
     * @param rootState
     * @param item
     * @returns {function(*)}
     */
    getItemChildren: ( state, getters, rootState, item ) => ( item ) => {

        let kids = [];
        let node = getters[ gTypes.getItemNodeFromOrder ]( item.serialNumber );

        if ( node.children.length > 0 ) {
            _.forEach( node.children, function ( child ) {
                if(child.data){
                    let o = getters[ gTypes.getItemBySerialNumber]( child.data ) ;
                    kids.push( o );
                }
            } );
        }
        return kids;
    }


};
