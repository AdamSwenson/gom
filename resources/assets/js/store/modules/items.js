import * as mTypes from '../../store/mutation-types'
import * as aTypes from '../../store/action-types'
import * as gTypes from '../../store/getter-types'

import Payload from '../../models/Payload'
import Item from '../../models/Item'
import Exam from '../../models/Exam'

const Vue = require( 'vue' );

window._ = require( 'lodash' );


const standardTimeout = 1000;

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
     On load the root exam object and first item are created but given no
     ids. thus we will eventually need to create an exam object if one isn't set

     However don't ask the server to create an id just yet
     lookup the exam object that resides at index 0
     this will have either been newly created on page load
     or it will be an existing exam object loaded from the db
     let exam = this.$store.getters[ gTypes.getActiveExamObj ];
     //Call the set active exam method
     //We do this rather than call the mutation directly
     //because there may need to be various other events and
     //things which need to happen depending on the context.
     //                this.$store.dispatch(aTypes.setActiveExam, Payload.factory({obj: exam}));
     this.$store.getters[ mTypes.setItem ](Payload.factory({index: 0, obj: exam}));
     }
     */
    items: [],

    // items: [ Exam.factory({index: 0}), Item.factory({index: 1}) ],
    /**
     * Mapping from older ItemIndex to new Item id value
     */
    indexMap: new Map(),

    orderMap: {}


};

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

