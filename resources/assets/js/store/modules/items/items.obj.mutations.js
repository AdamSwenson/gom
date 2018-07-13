/**
 * Created by adam on 5/27/17.
 */
import Vue from 'vue'

import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types'

import Payload from '../../../models/Payload'
import Item from '../../../models/Item'
import Exam from '../../../models/Exam'

/**
 * We want the actual mutations to be as agnostic as possible
 * on how the item is identified. This takes the payload
 * and returns the item.
 * The order of preference is:
 *     - if the item object has been given to us, use it.
 *     - if the serial number of the item object has been given, use it
 *     - if the id of the item has been given, use it
 *     - if the index of the item has been given, use it
 * @param state
 * @param payload
 */
const getItemFromPayload = ( state, payload ) => {

    switch ( payload.identifierType ) {
        case 'obj':
            return payload.obj;
            break;

        case 'serialNumber':
            return state.items.filter( ( o ) => {
                if ( o.serialNumber === payload.serialNumber ) {
                    return o;
                }
            } );
            break;

        case 'index':
            return state.items[ payload.index ];
            break;
    }
};

module.exports = {
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

    addMappedItem: ( state, payload ) => {
        let { idx, item } = payload;
        if ( _.isEmpty( idx ) || _.isEmpty( item ) ) return false;
        let key = buildKey( idx );
        window.console.log( 'items', 'addMappedItem', 102, key, item );
        Vue.set( state.orderMap, key, item );
    },

    /**
     * Pushes item into storage at the end of the list.
     * essentially the same as setItem. But has own name so that api
     * will call for creation rather than update
     *
     * @param state
     * @param payload Expecting Item object to be in payload.obj
     */
    [ mTypes.addNewItem ]: ( state, payload ) => {

            if ( Payload.checkIfPayload( payload ) ) {
                let { obj, callback } = payload;
                //and here we meet the problem of deciding what data
                //structure to use to store the items and the many
                //times I've changed my mind
                //The problem is what to do if the incoming
                //item has an internally different index.
                //The answer isn't very good. Right now, it is just
                //to not use this method to update.
                //Of course, everyone is on their honor to not do so....
                state.items.push( obj );

                if(! _.isUndefined(callback)) callback(payload);
            }
       },

    //utility, not called from outside
    cleanupEmptyItems: ( state ) => {
        for (let i = 0; i < state.items.length; i++) {
            if ( typeof state.items[ i ] === 'undefined' ) {
                state.items.splice( i, 1 );
            }
        }
    },

    onUpdate: ( state, event ) => {
        // window.console.log( 'items', 'onUpdate', 102, event );
        let { newIndex, oldIndex } = event;
        let resorted = state.items.splice( newIndex, 0, state.items.splice( oldIndex, 1 )[ 0 ] );
        // resorted.splice( newIndex, 0, resorted.splice( oldIndex, 1 )[ 0 ] );
        // window.console.log( 'items', 'onUpdate', 105, resorted);
        Vue.set( state, 'items', resorted );
        // state.items.splice( newIndex, 0, state.items.splice( oldIndex, 1 )[ 0 ] );
        // window.console.log( 'items', 'onUpdate', 105, );
    },

    /**
     * Push an Item into storage at a particular index
     * Payload should have keys: obj, index
     * This is not watched by the api, so it can be called without
     * triggering an update to the server
     *
     * @param state
     * @param payload Expecting Item object to be in payload.obj
     */
    [ mTypes.setItem ]: ( state, payload ) => {
        return new Promise( ( resolve, reject ) => {

            // console.log('items.mutations', mTypes.setItem, state, payload);
            if ( Payload.checkIfPayload( payload ) ) {
                let { index } = payload.obj;
                // window.console.log( 'items.mutations', 'index', 100, index );
                Vue.set( state.items, index, payload.obj );
            }
            resolve();
        } );
    },

    /**
     * Alters the the property named in updateProp to have the
     * the value set in updateVal
     * @param state
     * @param payload
     */
    [ mTypes.updateComment ]: ( state, payload ) => {
        // window.console.log( mTypes.updateComment, payload, state );

        //get the item
        let itm = getItemFromPayload( state, payload );
        // window.console.log( 'items', 'updateComment', 145, itm, state.items );

        if ( typeof itm !== 'undefined' ) {
            // let itm = state.items[ payload.index ];
            let comment = itm.getComment( payload.updateValence );

            if ( typeof comment !== 'undefined' ) {
                //Set the value so vue can see it
                Vue.set( comment, 'text', payload.updateVal );
            }

            //Push the altered item back into the array
            //set it in the array with vue
            //todo This is probably not doing anything since no index is being passed in. Consider removing it.
            Vue.set( state.items, payload.index, itm );

            // window.console.log( 'items', 'updateComment', 145, itm, state.items );
        }
    },

    /**
     * Alters the the property named in updateProp to have the
     * the value set in updateVal
     * @param state
     * @param payload
     */
    [ mTypes.updateItem ]: ( state, payload ) => {
        // console.log( mTypes.updateItem, payload, state );
        let itm = getItemFromPayload( state, payload );

        if ( typeof itm !== 'undefined' ) {
            //Set the value so vue can see it
            Vue.set( itm, payload.updateProp, payload.updateVal );
        }
    },

    /**
     * Alters the the property named in updateProp to have the
     * the value set in updateVal.
     *
     * @param state
     * @param payload
     */
    [ mTypes.updateItemSilently ]: ( state, payload ) => {
        return new Promise( ( resolve, reject ) => {
            let itm = getItemFromPayload( state, payload );
            // if ( typeof itm === 'undefined' ) return reject();
            //Set the value so vue can see it
            Vue.set( itm, payload.updateProp, payload.updateVal );
            return resolve();
        } );
    },

    /**
     * Make sure the property index matches the lookup index
     * @deprecated (I think....Seems like this isn't used -- it should be in item.order.mutations)
     * @param state
     * @param payload
     */
    [mTypes.updateOrder]: ( state, payload ) => {
        return new Promise( ( resolve, reject ) => {

            // if ( state.items.length === 0 ) return reject();
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
            resolve();
        } );
    },

};


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

