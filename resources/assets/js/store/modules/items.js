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

const Vue = require( 'vue' );
const _ = window._ = require( 'lodash' );

import Objects from './items.obj'
import Orderings from './items.order'

// let orderMutations  = require( './items.order.mutations');
// let orderActions  = require('./items.order.actions');
// let orderGetters = require( './items.order.getters');
// let orderState  = require( './items.order.state');

const standardTimeout = 1000;

const helpers = {
    getItemFromPayload: ( state, payload ) => {
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
    },
    getItem: ( state, id ) => {
        return (function ( state, id ) {
            var r = state.items.filter( function ( i ) {
                if ( i.id === id ) {
                    return i;
                }
                ;
            } );
            return r[ 0 ];
        })( state, id );
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

const state = Object.assign( {}, Objects.state, Orderings.state );///orderState); //Orderings.state );


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
        // if ( map.length > 0 ) {

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
            let exam = getters.currentExam;
            let item = getters.getItemBySerialNumber( currentNode.data );
            let parent = getters.getItemBySerialNumber( currentNode.parent );

            out.push( {
                examId: exam.id,
                itemId: item.id,
                parentId: parent.id,
                itemOrder: cnt
            } );
        })( map );
        // }
        return out;
    }
};


const actions = {
    ...Objects.actions,
    ...Orderings.actions,
    /**
     * Called when a brand new item needs to be created and inserted into
     * the store.
     * This handles the creation of the item and then the subsequent actions
     * like notifying the server and placing the item in the appropriate
     * place in the order
     *
     * @param state
     * @param commit
     */
    [aTypes.createItem]: ( { state, commit, dispatch, getters }, parent ) => {
        if ( _.isUndefined( parent ) ) {
            parent = getters.currentExam;
        }

        //If we were passed an item to serve as the parent
        //we will use s serial number
        let item = Item.factory( { parent: parent } );
        let pl = Payload.factory( { parent: parent, obj: item } );

        let p = new Promise( ( resolve, reject ) => {
            commit( mTypes.addNewItem, pl );
            resolve();
//                commit( mTypes.setItem, Payload.factory( { index: index, obj: item, } ) );
        } );

        return p.then( () => {
            return new Promise( ( resolve, reject ) => {
                window.console.log( 'items', 'addItemToOrder', 172, pl );
                dispatch( aTypes.addItemToOrder, pl );
                resolve()
            } );
        } );
    },

    /**
     * Emancipates an item from its parent.
     * That is, it removes the association between an item
     * and its parent with the result that the item is no
     * longer present on the exam.
     *
     * The item and all associated score data remain intact.
     */
    [aTypes.removeItem] : ()=>{
        //remove from order

        //remove from objects
    },

    /**
     * Permanently remove the item and any associated
     * scores from the database.
     * This should not be called to remove the item from
     * the exam. That is done by removeItem
     */
    [aTypes.deleteItem] : ( ) => {}


};


// const getters = Object.assign( {}, getters_both, Objects.getters, orderGetters); //Orderings.getters ); //, ...g};
// Object.assign(getters, orderGetters);//
// const getters = { ...getters_both, ...Orderings.getters, ...Objects.getters };

window.console.log( 'ww items', 'f ************ getters', 112, getters, Objects, Orderings );
// };

// const actions = { ...actions_both, ...Objects.actions, ...Orderings.actions }; //Orderings.actions );
//require( './items.obj.actions' );

const mutations = {
    ...Objects.mutations,
    ...Orderings.mutations,

    initializeItemStore: ( state ) => {
        let exam = new Exam();
        state.items[ 0 ] = exam;
        state.itemMap = new Node( exam.serialNumber, exam.serialNumber );
    },

    directLoadObjectsFromJson: ( state, payload ) => {
        if ( typeof payload.obj !== 'undefined' ) {
            _.forEach( payload.obj, function ( d, i ) {
                let item = Item.factory( d ); //.factory( {id: id, index: index} );
                state.items.push(item);
            //     //set it in the items list without calling the api listener
            //     commit( mTypes.setItem, Payload.factory( {
            //         obj: item,
            //         mutateSilently: true
            //     } ) );
            } );
            // resolve();
        }
    },

    directLoadOrderFromJson: ( state, payload ) => {

        if ( typeof payload.obj !== 'undefined' ) {
            _.forEach( payload.obj, function ( d, i ) {
                window.console.log( 'JsonReaders', '', 34, d, i );

                let item = (( state, d ) => {
                    return helpers.getItem( state, d.itemId )
                })( state, d );
                window.console.log( 'items', 'state', 259, state );
                window.console.log( 'items', '', 259, item );
                //if the parent is null, these are top level
                //and should be added as children of the exam.
                //if the parent is null, we add the exam instead
                let parentNode = ( d.parentId === null ) ? state.itemMap : (( state, d ) => {
                    let parentItem = helpers.getItem( state, d.parentId );
                    return getNode( state, parentItem.serialNumber );
                })( state, d );

                let itemNode = new Node( item.serialNumber, parentNode.data );
                let index = d.itemOrder;

                window.console.log( 'items', 'direct load itemNode', 256, itemNode );
                window.console.log( 'items', 'direct load item', 256, item );
                window.console.log( 'items', 'direct load parentNode', 256, parentNode );


//if an index was specified, splice it in at the index
                if ( !_.isUndefined( index ) ) {
                    parentNode.children.splice( index, 0, itemNode );
                }
                else {
//otherwise just push it on the end
                    parentNode.children.push( itemNode );

                }
            } );
        }
    },


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