const mutations = {

        onUpdate: ( state, event ) => {
            // window.console.log( 'items', 'onUpdate', 102, event );
            let { newIndex, oldIndex } = event;
            let resorted = state.items.splice( newIndex, 0, state.items.splice( oldIndex, 1 )[ 0 ] );
            // resorted.splice( newIndex, 0, resorted.splice( oldIndex, 1 )[ 0 ] );
            // window.console.log( 'items', 'onUpdate', 105, resorted);
            Vue.set(state, 'items', resorted );
            // state.items.splice( newIndex, 0, state.items.splice( oldIndex, 1 )[ 0 ] );
            // window.console.log( 'items', 'onUpdate', 105, );
        },

        addMappedItem: ( state, payload ) => {
            let { idx, item } = payload;
            if ( _.isEmpty( idx ) || _.isEmpty( item ) ) return false;
            let key = buildKey( idx );
            window.console.log( 'items', 'addMappedItem', 102, key, item );
            Vue.set( state.orderMap, key, item );
        },


        //utility, not called from outside
        cleanupEmptyItems: ( state ) => {
            for (let i = 0; i < state.items.length; i++) {
                if ( typeof state.items[ i ] === 'undefined' ) {
                    state.items.splice( i, 1 );
                }
            }
        },


        /**
         * Make sure the property index matches the lookup index
         * @param state
         * @param payload
         */
        [mTypes.updateOrder]: ( state, payload ) => {
            if(state.items.length === 0) return false;
            // console.log(mTypes.updateOrder, state, payload);
            // this just requires us to match list indexes w the
            //property of the item
            for (let i = 0; i < state.items.length; i++) {
                let item = state.items[ i ];
                // window.console.log('items', 'updateOrder', 87, i, item);
                if ( typeof item !== 'undefined' ) {
                    //set the property on the object
                    Vue.set( item, 'index', i );
                    //set it in the array with vue
                    Vue.set( state.items, i, item );
                }
            }

        },

        // /**
        //  * Make sure the property index matches the lookup index
        //  * @param state
        //  * @param payload
        //  */
        // [mTypes.updateOrder]: ( state, orderList ) => {
        //     //new payload where it contains a key orderList
        //     for (let i = 0; i < orderList.length; i++) {
        //         // this is the ith item id
        //         let id = orderList[ i ];
        //         let item = state.items.filter( ( i ) => {
        //             if ( i.id === id ) {
        //                 return i;
        //             }
        //         } );
        //
        //         //get the item, and update its index
        //         //no moving it or anything
        //         // window.console.log('items', 'updateOrder', 87, i, item);
        //         if ( typeof item !== 'undefined' ) {
        //             //set the property on the object
        //             Vue.set( item, 'index', i );
        //             //set it in the array with vue
        //             // Vue.set(state.items, i, item);
        //             //resort array
        //         }
        //     }
        //
        //     //now that we've done all that, let's resort items
        //     //by the object's index
        //     let items = state.items.sort( ( a, b ) => {
        //         return a.index > b.index;
        //     } );
        //
        //     //and finally push the sorted array back
        //     Vue.set( state, 'items', items );
        //
        //     // // console.log(mTypes.updateOrder, state, payload);
        //     // // this just requires us to match list indexes w the
        //     // //property of the item
        //     // for (let i = 0; i < state.items.length; i++) {
        //     //     let item = state.items[ i ];
        //     //     // window.console.log('items', 'updateOrder', 87, i, item);
        //     //     if ( typeof item !== 'undefined' ) {
        //     //         //set the property on the object
        //     //         Vue.set(item, 'index', i);
        //     //         //set it in the array with vue
        //     //         Vue.set(state.items, i, item);
        //     //     }
        //     // }
        //
        // },

        /**
         * Pushes item into storage
         * essentially the same as setItem. But has own name so that api
         * will call for creation rather than update
         *
         * @param state
         * @param payload Expecting Item object to be in payload.obj
         */
        [ mTypes.addNewItem ]: ( state, payload ) => {
            // console.log(mTypes.addNewItem, state, payload);
            if ( Payload.checkIfPayload( payload ) ) {
                let {
                    obj
                } = payload;
                Vue.set( state.items, obj.index, obj );
            }
//case where something just hands an item
            else {
                if ( payload instanceof Item ) {
                    //call the action addNewItem on it
                    //set its new index on the item
                    //add it to the list
                }
            }

// mTypes.updateOrder(state, payload);

        },


        /**
         * Alters the the property named in updateProp to have the
         * the value set in updateVal
         * @param state
         * @param payload
         */
        [ mTypes.updateItem ]: ( state, payload ) => {
            // console.log(mTypes.updateItem, payload, state);
            let itm = state.items[ payload.index ];

            if ( typeof itm !== 'undefined' ) {
                //Set the value so vue can see it
                Vue.set( itm, payload.updateProp, payload.updateVal );
                //Push the altered item back into the array
                //set it in the array with vue
                Vue.set( state.items, payload.index, itm );
            }
        },

        /**
         * Alters the the property named in updateProp to have the
         * the value set in updateVal
         * @param state
         * @param payload
         */
        [ mTypes.updateItemSilently ]: ( state, payload ) => {
            // console.log(mTypes.updateItemSilently, payload, state);
            let itm = state.items[ payload.index ];

            // let itm = helpers.getItemFromPayload(state, payload);
            // window.console.log('items', 143, itm);
            if ( typeof itm !== 'undefined' ) {
                //Set the value so vue can see it
                Vue.set( itm, payload.updateProp, payload.updateVal );
                //Push the altered item back into the array
                //set it in the array with vue
                Vue.set( state.items, payload.index, itm );
                // state.items.$set( payload.index, itm );
            }
        },


        /**
         * Alters the the property named in updateProp to have the
         * the value set in updateVal
         * @param state
         * @param payload
         */
        [ mTypes.updateComment ]: ( state, payload ) => {
            console.log( mTypes.updateComment, payload, state );
            //get the item
            let itm = helpers.getItemFromPayload( state, payload );
            window.console.log( 'items', 'updateComment', 145, itm, state.items );

            if ( typeof itm !== 'undefined' ) {
                // let itm = state.items[ payload.index ];
                let comment = itm.getComment( payload.updateValence );

                if ( typeof comment !== 'undefined' ) {
                    //Set the value so vue can see it
                    Vue.set( comment, 'text', payload.updateVal );
                }

                //Push the altered item back into the array
                //set it in the array with vue
                Vue.set( state.items, payload.index, itm );
                // state.items.$set( payload.index, itm );
                window.console.log( 'items', 'updateComment', 145, itm, state.items );
            }
        },


        /**
         * Push an Item into storage at a particular index
         * Payload should have keys: obj, index
         This is not watched by the api, so it can be called without
         triggering an update to the server
         *
         * @param state
         * @param payload Expecting Item object to be in payload.obj
         */
        [ mTypes.setItem ]: ( state, payload ) => {
            // console.log('items.mutations', mTypes.setItem, state, payload);
            if ( Payload.checkIfPayload( payload ) ) {
                Vue.set( state.items, payload.obj.index, payload.obj );
            }
        },

        /**
         * Pushes a mapping of index to id into indexMap
         * Payload should have keys: ItemIndex, ItemId
         *
         * @param state
         * @param rootState
         * @param payload Array with keys: ItemIndex, ItemId
         */
        [ mTypes.addItemIndexMapping ]: ( state, payload ) => {
            Payload.checkIfPayload( payload );
            Vue.set( state.indexMap, payload.index, payload.id );

            // state.indexMap.set( payload.index, payload.id );
        },


    }
;


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

