/**
 * Created by adam on 5/27/17.
 */
import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types'

import Payload from '../../../models/Payload'
import Item from '../../../models/Item'
import Exam from '../../../models/Exam'

// const actions = {
module.exports = {
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



    [aTypes.onUpdate]: ( { state, dispatch, commit, getters }, event ) => {
        let p = new Promise( ( resolve, reject ) => {
            commit( aTypes.onUpdate, event );
            resolve()
        } );

        return p.then( () => {
            return new Promise( ( resolve, reject ) => {
                commit( mTypes.updateOrder );
                resolve()
            } );

        } );

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

        }
    }
};

    //
    // [aTypes.addOlderSibling]: ( { state, dispatch, commit, getters }, payload ) => {
    //     //add item at same depth with same parent but with lower index
    //     window.console.log( 'items', 'addOlderSibling', 283, payload );
    // },
    //
    // [aTypes.addYoungerSibling]: ( { state, dispatch, commit, getters }, payload ) => {
    //     //add item at same depth with same parent but with higher index
    //     window.console.log( 'items', 'addYoungerSibling', 288, payload );
    // },


    // /**
    //  * Handles the removal of an item
    //  * { dispatch, commit, getters, rootGetters }
    //  * @param state
    //  * @param commit
    //  */
    // [aTypes.deleteItem]: ( { state, commit }, payload ) => {
    //     console.log( aTypes.deleteItem, state, commit, payload );
    //     //check if payload has correct structure
    //     let { index, id } = payload;
    //     //remove from page
    //
    //     //reorder index
    //
    //     //call to server to delete
    //
    //     //confirm
    //
    //     //if fail, put back on page with message
    //
    //     //reorder index
    //     //todo write
    // },

    // /**
    //  * Makes an item into a child of others by
    //  * increasing its depth
    //  * @param state
    //  * @param payload
    //  */
    // [ aTypes.demoteItem ]: ( { state, dispatch, commit, getters }, payload ) => {
    //     let { index } = payload;
    //     let item = getters.getItemByIndex( index );
    //     item.demote();
    //     commit( mTypes.setItem, Payload.factory( { obj: item } ) )
    // },


    // /**
    //  * Makes an item into sibling of others by decreasing
    //  * its depth
    //  * @param state
    //  * @param payload
    //  */
    // [ aTypes.promoteItem ]: ( { state, dispatch, commit, getters }, payload ) => {
    //     let { index } = payload;
    //     let item = getters.getItemByIndex( index );
    //     item.promote();
    //     commit( mTypes.setItem, Payload.factory( { obj: item } ) )
    // },


    // /**
    //  * Consume a json object and populate the Items store
    //  * by pushing Items into it.
    //  * { dispatch, commit, getters, rootGetters }
    //  * @param state
    //  * @param rootState
    //  * @param payload
    //  */
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

//
// export default {
//     actions}