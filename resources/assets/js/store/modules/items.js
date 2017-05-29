import * as mTypes from '../../store/mutation-types'
import * as aTypes from '../../store/action-types'
import * as gTypes from '../../store/getter-types'

import Payload from '../../models/Payload'
import Item from '../../models/Item'
import Exam from '../../models/Exam'

const Vue = require( 'vue' );

const _ = window._ = require( 'lodash' );


const standardTimeout = 1000;

const buildKey = ( idx ) => {
    var k = '';
    for (var i = 0; i < idx.length; i++) {
        k += idx[ i ];
        if ( i <= idx.length - 2 ) {
            k += '-';
        }
    }
    return k;
};

const isItemsEmpty = ( state ) => {
    if ( state.items.length > 0 ) {
        return false;
    }
    return true;
};

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
const state = {

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



const getters = {
    getSortedIds: ( state, getters ) => {
        let ids = [];
        if ( state.items.length > 0 ) {
            state.items.forEach( ( i ) => {
                ids.push( i.id );
            } );
        }
        return ids;
    },
    // getMappedItem : (state, getters) => (payload)=>{
    //
    //     let key = buildKey(idx);
    //     return state.orderMap[key];
    // },

    /**
     * Returns the desired Item object
     * Payload can have any of the following identifiers,
     * used in descending order:
     *      ItemId,
     *      ItemIndex
     *      todo Add others
     * @param state
     * @param getters
     * @param payload Object containing Item identifier
     */
    getItem: ( state, getters ) => ( payload ) => {
        // [gTypes.getItem ]: ( state, getters, payload ) => {
        // console.log('getItem', state, payload);
        if ( isItemsEmpty( state ) ) return false;
        if ( Payload.checkIfPayload( payload ) ) {
            let { index, id } = payload;
            if ( typeof index !== 'undefined' ) {
                return getters.getItemByIndex( state, getters, index );
            }
            if ( typeof id !== 'undefined' ) {
                return getters.getItemById( state, getters, id );
            }
        }
    },


    /**
     * Returns the item object residing at the
     * given index in the list.
     * This does not guarantee
     * that the item.index property will equal the
     * list index. That could happen if updateOrder has not
     * yet run.
     * @param state
     * @param getters
     * @param index
     */
    getItemByIndex: ( state, getters ) => ( index ) => {
        //remove the payload wrapper if necessary
        if ( Payload.checkIfPayload( index ) ) {
            index = index.index;
        }

        //if this is a single member array, we can treat
        //it like a numeric input under the older system
        if ( _.isArray( index ) && index.length === 1 ) {
            index = index[ 0 ];
        }

        //Now we're ready to deal with the input
        return function ( state, index ) {
            //There are two cases to consider
            //We deal first with the easy case in which the index
            //is a number or string representation of a number
            //and not a composite
            if ( !_.isArray( index ) ) {
                //if was just a string or integer this is fine
                //also if the input was an array with only one item
                var r = state.items.filter( function ( i ) {
                    if ( i.index === index ) {
                        return i;
                    }
                } );
                return r[ 0 ];
            }

            else {
                //we need to do something different
                //because it is an array
                if ( _.isArray( index ) ) {
                    let idx = index.join( '-' );
                }

            }

        }( state, index );

    },

    /**
     * Returns the item object with the given id.
     * This is the preferred way of looking up objects.
     * It is immutable across re-sorting and corresponds with
     * the stored db value.
     * Getting an object by this does not guarantee
     * that the item.index property will equal the
     * list index. That could happen if updateOrder has not
     * yet run.
     * @param state
     * @param getters
     * @param rootState
     * @param index
     */
    getItemById: ( state, getters ) => ( id ) => {
        // [gTypes.getItemById]: ( state, getters ) => ( id ) => {
        // console.log('getItemById', state, id);
        return function ( state, id ) {
            var r = state.items.filter( function ( i ) {
                if ( i.id === id ) {
                    return i;
                }
            } );
            return r[ 0 ];
        }( state, id )

    },


    /**
     * Returns all stored item objects in whatever
     * data structure is housing them.
     * Note: because of adam's flakiness on committing to
     * a data structure, this may not be stable in its output
     * @param state
     * @param getters
     * @param rootState
     * @returns []
     */
    getAllItems: ( state, getters, rootState ) => {
        // [gTypes.getAllItems] : ( state, getters, rootState ) => {
        return state.items;
    },

    getSortedItems: ( state ) => {

    },

    /**
     * This returns the indexes stored in each item in a list.
     * NB, these may not correspond with the index of each item's location in state.items
     * To retrieve the indexes of state.items list holding items, use getAllIndexesList
     * @param state
     * @param getters
     * @param rootState
     */
    getAllItemIndexes: ( state, getters, rootState ) => {
        let out = [];
        for (let item in state.items) {
            out.push( item.index );
        }
        return out;
    },

    /**
     * Returns the list indexes of the items in state.items
     * NB, This does not return the indexes which are stored in each
     * item. That is retrieved via getAllItemIndexes
     * @param state
     * @param getters
     * @param rootState
     * @returns {Array}
     */
    getAllIndexesList: ( state, getters, rootState ) => {
        if ( isItemsEmpty( state ) ) return []
        // [gTypes.getAllIndexesList ]: ( state, getters, rootState, payload ) => {

        let out = [];
        for (let [ key, val ] of state.items) {
            out.push( key );
        }
        return out;

        //Leaving this here, in case someday we go back to items being an object
        // return Object.keys( state.items )
    },


    /**
     * Return list of Item objects
     * @param state
     * @param getters
     * @param payload
     * @returns []
     */
    getAllItemsList: ( state, getters ) => ( items ) => {

        // [gTypes.getAllItemsList ]: ( state, getters ) => ( items ) => {
        let out = [];
        // if ( state.items.size > 0 ) {
        for (let [ key, val ] of items) {
            // for ( let [ key, val ] of state.items.entries() ) {
            // console.log( 'getAllItemsList', key, val );
            out.push( val );
        }
        // }
        return out;
    },

    /**
     * Returns the current count of items
     * @param state
     * @param getters
     * @param payload
     * @returns {Number}
     */
    getItemCount: ( state, getters ) => {
        // [gTypes.getItemCount]: ( state, getters ) => {
        return state.items.length;
    },

    /**
     * Returns the current maximum index value from
     * the stored items
     * @param state
     * @param getters
     */
    getMaxIndexValue: ( state, getters ) => {

    },

    getNextIndex: ( state, getters ) => {
        return _.sortedIndex( state.items );

    },

    /**
     * Poorly named shortcut for getting the currently active exam.
     * @param state
     */
    currentExam: ( state ) => {
        return state.items[ 0 ];
    }


};

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