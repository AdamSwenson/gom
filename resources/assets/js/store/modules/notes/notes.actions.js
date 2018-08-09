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

import { loadNotesForItemRequest } from '../../../api/requests/noteRequests';


module.exports = {
    /**
     *
     */
    createNewNote: ( { state, dispatch, commit, getters }, payload ) => {
        return new Promise( function ( resolve, reject ) {
            let itm = payload.obj;
            if ( typeof itm !== 'undefined' ) {
                if ( itm instanceof Item || itm instanceof Exam ) {
                    let note = Note.factory( { associatedItemSerialNumber: itm.serialNumber } );
                    let pl = Payload.factory( { obj: note } );
                    commit( 'createNote', pl );
                    commit( "setNewNote", pl );
                    resolve();
                }
            }
            reject('bad item')
        } );
    },

    loadNotes: ( { state, dispatch, commit, getters }, payload ) => {
        return new Promise( function ( resolve, reject ) {
            let itm = payload.obj;
            if ( typeof itm !== 'undefined' ) {

                let p = loadNotesForItemRequest( itm );
                return p.then( function ( data ) {
                    _.forEach( data, function ( r ) {
                        let j =  getters[gTypes.getNoteById](r.id)
                        if(_.isUndefined(j)){
                            let note = Note.factory( r );
                            note.associatedItemSerialNumber = itm.serialNumber;
                            let payload = Payload.factory( { obj: note, mutateSilently: true } );
                            commit( 'createNote', payload );
                        }
                    } );
                    resolve();
                } );
            }
            reject( 'item undefined' );
        } );
    }


};

