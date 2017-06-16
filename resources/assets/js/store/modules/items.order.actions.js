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


// let orderMutations  = require( './items.order.mutations');
// import actions from './items.order.actions';
//
// import getters from  './items.order.getters';
// let orderState  = require( './items.order.state');

// import getters from './items.order.getters'
// import actions from './items.order.actions'

module.exports = {
    [aTypes.addItemToOrder]: ( { state, dispatch, commit, getters }, payload ) => {
        let { index, obj, id, parent } = payload;

        //Sort out whether obj and parent are nodes or items
        let toAddSerialNumber = getSerialNumber(obj);
        let parentSerialNumber = getSerialNumber(parent)
        let n = new Node(toAddSerialNumber, parentSerialNumber );

        let f = function ( currentNode ) {
            if ( currentNode.data === parentSerialNumber ) {
                let pl = Payload.factory( { index: index, obj: n, parent: currentNode } );

                commit( mTypes.insertNodeIntoOrder, pl );
                return false;
            }
            return true;
        }

        traverseDF( state.itemMap, f );

    },

    [aTypes.removeItemFromOrder]: ( { state, dispatch, commit, getters }, payload ) => {
        let {serialNumber} = payload;
        // let  serialNumber = getSerialNumber(payload);
        let toRemove = getters[ gTypes.getItemNodeFromOrder ]( serialNumber );
        let parent = getters[ gTypes.getItemNodeFromOrder ]( toRemove.parent );
        let pl = Payload.factory( { obj: toRemove, parent: parent } );
        commit( mTypes.removeNodeFromOrder, pl );
    },

};