const actions = {

    onUpdate: ( { state, dispatch, commit, getters }, event ) => {
        let p = new Promise( ( resolve, reject ) => {
            commit( 'onUpdate', event );
            resolve()
        } );

        return p.then( () => {
            return new Promise( ( resolve, reject ) => {
                commit( mTypes.updateOrder );
                resolve()
            } );

        } );

    },


    [aTypes.addOlderSibling]: ( { state, dispatch, commit, getters }, payload ) => {
        //add item at same depth with same parent but with lower index
        window.console.log( 'items', 'addOlderSibling', 283, payload );
    },

    [aTypes.addYoungerSibling]: ( { state, dispatch, commit, getters }, payload ) => {
        //add item at same depth with same parent but with higher index
        window.console.log( 'items', 'addYoungerSibling', 288, payload );
    },

    /**
     * Runs the various maintenance operations on the item store.
     * It will delete any empty slots and then make sure
     * the indexes are properly set
     * @param dispatch
     * @param commit
     * @param getters
     */
    [aTypes.cleanupItems]: ( { dispatch, commit, getters } ) => {

        let p = new Promise( ( resolve, reject ) => {
            commit( 'cleanupEmptyItems' );
            resolve()
        } );

        return p.then( () => {
            return new Promise( ( resolve, reject ) => {
                commit( mTypes.updateOrder );
                resolve()
            } );

        } );

    },

    /**
     * Handles the removal of an item
     * { dispatch, commit, getters, rootGetters }
     * @param state
     * @param commit
     */
    [aTypes.deleteItem]: ( { state, commit }, payload ) => {
        console.log( aTypes.deleteItem, state, commit, payload );
        //check if payload has correct structure
        let { index, id } = payload;
        //remove from page

        //reorder index

        //call to server to delete

        //confirm

        //if fail, put back on page with message

        //reorder index
        //todo write
    },


    /**
     * Makes an item into sibling of others by decreasing
     * its depth
     * @param state
     * @param payload
     */
    [ aTypes.promoteItem ]: ( { state, dispatch, commit, getters }, payload ) => {
        let { index } = payload;
        let item = getters.getItemByIndex( index );
        item.promote();
        commit( mTypes.setItem, Payload.factory( { obj: item } ) )
    },

    /**
     * Makes an item into a child of others by
     * increasing its depth
     * @param state
     * @param payload
     */
    [ aTypes.demoteItem ]: ( { state, dispatch, commit, getters }, payload ) => {
        let { index } = payload;
        let item = getters.getItemByIndex( index );
        item.demote();
        commit( mTypes.setItem, Payload.factory( { obj: item } ) )
    },

    [ aTypes.toggleItemPublic ]: ( { state, dispatch, commit, getters }, payload ) => {
        window.console.log( 'items', 'toggleItemPublic', 365, payload );

        if ( Payload.checkIfPayload( payload ) ) {
            let item = getters.getItemByIndex( payload.index );

            commit( mTypes.updateItem, Payload.factory( {
                index: item.index,
                updateProp: 'publicity',
                updateVal: !item.publicity
            } ) );
            // //get the item
            // let item = getters.getItemByIndex(payload.index);
            // //flip its value internally
            // item.togglePublic();
            // if ( item.index === payload.index ) {
            //     //update the item through vuex
            //     commit(mTypes.setItem, Payload.factory({obj: item}));
            // }
//            Vue.set(state.items, payload.index, item);
        }
    }


    /**
     * Consume a json object and populate the Items store
     * by pushing Items into it.
     * { dispatch, commit, getters, rootGetters }
     * @param state
     * @param rootState
     * @param payload
     */
    // [aTypes.loadItems]: ( state, rootState, payload ) => {
    //     //check if payload has correct structure
    //     //todo
    //
    //     //push each record from the payload into the store
    //     for (let i = 0; i < payload.length; i++) {
    //         let record = payload[ i ];
    //         //check if record has correct structure
    //         //todo
    //
    //         //add to Items and add index mapping
    //         [ aTypes.addNewItem ](state, rootState, record);
    //     }
    // },
//
};

const getters = {
    getSortedIds: ( state, getters ) => {
        let ids = [];
        if ( state.items.length > 0 ) {
            state.items.forEach( (i)=>{ids.push( i.id );} );
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


        // // [gTypes.getItemByIndex ]: ( state, getters ) => ( index ) => {
        // // window.console.log('items', 'getItemByIndex', 361, state,  index);
        // return function ( state, index ) {
        //     return state.items[ index ];
        // }(state, index)
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
     * Returns list of items objects
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

    getAllIndexesList: ( state, getters, rootState ) => {

        if ( isItemsEmpty( state ) ) return []
        // [gTypes.getAllIndexesList ]: ( state, getters, rootState, payload ) => {
        let out = [];
        return Object.keys( state.items )
        // for ( let [ key, val ] of state.items ) {
        //     // console.log( 'getAllIndexesList', key, val );
        //     out.push( key );
        // }
        // return out;
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

export default {
    actions,
    getters,
    mutations,
    state,
}