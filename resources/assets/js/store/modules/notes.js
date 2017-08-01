/**
 * Created by adam on 7/31/17.
 */

import Vue from 'vue'

import * as mTypes from '../../store/mutation-types'
import * as aTypes from '../../store/action-types'
import * as gTypes from '../../store/getter-types'

import Payload from '../../models/Payload'
import Item from '../../models/Item'
import Exam from '../../models/Exam'

const state = {
    notes: []
};

const mutations = {
    createNote: ( state, payload ) => {
        if ( Payload.checkIfPayload( payload ) ) {
            let { obj, callback } = payload;

            state.notes.push( payload.obj );

            if ( !_.isUndefined( callback ) ) callback( payload );
        }
    },

    updateNote: ( state, payload ) => {
        let note = payload.obj;

        if ( typeof note !== 'undefined' ) {
            //Set the value so vue can see it
            Vue.set( note, payload.updateProp, payload.updateVal );
        }
    },

    destroyNote: ( state, payload ) => {
        let idx = state.notes.indexOf( payload.obj );
        if ( idx ) state.notes.splice( idx, 1 );
    }

};

const actions = {
    createNewNote: ( { state, dispatch, commit, getters }, payload ) => {
        let itm = payload.obj;
        if ( typeof itm !== 'undefined' ) {
            if ( itm instanceof Item || itm instanceof Exam ) {
                let note = Note.factory( { associatedItemSerialNumber: itm.serialNumber } );
                commit( 'createNote', Payload.factory( { obj: note } ) );
            }
        }
    }


};

const getters = {

    /**
     * Returns a list of notes associated with the
     * specified exam or item
     * @param state
     * @param getters
     * @param rootState
     * @param examOrItem
     */
    [gTypes.getNotesForItem] : ( state, getters, rootState, examOrItem ) =>
        ( examOrItem ) => {
            return (function ( state, serialNumber ) {
                var r = state.notes.filter( function ( i ) {
                    if ( i.associatedItemSerialNumber === serialNumber ) {
                        return i;
                    }
                } );
                return r;
            })( state, examOrItem.serialNumber )
        },

    /**
     * Returns a note object based on its serial number
     * @param state
     * @param getters
     * @param rootState
     * @param serialNumber
     */
    [gTypes.getNoteBySerialNumber] : ( state, getters, rootState, serialNumber ) =>
        ( serialNumber ) => {
            return (function ( state, serialNumber ) {
                var r = state.notes.filter( function ( i ) {
                    if ( i.serialNumber === serialNumber ) {
                        return i;
                    }
                } );
                return r[ 0 ];
            })( state, serialNumber )
        },
};


export default {
    actions,
    getters,
    mutations,
    state,
}