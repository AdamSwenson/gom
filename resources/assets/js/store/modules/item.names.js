/**
 * Created by adam on 3/10/17.
 */


import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'
import Payload from '../../models/Payload'

const state = {
    // itemNames: {}
    itemNames: [] //new Map()
};

const mutations = {
    [mTypes.setItemNameByIndex]: ( state, payload ) => {
        console.log( '*****', 'addName', payload, state )
        // Vue.set(state.itemNames, payload.index, payload.str);

        //state.itemNames.splice( payload.index, 0, payload.str );
    },

    [mTypes.updateItemNameByIndex]: ( state, payload ) => {
        console.log( '*****', 'updateItemNameByIndex', state , payload)
        state.itemNames.$set(payload.index,  payload.str);
    },

};

const actions = {};
const getters = {

    getItemNameByIndex: ( state, getters ) => ( index ) => {
        console.log( 'getItemNameByIndex', state, index );
        // return state.itemNames.filter((index) => state.itemNames[index] );

       return state.itemNames[index];
        // return state.itemNames.get( index )
    },
}

export default {
    actions,
    getters,
    mutations,
    state,
}
