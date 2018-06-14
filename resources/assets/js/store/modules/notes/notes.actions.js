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

