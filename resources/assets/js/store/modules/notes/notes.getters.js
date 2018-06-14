/**
 * Created by adam on 7/31/17.
 */

import Vue from 'vue'

import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types'

import Payload from '../../../models/Payload'
import Item from '../../../models/Item'
import Exam from '../../../models/Exam'

import Note from '../../../models/Note'


module.exports  = {

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
    };
