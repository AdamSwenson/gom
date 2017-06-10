import * as mTypes from '../../store/mutation-types'
import * as aTypes from '../../store/action-types'
import * as gTypes from '../../store/getter-types'

import Payload from '../../models/Payload'
import Item from '../../models/Item'
import Exam from '../../models/Exam'
import Node from '../../models/Node'
import { traverseDF } from '../../models/NodeTools'

const Vue = require( 'vue' );
const _ = window._ = require( 'lodash' );


import objGetters from './items.getters'
import Orderings from './orderings'

const standardTimeout = 1000;

const helpers = {
    getItemFromPayload( state, payload ){
        return state.items[ payload.index ];
        // if (typeof payload.id !== 'undefined') {
        //     //get the item
        //     var item = state.items.filter(function (i) {
        //         if (typeof i.id != 'undefined' && i.id === id) {
        //             return i;
        //         }
        //     });
        //     return item;
        // } else {
        //     //get the item
        //     return state.items[payload.index];
        // }
    }
};

/**
 * Build an input object out of an input object
 * and return a payload object containing it
 * @param input
 */
const buildPayloadFromInput = ( state, rootState, payload ) => {
    //either a json or an item object have been passed in
    let { ItemId, ItemIndex, obj, ItemObject } = payload;

    obj = typeof ItemObject !== 'undefined' ? ItemObject : obj;

    //check and see if an Item object has already been passed in
    if ( !obj instanceof Item ) {
        //create a new Item
        let { name, id, index } = payload;
        let ItemJson = { name, ItemIndex };
        obj = Item.factory( ItemJson );
    }

    //assemble the expected payload
    // let out = { ItemId: ItemId, ItemIndex: ItemIndex, obj: obj };
    let out = Payload.factory( { id: obj.id, index: obj.index, obj: obj } );
    //Add to the Items store
    return out;
};


/**
 * The older version used an index value to do lots of stuff.
 * Given the prospect of using a websocket connection or connecting
 * to canvas or other 3rd party system, it now makes more sense
 * to use the db's id as the primary locator in the store. Thus
 * state.Items has the Item's database id as key and an Item object
 * as value. That is:
 *      state.Items[Item.id] = Item
 *
 * To maintain compatibility, indexMap holds a mapping from the old
 * ItemIndex to the database id
 */
const state_obj = {

    /**
     * This holds the current item objects.
     * Because we now want maximal flexibility in how we store and
     * retrieve item objects, we store them in a simple list.
     * The access to the items in the last is handled by getters
     * which filter the list on whatever internal property of the item
     * a particular use case needs.
     */
    items: [],

    // items: [ Exam.factory({index: 0}), Item.factory({index: 1}) ],
    /**
     * Mapping from older ItemIndex to new Item id value
     */
    indexMap: new Map(),

    orderMap: {}
};

const state = Object.assign( {}, state_obj, Orderings.state );


/**
 * The make use of both the item object store
 * and the order mapping
 *
 * @type {{getSortedIds: ((p1:*, p2?:*))}}
 */
const getters_both = {
    /**
     * This takes the map of serial numbers in which
     * the ordering is represented and returns a map
     * with ids.
     * The resulting map is used to, inter alia, sync with
     * the server
     * @param state
     * @param getters
     */
    getSortedIds: ( state, getters ) => {
        //get the serial number map
        //we explicitly use the getter rather than
        //just looking in the state because this
        //may well evolve to a different storage
        //behind the scenes
        //We begin by making a copy because we will
        //be altering the data stored
        let map = getters[ gTypes.getItemMapCopy ]( state, getters );
        // window.console.log( 'items', 'getSortedIds', 124, 'map', map);

        let updater = function ( currentNode ) {
            //Look up the id
            let isn = currentNode.data;

            //ignore the exam
            if ( isn === 0 ) return true;

            let item = getters[ gTypes.getItemBySerialNumber ]( state, getters, isn );
            // window.console.log( 'items', 'updater isn item', 144, isn, item);
            if ( !_.isUndefined( item ) ) {
                //we don't check if id is defined.
                //should we????
                currentNode.data = item.id;
                currentNode.dataType = 'id';
                // window.console.log( 'items', 'recurse', 150, currentNode);
            }
        };

        // window.console.log( 'items', 'getSortedIds', 123, map);
        // //transform to ids
        //map is the exam represented as a Node object
        // Doing this depth first
        // this is a recurse and immediately-invoking function
        (function recurse( currentNode ) {
            // window.console.log( 'items', 'recurse', 129, currentNode);
            // step 2
            for (var i = 0; i < currentNode.children.length; i++) {
                // step 3
                recurse( currentNode.children[ i ] );
            }
            window.console.log( 'items', 'recurse', 153, currentNode );
            // step 4
            updater( currentNode );
        })( map );
        return map;
    }
};

const getters = Object.assign( {}, getters_both, objGetters, Orderings.getters ); //, ...g};

window.console.log( 'items', 'getters', 112, getters );
// };

const actions = require( './items.actions' );

const mutations = require( './items.mutations' );

export default {
    actions,
    getters,
    mutations,
    state,
}

// Object indexed by Item id holding Item objects
// On load the root exam object and first item are created but given no
// ids. thus we will eventually need to create an exam object if one isn't set
//
// However don't ask the server to create an id just yet
// lookup the exam object that resides at index 0
// this will have either been newly created on page load
// or it will be an existing exam object loaded from the db
// let exam = this.$store.getters[ gTypes.getActiveExamObj ];
// //Call the set active exam method
// //We do this rather than call the mutation directly
// //because there may need to be various other events and
// //things which need to happen depending on the context.
// //                this.$store.dispatch(aTypes.setActiveExam, Payload.factory({obj: exam}));
// this.$store.getters[ mTypes.setItem ](Payload.factory({index: 0, obj: exam}));
// }