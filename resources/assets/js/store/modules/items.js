/**
 * This ties together the two types of storage for
 * items
 */

import * as mTypes from '../../store/mutation-types'
import * as aTypes from '../../store/action-types'
import * as gTypes from '../../store/getter-types'

import Payload from '../../models/Payload'
import Item from '../../models/Item'
import Exam from '../../models/Exam'
import Node from '../../models/Node'
import { traverseDF, traverseBF, getNode } from '../../models/NodeTools'

import JsonReaders from '../utlities/JsonReaders'

import { holdForIdLoading, holdForCanSync } from '../../api/apiHelpers';

import { buildPayloadFromInput } from '../utlities/itemHelpers'

const Vue = require( 'vue' );
const _ = window._ = require( 'lodash' );

import Objects from './items.obj'
import Orderings from './items.order'

const REQUEST_VERSION = 1;

const standardTimeout = 1000;

const state = {

    ...Objects.state,
    ...Orderings.state

};

/**
 * The make use of both the item object store
 * and the order mapping
 *
 * @type {{getSortedIds: ((p1:*, p2?:*))}}
 */
const getters = {
    ...Orderings.getters,
    ...Objects.getters,

    /**
     * This takes the map of serial numbers in which
     * the ordering is represented and returns a map
     * with ids.
     * The resulting map is used to, inter alia, sync with
     * the server
     * @param state
     * @param getters
     */
    [gTypes.getSortedIds]: ( state, getters ) => {
        //get the serial number map
        //we explicitly use the getter rather than
        //just looking in the state because this
        //may well evolve to a different storage
        //behind the scenes
        //We begin by making a copy because we will
        //be altering the data stored
        let map = getters[ gTypes.getItemMapCopy ]; //( state, getters );
        // window.console.log( 'items', 'getSortedIds', 124, 'map', map);

        let updater = function ( currentNode ) {
            currentNode = { ...currentNode };
            //Look up the id
            let isn = currentNode.data;

            //ignore the exam
            if ( isn === 0 ) return true;
            let item = getters.getItemBySerialNumber( isn );

            // let item = getters[ gTypes.getItemBySerialNumber ]( state, getters, isn );
            // window.console.log( 'items', 'updater isn item', 144, isn, item);
            if ( !_.isUndefined( item ) ) {
                //we don't check if id is defined.
                //should we????
                currentNode.data = item.id;
                currentNode.dataType = 'id';
                // window.console.log( 'items', 'recurse', 150, currentNode);
            }
            return currentNode;
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
            // window.console.log( 'items', 'recurse', 153, currentNode );
            // step 4
            updater( currentNode );
        })( map );
        return map;
    },

    getOrderForSync: ( state, getters ) => {
        let out = [];
        let map = state.itemMap; //getters[ gTypes.getItemMapCopy ];
        window.console.log( 'items', 'getOrderForSync', 162, map );

        if ( _.isUndefined( map ) || map.length === 0 ) return false;

        //map is the exam represented as a Node object
        // Doing this depth first
        // this is a recurse and immediately-invoking function
        (function recurse( currentNode, cnt = 0 ) {
            // window.console.log( 'items', 'recurse', 129, currentNode);
            // step 2
            for (var i = 0; i < currentNode.children.length; i++) {
                // step 3
                recurse( currentNode.children[ i ], i );
            }
            // window.console.log( 'items', 'recurse', 153, currentNode );
            // step 4
            let item = getters.getItemBySerialNumber( currentNode.data );
            // holdForIdLoading(item);
            // window.console.log( 'items', 'recurse', 193, 'post hold', item);
            if(! _.isUndefined(item)){
                let exam = item.isExam() ? item : getters.currentExam;
                let parent = getters.getItemBySerialNumber( currentNode.parent );
                out.push( {
                    examId: exam.id,
                    itemId: item.id,
                    parentId: parent.id,
                    itemOrder: cnt
                } );
            }

        })( map );
        // }
        return out;
    },

    /**
     * Whether all items have had their ids updated from
     * the default -1 to a value from the db
     * @param state
     * @param getters
     * @param rootState
     * @returns {boolean}
     */
    canSync: ( state, getters, rootState ) => {
        if ( state.items.length === 0 ) return false;

        return (function ( state ) {
            var r = state.items.filter( function ( item ) {
                if ( item.id === -1 ) {
                    return item;
                }
            } );
            return r.length === 0;
            document.getElementById( 'isSyncing' )
        })( state );
    }
};


