import * as mTypes from '../../store/mutation-types'
import * as aTypes from '../../store/action-types'
import Payload from '../../models/Payload'
import Item from '../../models/Item'
const Vue = require( 'vue' );



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

    myList: [],

    /**
     * Mapping from older ItemIndex to new Item id value
     */
    indexMap: new Map()
};

const helpers = {
    getItemFromPayload(state, payload){
        if(typeof payload.id != 'undefined'){
            //get the item
            var item = state.items.filter( function ( i ) {
                if ( i.id === id ) { return i; }
            } );
            return item;
        }else{
            //get the item
            return state.items[ payload.index ];
        }
    }
}

const mutations = {
    
    [mTypes.updateOrder]: (state, payload) =>{
        console.log( mTypes.updateOrder, state, payload );

        //this just requires us to match list indexes w the
        //property of the item
        for(let i=0; i<state.items.length; i++){
            let item = state.items[i];
            //set the property on the object
            Vue.set(item, 'index', i);
            //set it in the array with vue
            state.items.$set(i, item);
        }
    },

    /**
     * Creates a new item and pushes it into storage
     *
     * @param state
     * @param rootState
     * @param payload Expecting Item object to be in payload.obj
     */
    [mTypes.addNewItem]: ( state, payload ) => {
        console.log( mTypes.addNewItem, state, payload );
        let len = state.items.length;
        //set the item index
        let index = len == 0 || 1 ? len : len + 1;
        let item = Item.factory( {id: index, index: index} );
        Vue.set( item, 'index', index );
        state.items.$set( index, item );
    },


    /**
     * Alters the the property named in updateProp to have the
     * the value set in updateVal
     * @param state
     * @param payload
     */
    [mTypes.updateItem]: ( state, payload ) => {
        console.log( mTypes.updateItem, payload, state )
let itm = helpers.getItemFromPayload(state, payload)

        //Set the value so vue can see it
        Vue.set( itm, payload.updateProp, payload.updateVal );
        //Push the altered item back into the array
        state.items.$set( payload.index, itm );
    },

    /**
     * Alters the the property named in updateProp to have the
     * the value set in updateVal
     * @param state
     * @param payload
     */
    [mTypes.updateComment]: ( state, payload ) => {
        console.log( mTypes.updateComment, payload, state )
        //get the item
        let itm = helpers.getItemFromPayload(state, payload)
        // let itm = state.items[ payload.index ];
        let comment = itm.getComment( payload.updateValence );

        if ( typeof comment != 'undefined' ) {
            //Set the value so vue can see it
            Vue.set( comment, 'text', payload.updateVal );
        }

        //Push the altered item back into the array
        state.items.$set( payload.index, itm );
    },


    /**
     * Push an Item into storage at a particular index
     * Payload should have keys: obj, index
     *
     * @param state
     * @param rootState
     * @param payload Expecting Item object to be in payload.obj
     */
    [mTypes.setItem]: ( state, payload ) => {
        console.log( 'items.mutations', mTypes.setItem, state, payload );
        state.items.$set( payload.obj.index, payload.obj );
    },

    /**
     * Makes an item into sibling of others by decreasing
     * its depth
     * @param state
     * @param payload
     */
    [mTypes.promoteItem]: ( state, payload ) => {
        let {index} = payload;
        let item = state.items[ index ];
        item.promote();
    },

    /**
     * Makes an item into a child of others by
     * increasing its depth
     * @param state
     * @param payload
     */
    [mTypes.demoteItem]: ( state, payload ) => {
        let {index} = payload;
        let item = state.items[ index ];
        item.demote();
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
     * This handles the creation of the item and then the subsequent actions
     * like notifying the server
     *
     * @param state
     * @param commit
     */
    [aTypes.createItem]: ( {state, commit} ) => {
        console.log( aTypes.createItem, state );
        commit( mTypes.addNewItem );
    },

    /**
     * Handles the removal of an item
     * @param state
     * @param commit
     */
    [aTypes.deleteItem]: ( {state, commit} ) => {
        console.log( aTypes.deleteItem, state, commit );
        //todo write
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
        getItem: ( state, getters, payload ) => {
            let index;

            //room for other ways of finding index
            index = payload.index;

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
        // getItemByIndex: ( state, getters, index ) => {
        getItemByIndex: ( state, getters ) => ( index ) => {
            //
            console.log( 'getItemByIndex', state, index );
            // return state.items[ index ];

            return function ( state, index ) {
                return state.items[ index ];
                // var r = state.items.filter( function ( i ) {
                //     if ( i.index === index ) {
                //         return i;
                //     }
                // } );
                // return r[ 0 ];
            }( state, index )

        },

        getItemById: ( state, getters ) => ( id ) => {
            console.log( 'getItemById', state, id );

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
         * Returns list of items objects
         * @param state
         * @param getters
         * @param payload
         * @returns []
         */
        getAllItems: ( state, getters, rootState ) => {
            return state.items;
        },

        getAllIndexesList: ( state, getters, rootState, payload ) => {
            let out = [];
            for ( let [ key, val ] of state.items ) {
                // console.log( 'getAllIndexesList', key, val );
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
            for ( let [ key, val ] of items ) {
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
            return state.items.length;
        },


    };

export default {
    actions,
    getters,
    mutations,
    state,
}