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

import Note from '../../models/Note'

const state = {
    notes: [],
    newNoteSerialNumber: -1,

};

const mutations = {
    [mTypes.createNote] : ( state, payload ) => {
        if ( Payload.checkIfPayload( payload ) ) {
            let { obj, callback } = payload;

            state.notes.push( payload.obj );

            if ( !_.isUndefined( callback ) ) callback( payload );
        }
    },

    [mTypes.updateNote] : ( state, payload ) => {
        window.console.log( 'notes', 'updateNote', 35, payload);
        let note = payload.obj;

        if ( typeof note !== 'undefined' ) {
            //Set the value so vue can see it
            Vue.set( note, payload.updateProp, payload.updateVal );
        }
    },

    [mTypes.destroyNote] : ( state, payload ) => {
        window.console.log( 'notes', 'destroyNote', 45, payload );
        let idx = state.notes.indexOf( payload.obj );
        if ( idx ) state.notes.splice( idx, 1 );
    },

    setNewNote: (state, payload)=>{
        let note = payload.obj;
        state.newNoteSerialNumber = note.serialNumber;
    }

};

const actions = {
    createNewNote: ( { state, dispatch, commit, getters }, payload ) => {
        let itm = payload.obj;
        if ( typeof itm !== 'undefined' ) {
            if ( itm instanceof Item || itm instanceof Exam ) {
                let note = Note.factory( { associatedItemSerialNumber: itm.serialNumber } );
                let pl =  Payload.factory( { obj: note } );
                commit( 'createNote',pl );
                commit("setNewNote", pl);
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
        getNotesForItem : ( state, getters, rootState, examOrItem ) =>
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
        [gTypes.getNoteBySerialNumber]: ( state, getters, rootState, serialNumber ) =>
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

        getNewNote: ( state, getters, rootState ) => {
            if ( state.newNoteSerialNumber === -1 ) return false;

            //get the note object
            let note = getters.getNoteBySerialNumber( state.newNoteSerialNumber );
            return note;
        }
    }
;


export default {
    actions,
    getters,
    mutations,
    state,
}