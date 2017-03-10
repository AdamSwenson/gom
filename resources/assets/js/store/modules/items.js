import * as mTypes from '../../store/mutation-types'
import * as aTypes from '../../store/action-types'

import Payload from '../../models/Payload'
import Item from '../../models/Item'

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
     * Object indexed by Item id holding Item objects
     */
    items: [],

    // items: new Map(),
    // itemsRepo: [], // Item.factory( {index: 0} ) ],
    // // items: {},

    /**
     * Mapping from older ItemIndex to new Item id value
     */
    indexMap: new Map()

};

const mutations = {

    /**
     * Push a newly created Item into storage
     *
     * @param state
     * @param rootState
     * @param payload Expecting Item object to be in payload.obj
     */
    [mTypes.addNewItem]: ( state, payload ) => {
        console.log( mTypes.addNewItem, state, payload );
        let len = state.items.length;
        //set the item index
        let index = len == 0 ||1? len : len + 1;
        let item = Item.factory( {index: index} );

        state.items.push( item );
    },

    [mTypes.updateItemName]: ( state, payload ) => {
        console.log( '*****', mTypes.updateItemName, payload, state )
        let itm = state.items[payload.index];
        itm.name = payload.str;
        state.items.$set(payload.index, itm);
        // state.itemNames.$set(payload.index,  payload.str);
    },

    /**
     * Push an Item into storage
     * Payload should have keys: obj
     *
     * @param state
     * @param rootState
     * @param payload Expecting Item object to be in payload.obj
     */
    [mTypes.addItem]: ( state, payload ) => {
        //thi should probably be renamed 'set item' because it is for settong
        //at a certain index, rather than pushing it in at the front
        console.log( 'items.mutations', mTypes.addItem, state, payload );

        // state.itemRepo.$set( payload.obj.index, payload.obj );
        state.items.$set( payload.obj.index, payload.obj );

        //If we received an item by itself, wrap it in a payload
        // //no idea why I decided to permit this....
        // if ( payload instanceof Item ) {
        //     payload = Payload.factory( {obj: payload} );
        // }
        //
        // //at this point, when the button has been clicked,
        // //there is an index (or at least question number/subtask
        // //but not an id
        // if ( Payload.checkIfPayload( payload ) && payload.obj instanceof Item ) {
        //     //push into Items storage
        //     state.items.set(payload.obj.index , payload.obj);
        //     // state.items[ payload.obj.index ] = payload.obj;
        // }

        //todo add error handling
    },


    [mTypes.updateItemNameByIndex]: ( state, payload ) => {
        console.log( '*****', 'updateItemNameByIndex', state , payload)
        //state.itemNames.$set(payload.index,  payload.str);
    },

    /**
     * Pushes a mapping of index to id into indexMap
     * Payload should have keys: ItemIndex, ItemId
     *
     * @param state
     * @param rootState
     * @param payload Array with keys: ItemIndex, ItemId
     */
    [mTypes.addItemIndexMapping]: ( state, rootState, payload ) => {
        Payload.checkIfPayload( payload );

        state.indexMap.set( payload.index, payload.id );
    },

    // /**
    //  * Consume a json object and populate the Items object
    //  * by overwriting it.
    //  * @param state
    //  * @param rootState
    //  * @param payload
    //  */
    // [mTypes.loadItems]: ( state, rootState, payload ) => {
    //     Payload.checkIfPayload( payload );
    //     //add Items
    //     state.items = payload.obj;
    // }

};


/**
 * Build an input object and return a payload object
 * containing it
 */
const createItemExNihlo = ( state ) => {
    //nothing was passed in.
    //This probably means the add new item button was clicked
    // let len = getters.getNumberOfItems( state, {}, {} ) + 1 || 0
    let len = state.items.length;
    let index = len == 0 ? len : len + 1;

    let obj = Item.factory( {index: index} );
    let out = Payload.factory( {obj: obj} );
    return out;
};

/**
 * Build an input object out of an input object
 * and return a payload object containing it
 * @param input
 */
const buildPayloadFromInput = ( state, rootState, payload ) => {
    //either a json or an item object have been passed in
    let {ItemId, ItemIndex, obj, ItemObject} = payload;

    obj = typeof ItemObject != 'undefined' ? ItemObject : obj;

    //check and see if an Item object has already been passed in
    if ( !obj instanceof Item ) {
        //create a new Item
        let {name, id, index} = payload;
        let ItemJson = {name, ItemIndex};
        obj = Item.factory( ItemJson );
    }

    //assemble the expected payload
    // let out = { ItemId: ItemId, ItemIndex: ItemIndex, obj: obj };
    let out = Payload.factory( {id: obj.id, index: obj.index, obj: obj} );
    //Add to the Items store
    return out;
};