const actions = {
    ...Objects.actions,
    ...Orderings.actions,
    ...JsonReaders.actions,

    /**
     * This is the master handler of the process of adding an item
     *
     * Called when a brand new item needs to be created and inserted into
     * the store.
     *
     * This handles the creation of the item and then the subsequent actions
     * like notifying the server and placing the item in the appropriate
     * place in the order
     *
     * @param state
     * @param commit
     */
    [aTypes.createItem]: ( { state, commit, dispatch, getters }, parentSN ) => {
        return (function ( state, commit, dispatch, getters, parentSN ) {
            // window.console.log( 'items', aTypes.createItem, 220, parent );
            if ( _.isUndefined( parentSN ) ) {
                parentSN = getters.currentExam;
            }

            //If we were passed an item to serve as the parent
            //we will use s serial number
            let item = Item.factory( { parent: parentSN } );
            let payload = Payload.factory( { parent: parentSN, obj: item } );

            commit( mTypes.addNewItem, payload );
            // window.console.log( 'items', 'canSync', 245, getters.canSync );
            // holdForCanSync( item )
            // {
            dispatch( aTypes.addItemToOrder, payload );
            // }
        })( state, commit, dispatch, getters, parentSN );

    },

    /**
     * This handles the request to create an exact copy of
     * an existing item. By default, we will make it a sibling of the
     * cloned item.
     *
     * @param state
     * @param commit
     */
    [aTypes.cloneItem]: ( { state, commit, dispatch, getters }, payload ) => {
        return (function ( state, commit, dispatch, getters, payload ) {
            //NB, parent is the parent item's serial number
            //toClone is an object
            let { parent, toClone } = payload;

            //If we were passed an item to serve as the parent
            //we will use s serial number
            let item = Item.factory( { parent: parent } );

            _.forEach( Item.clonableProps, function ( p ) {
                item[ p ] = toClone[ p ];
            } );

            let pl = Payload.factory( { parent: parent, obj: item});
            // window.console.log( 'items', 'cloneItem payload', 234, pl);
            commit( mTypes.addNewItem, pl );

            dispatch( aTypes.addItemToOrder, pl );

        })( state, commit, dispatch, getters, payload );

    },

    importItem : ( { state, commit, dispatch, getters }, payload ) => {
        return (function ( state, commit, dispatch, getters, payload ) {
            //NB, parent is the parent item's serial number
            //obj is an object
            let { parent, obj } = payload;

            let pl = Payload.factory( { parent: parent, obj: obj});
            // window.console.log( 'items', 'cloneItem payload', 234, pl);

            dispatch( aTypes.addItemToOrder, pl );
            //the item will not have been stored in the regular items array
            //instead it is loaded asynchronously.
            //So we need to push it into the main array
            pl.mutateSilently = true;
            commit( mTypes.addNewItem, pl );

        })( state, commit, dispatch, getters, payload );

    },


    /**
     * Emancipates an item from its parent.
     * That is, it removes the association between an item
     * and its parent with the result that the item is no
     * longer present on the exam.
     *
     * The item and all associated score data remain intact.
     */
    [aTypes.removeItem]: ( { state, commit, dispatch, getters }, payload ) => {
            return (function ( state, commit, dispatch, getters, payload ) {
                //obj is an object
                let { obj } = payload;

                let pl = Payload.factory( { obj: obj});
                // window.console.log( 'items', 'cloneItem payload', 234, pl);

                dispatch( aTypes.addItemToOrder, pl );
                //the item will not have been stored in the regular items array
                //instead it is loaded asynchronously.
                //So we need to push it into the main array
                pl.mutateSilently = true;
                commit( mTypes.addNewItem, pl );

            })( state, commit, dispatch, getters, payload );

            //remove from order
        [aTypes.removeItem]

        //remove from objects
    },

    /**
     * Permanently remove the item and any associated
     * scores from the database.
     * This should not be called to remove the item from
     * the exam. That is done by removeItem
     */
    [aTypes.deleteItem]: () => {
    }


};


// const getters = Object.assign( {}, getters_both, Objects.getters, orderGetters); //Orderings.getters ); //, ...g};
// Object.assign(getters, orderGetters);//
// const getters = { ...getters_both, ...Orderings.getters, ...Objects.getters };

// };

// const actions = { ...actions_both, ...Objects.actions, ...Orderings.actions }; //Orderings.actions );
//require( './items.obj.actions' );

const mutations = {
    ...Objects.mutations,
    ...Orderings.mutations,
    ...JsonReaders.mutations

};
//Object.assign( {}, Objects.mutations, Orderings.mutations ); //Orderings.mutations ); //require( './items.obj.mutations' );

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