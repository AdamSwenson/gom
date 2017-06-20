/**
 * Created by adam on 6/8/17.
 */
import * as mTypes from '../../store/mutation-types'
import * as aTypes from '../../store/action-types'
import * as gTypes from '../../store/getter-types'

import Payload from '../../models/Payload'
import Item from '../../models/Item'
import Exam from '../../models/Exam'


const _ = window._ = require( 'lodash' );

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


module.exports = {

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
    // getAllItems: ( state, getters, rootState ) => {
    [gTypes.getAllItems]: function ( state, getters, rootState ) {
        return state.items;
    },

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
    // getItem: ( state, getters ) => ( payload ) => {
    [gTypes.getItem ]: function ( state, getters, rootState, payload ) {
        // console.log('getItem', state, payload);
        if ( isItemsEmpty( state ) ) return false;
        if ( Payload.checkIfPayload( payload ) ) {
            let { index, id } = payload;
            if ( typeof index !== 'undefined' ) {
                return getters[ gTypes.getItemByIndex ]( state, getters, index );
            }
            if ( typeof id !== 'undefined' ) {
                return getters[ gTypes.getItemById ]( state, getters, id );
            }
        }
    },


    /**
     * Returns the item object with the given database id.
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
    // getItemById: ( state, getters ) => ( id ) => {
    [gTypes.getItemById]: function ( state, getters, rootState, id ) {
        // window.console.log( 'items', 'getItemById', 148, state, id );
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
    // [gTypes.getItemByIndex]: function ( state, getters, rootState, index ) {
    [gTypes.getItemByIndex]: ( state, getters, rootState, index)=> (index) => {

        // [gTypes.getItemByIndex]: ( state, getters, rootState, index) => {
        // [gTypes.getItemByIndex]: function ( state, getters, index ) {
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
     * Returns the item with the given serial number.
     * This will, inter alia, allow us to access the item before the database
     * has an id for it.
     * @param state
     * @param getters
     */
    [gTypes.getItemBySerialNumber]: ( state, getters, rootState, serialNumber ) => (serialNumber) => {
    // [gTypes.getItemBySerialNumber]: function ( state, getters, rootState, serialNumber ) {
        // window.console.log( 'items', gTypes.getItemBySerialNumber, 248, serialNumber, state );
        return function ( state, serialNumber ) {
            var r = state.items.filter( function ( i ) {
                if ( i.serialNumber === serialNumber ) {
                    return i;
                }
            } );
            return r[ 0 ];
        }( state, serialNumber )
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
    getAllIndexesList: function ( state, getters, rootState ) {
        if ( isItemsEmpty( state ) ) return []
        // [gTypes.getAllIndexesList ]: ( state, getters, rootState, payload ) => {

        let out = [];
        for (let [ key, val ] in state.items) {
            out.push( key );
        }
        return out;

        //Leaving this here, in case someday we go back to items being an object
        // return Object.keys( state.items )
    }
    ,

    /**
     * Return list of Item objects
     * @deprecated
     * @param state
     * @param getters
     * @param payload
     * @returns []
     */
    [ gTypes.getAllItemsList ]: ( state, getters , rootState) => {
//alias.
// used to be used when items was different data structure
//         return this.getAllItems( state, getters );
        return state.items;

    },

    /**
     * Returns the current count of items
     * @param state
     * @param getters
     * @param payload
     * @returns {Number}
     */
    [ gTypes.getItemCount ]: function ( state, getters , rootState) {

        return state.items.length;
    },

    getNextIndex: function ( state, getters ) {
        // return _.sortedIndex( state.items );

    },

    /**
     * Poorly named shortcut for getting the currently active exam.
     * @param state
     */
    currentExam: ( state, getters ) => {
        return state.items[ 0 ];
    }


};
