/**
 * Created by adam on 4/11/17.
 */
window._ = require( 'lodash' );
import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'


let getItemFromOrder = ( order, idx ) => {
    let itm = order[ 0 ];
    //idx is a tuple stored as an array
    for (let i = 0; i < idx.length; i++) {
        itm = itm.children[ i ]
    }
    return itm;
};

let getItemFromList = ( orderList, idx ) => {
    let itm = orderList[ 0 ];
    //idx is a tuple stored as an array
    for (let i = 0; i < idx.length; i++) {
        itm = itm[ 1 ][ i ]
    }
    return itm;
};

const state = {

    /*
     * What we want to have is the ability to store nested
     * tuples which map the item to a position on an exam
     * (which is itself formally an item).
     * order : {
     *      0 : {
     *          id: null,
     *          children: {
     *              0 : {
     *                      id: null.
     *                      children: {}
     *                 }
     *          }
     *      }
     }
     *
     * */
    //the first value in the array is the item's id
    //the second value is an array of children
    // orderMap: new Map(),
    // orderList: [],
    //
    // order: {
    //     0: {
    //         id: null,
    //         children: {
    //             0: {
    //                 id: null,
    //                 children: {}
    //             }
    //         }
    //     }
    // }
orderMap : new Map(),
    order : {}

};

const mutations = {
    addMappedItem: ( state, idx, toAdd ) => {
        state.orderMap.set( idx, toAdd );
    },

    addChild: ( state, idx, idToAdd ) => {
        let child = [ idToAdd, [] ];
        let itm = orderList[ 0 ];
        //idx is a tuple stored as an array
        for (let i = 0; i < idx.length; i++) {
            itm = itm[ 1 ][ i ]
        }
        let children = itm[ 1 ];
        children.push( child );
        Vue.set( itm, 1, children );
        //
        //
        // let item = getItemFromList(state.orderList,  idx);
        // if (! _.isEmpty(item)){
        //     let maxIndex = _.last( Object.keys(item.children));
        //     item.children
        // }

        // let item = getItemFromOrder(state.order,  idx);
// if (! _.isEmpty(item)){
//     let maxIndex = _.last( Object.keys(item.children));
//     item.children
// }

    },

    addParent: ( state, existing, toAdd ) => {


    },
    addOlderSibling: ( state, existing, toAdd ) => {
    },
    addYoungerSibling: ( state, existing, toAdd ) => {
    },

    removeItem: ( state, payload ) => {
    },

    //
};

const actions = {

    //only these can call the mutations.
    //so there needs to be one for each mutation

};

const getters = {
    getMappedItem: ( state, getters ) => ( idx ) => {
        return state.orderMap.get( idx );
    },

    getItemFromOrder: ( state, getters ) => ( idx ) => {
        let itm = state.order[ 0 ];
        //idx is a tuple stored as an array
        for (let i = 0; i < idx.length; i++) {
            itm = itm.children[ i ]
        }
        return itm;
    },

    getItemByIdx: ( state, getters ) => ( idx ) => {
        let stringKey = Item.buildKeyFromIdx( idx );

        return function ( state, idx ) {
            var r = state.items.filter( function ( i ) {
                if ( i.idxStore === stringKey ) {
                    return i;
                }
                return r[ 0 ];
            } )
        };
    },


    getSiblingsAndChildrenByIdx: ( state, getters ) => ( idx ) => {
        let stringKey = Item.buildKeyFromIdx( idx );

        return function ( state, idx ) {
            var r = state.items.filter( function ( i ) {
                if ( _.startsWith( stringKey, idx ) ) {
                    return i;
                }
                return r[ 0 ];
            } )
        }
    }

};


export default {
    actions,
    getters,
    mutations,
    state,
}