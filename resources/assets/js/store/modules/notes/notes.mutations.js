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

        let idx = _.findIndex(state.notes, payload.obj );
        window.console.log( 'notes', 'destroyNote', 45, idx );
        state.notes.splice( idx, 1 );
    },

   [mTypes.setNewNote] : (state, payload)=>{
        let note = payload.obj;
        state.newNoteSerialNumber = note.serialNumber;
    },

    /**
     * Set the new note back to default value
     * @param state
     * @param payload
     */
    [mTypes.resetNewNote] : (state, payload)=>{
        state.newNoteSerialNumber = -1;
    }


};