const actions = {
    /**
     * Called when a brand new item needs to be created and inserted into
     * the store.
     *
     * @param state
     * @param commit
     */
    [aTypes.createItem]: ( {state, commit} ) => {
        commit( mTypes.addNewItem );
    },
//
//     [aTypes.updateItemName]: ({state, commit}, payload)=>{
// let {index, str} = payload;
// commit()
//     },


    /**
     * Adds the Item in the payload to the store. Also
     * adds the Item index to the indexMap so can look up
     * the id for older components.
     * @param state
     * @param commit
     * @param payload Keys: ItemId, ItemIndex, obj
     */
    [aTypes.addNewItem]: ( {state, commit}, payload ) => {
        let len = state.items.length;
        let index = len == 0 ? len : len + 1;

        let obj = Item.factory( {index: index} );
        let out = Payload.factory( {obj: obj} );
       // commit( mTypes.addItem, out );
        commit( mTypes.addNewItem );

        // let out = createItemExNihlo( state );
        // // (typeof payload != 'undefined') ? this.buildPayloadFromInput(payload) : createItemExNihlo(state);
        // console.log( 'addNewItem out', out );
        //
        // if ( typeof out != 'undefined' && Payload.checkIfPayload(out)) {
        //     console.log( 'addNewItem != undefined ', out );
        //     commit( mTypes.addItem, out );
        //     //Add to the mapping store
        //     // commit( mTypes.addIndexMapping, out );
        // }
    },

    /**
     * Consume a json object and populate the Items store
     * by pushing Items into it.
     * @param state
     * @param rootState
     * @param payload
     */
    [aTypes.loadItems]: ( state, rootState, payload ) => {
        //check if payload has correct structure
        //todo

        //push each record from the payload into the store
        for ( let i = 0; i < payload.length; i++ ) {
            let record = payload[ i ];
            //check if record has correct structure
            //todo

            //add to Items and add index mapping
            [ aTypes.addNewItem ]( state, rootState, record );
        }
    }

};

const getters = {
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
    getItem: ( state, getters, rootState, payload ) => {
        let index;

        //room for other ways of finding index
        index = payload.index;

        // return state.items[index];
        console.log( 'getItem', payload );
        return state.items[ index ];
    },


    /**
     * Returns the item object with the given index
     * @param state
     * @param getters
     * @param rootState
     * @param index
     */
    getItemByIndex: ( state, getters ) => ( index ) => {
        console.log( 'getItemByIndex', state, index );

        return function ( state, index ) {
            var r = state.items.filter( function ( i ) {
                if ( i.index === index ) {
                    return i;
                }
            } );
            return r[ 0 ];
        }( state, index )
    },


    /**
     * Returns list of items objects
     * @param state
     * @param getters
     * @param payload
     * @returns []
     */
    getAllItems: ( state, getters, rootState ) => {
        return state.items;
        // return state.items.entries()
    },

    getAllIndexesList: ( state, getters, rootState, payload ) => {
        let out = [];
        for ( let [ key, val ] of state.items.entries() ) {
            console.log( 'getall idexes itemslist', key, val );
            out.push( key );
        }
        return out;
    },


    /**
     * Return list of Item objects
     * @param state
     * @param getters
     * @param payload
     * @returns []
     */
    getAllItemsList: ( state, getters ) => ( items ) => {
        let out = [];
        // if ( state.items.size > 0 ) {
        for ( let [ key, val ] of items.entries() ) {
            // for ( let [ key, val ] of state.items.entries() ) {
            console.log( 'getallitemslist', key, val );
            out.push( val );
        }
        // }
        return out;
    },

    getItemCount: ( state ) => {
        return state.itemsRepo.length;
    },

    /**
     * Returns the current count of items
     * @param state
     * @param getters
     * @param payload
     * @returns {Number}
     */
    getNumberOfItems: ( state, getters ) => ( items) => {
        // return items.size;
        return items.length;
        // return Object.keys( state.items ).length || 0;
    },

    /**
     * Returns the highest index value
     * @param state
     * @param getters
     * @param payload
     */
    getMaxIndex: ( state, getters, payload ) => {
        //   return Object.keys( state.items ).max || 0;
    }
};

export default {
    actions,
    getters,
    mutations,
    state,
}