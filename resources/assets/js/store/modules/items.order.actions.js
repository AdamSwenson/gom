/**
 * Created by adam on 6/12/17.
 */


const _ = window._ = require( 'lodash' );
// const Vue = require( 'vue' );

import * as mTypes from '../../store/mutation-types'
import * as aTypes from '../../store/action-types'
import * as gTypes from '../../store/getter-types'

import Payload from '../../models/Payload'
import Item from '../../models/Item'
import Exam from '../../models/Exam'
import Node from '../../models/Node'
import { traverseDF, traverseBF, getSerialNumber } from '../../models/NodeTools'


module.exports = {
    [aTypes.addItemToOrder]: ( { state, dispatch, commit, getters }, payload ) => {
        window.console.log( 'items.order.actions', 'pppp', 31, payload );
        return new Promise( ( resolve, reject ) => {

            let { obj, parent, index, mutateSilently } = payload;

            //Sort out whether obj and parent are nodes or items
            let toAddSerialNumber = obj.serialNumber; // getSerialNumber( obj );
            let parentSerialNumber = _.isNumber( parent ) ? parent : getSerialNumber( parent );
            // window.console.log( 'items.order.actions', 'psn', 39,payload, parent, parentSerialNumber );

            let newNode = new Node( toAddSerialNumber, parentSerialNumber );
            let parentNode = getters.getItemNodeFromOrder( parentSerialNumber );
            // window.console.log( 'items.order.actions', 'n', 39, newNode, parentNode );


            let pl = Payload.factory( {
                objNode: newNode,
                parentNode: parentNode,
                index: index,
                mutateSilently: mutateSilently
            } );
            // window.console.log( 'items.order.actions', 'pl', 47, pl );

            commit( mTypes.insertNodeIntoOrder, pl );

            resolve();

        } );
    },
    //
    // let f = function ( currentNode ) {
    //     window.console.log( 'items.order.actions', 'f', 44, currentNode.data, parentSerialNumber);
    //     if ( currentNode.data === parentSerialNumber ) {
    //         // let pl = Payload.factory( { obj: n, parent: currentNode } );
    //         //
    //         // window.console.log( 'items.order.actions', 'found it', 44, currentNode.data, parentSerialNumber);
    //         // commit( mTypes.insertNodeIntoOrder, pl );
    //         return true;
    //     }
    //     return false;
    // }

    // let parentNode = traverseDF( state.itemMap, f );


    [aTypes.removeItemFromOrder]: ( { state, dispatch, commit, getters }, payload ) => {
        let { serialNumber } = payload;
        // let  serialNumber = getSerialNumber(payload);
        let toRemove = getters[ gTypes.getItemNodeFromOrder ]( serialNumber );
        let parent = getters[ gTypes.getItemNodeFromOrder ]( toRemove.parent );
        let pl = Payload.factory( { obj: toRemove, parent: parent } );
        commit( mTypes.removeNodeFromOrder, pl );
    },

};
