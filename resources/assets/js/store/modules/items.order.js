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
//
import mutations from './items.order.mutations'
import actions from './items.order.actions'
import getters from './items.order.getters'
import state from './items.order.state'

//
// let mutations  = require( './items.order.mutations');
// let actions  = require('./items.order.actions');
// let getters = require( './items.order.getters');
// let state  = require( './items.order.state');

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
// const actions = orderActions;
// const getters = orderGetters;
// const mutations = orderMutations;
// const state = orderState;

export default {
    actions,
    getters,
    mutations,
    state
}
