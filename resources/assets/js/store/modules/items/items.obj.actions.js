/**
 * Created by adam on 5/27/17.
 */
import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'

import Payload from '../../../models/Payload'
import Comment from '../../../models/Comment'
import { updateComment } from "../../../api/requests/commentRequests";

module.exports = {
    /**
     * Runs the various maintenance operations on the item store.
     * It will delete any empty slots and then make sure
     * the indexes are properly set
     * @param dispatch
     * @param commit
     * @param getters
     */
    [ aTypes.cleanupItems ]: ( { dispatch, commit, getters } ) => {

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


    [ aTypes.onUpdate ]: ( { state, dispatch, commit, getters }, event ) => {
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
        // window.console.log( 'items', 'toggleItemPublic', 365, payload );

        if ( Payload.checkIfPayload( payload ) ) {
            let item = getters.getItemByIndex( payload.index );

            commit( mTypes.updateItem, Payload.factory( {
                index: item.index,
                updateProp: 'publicity',
                updateVal: !item.publicity
            } ) );

        }
    },


    /**
     * Takes the stock comment and creates rough drafts
     * of the valenced comments for the user to work from.
     */
    [ aTypes.updateComment ]: ( { state, dispatch, commit, getters }, payload ) => {
        return new Promise( function ( resolve, reject ) {
            window.console.log( 'items.obj.actions', '', 77, );
            let item = payload.obj;

            let previousTextValues = item.comments;

            commit( mTypes.updateComment, payload );

            if ( !_.isUndefined( payload.options ) && !_.isUndefined( payload.options.overwriteDefaults && !_.isUndefined( payload.options.examId ) ) ) {
                updateComment( item, payload.options.overwriteDefaults, payload.options.examId )
                    .then( function () {
                        resolve();
                    } )
                    .catch( function ( error ) {
                        reject( error );
                    } );

            } else {
                updateComment( item )
                    .then( function () {
                        resolve();
                    } )
                    .catch( function ( error ) {
                        reject( error );
                    } );
            }

        } );
    },


    /**
     * Takes the stock comment and creates rough drafts
     * of the valenced comments for the user to work from.
     */
    [ aTypes.prePopulateComments ]: ( { state, dispatch, commit, getters }, payload ) => {
        return new Promise( function ( resolve, reject ) {

            let item = payload.obj;
            let stock = payload.updateVal;

            _.forEach( Comment.valencesExcludingStock, function ( v ) {
                let comment = item.getComment( v );

//                        todo This logic could probably be improved
                // Skip if the comment text is already set.
                // We don't want to overwrite existing comments if stock is altered.
                // We can't judge when to overwrite the saved text with
                // changes from stock by checking that comment.text.length > 0
                // since that will stop after the first letter of stock.
                // Thus we instead check that it isn't longer than the current stock we
                // are trying to insert.
                if ( !_.isUndefined( comment.text ) && !_.isNull( comment.text ) && comment.text.length > stock ) return true;

                //create the new text.
                //nb, any enhancements to prepopulation should be done in Comment
                let text = Comment.makePrePopulatedContent( comment.valence, stock );

                //save the new comment text for the valence
                let pl = Payload.factory( {
                    obj: item,
                    updateValence: comment.valence,
                    updateVal: text,
                } );

                dispatch(aTypes.updateComment, pl)
                //     .then(function(){
                //
                // });
                // commit( mTypes.updateComment, pl );

            } );

            resolve();

        } );
    },
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


// export default {
//     actions}