//
// createItemNote: (item)=>{ return NOTES_BASE_ROUTE + '/item/' + item.id},
//     createExamNote: (exam)=>{ return NOTES_BASE_ROUTE + '/exam/' + exam.id},
//     updateNote: (note)=>{return NOTES_BASE_ROUTE  + '/' + note.id},
//     destroyNote: (note)=>{return NOTES_BASE_ROUTE + '/' + note.id},
//     getNotesForItem: (item)=>{return NOTES_BASE_ROUTE + '/item/' + item.id},
//     getNotesForExam: (exam) =>{return NOTES_BASE_ROUTE+ '/item/' + exam.id }
//    
//
import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT, Routes } from '../apiSettings';

import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Exam from '../../models/Exam'
import Item from '../../models/Item'

import { errorHandling, handleResponse } from '../responseHandlers';
import { holdForIdLoading } from '../apiHelpers';


/**
 * We will want to update our object with info from
 * the server upon creation. This handles that.
 * @param store
 * @param item
 * @param response
 * @returns {Promise}
 */
const handleCreateResponse = ( store, note, data ) => {
    // window.console.log( 'noteRequests', 'r', 29, r );
    note.id = data.id;
    note.updatedAt = data.updated_at;
    note.createdAt = data.created_at;

    let payload = Payload.factory( { obj: note, mutateSilently: true } );
    store.commit( 'createNote', payload );
};

/**
 * Process the result of a response where we need to
 * insert new notes into store
 * @param store
 * @param response
 */
const handleLoadResponse = ( store, itemOrExam, response ) => {
    _.forEach( response.data, function ( r ) {
        // window.console.log( 'noteRequests', 'r', 29, r );
        let note = Note.factory( { r } );
        note.id = r.id;
        note.text = r.text;
        note.priority = r.priority;
        note.props = r.props;
        note.updatedAt = r.updated_at;
        note.createdAt = r.created_at;
        note.name = r.name;
        note.associatedItemSerialNumber = itemOrExam.serialNumber;
        let payload = Payload.factory( { obj: note, mutateSilently: true } );
        store.commit( 'createNote', payload );
    } );

};


module.exports = {

    createNoteRequest: ( store, note ) => {
        window.console.log( 'apiPlugin---noteRequests', 'createNoteRequest', note );
        let out = {
            requestVersion: REQUEST_VERSION
        };

        let associatedItemOrExam = store.getters.getItemBySerialNumber( note.associatedItemSerialNumber );

        if ( associatedItemOrExam ) {
            let route = associatedItemOrExam instanceof Exam ? Route.createExamNote( associatedItemOrExam ) : Route.createItemNote( associatedItemOrExam );

            window.axios
                .post( route, out )
                .then( ( response ) => {
                    if ( response.data.length > 0 ) {
                        handleCreateResponse( response );
                    }
                } )
                .catch( function ( error ) {
                    errorHandling( error );
                } );
        }
    },

    updateNoteRequest: ( store, note ) => {
        let associatedItemOrExam = store.getters.getItemBySerialNumber( note.associatedItemSerialNumber );

        let out = {
            requestVersion: REQUEST_VERSION,
            isExam: associatedItemOrExam.isExam,
            associatedItemId: associatedItemOrExam.id,
            ...note
        };

        window.axios
            .post( Route.updateNoteRequest( associatedItemOrExam ), out )
            .then( ( response ) => {
                if ( response.data.length > 0 ) {
                    // handleUpdateResponse( response );
                }
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    destroyNoteRequest:
        ( store, note ) => {
            let out = {
                requestVersion: REQUEST_VERSION,
                ...note
            };

            window.axios
                .post( Route.destroyNote( associatedItemOrExam ), out )
                .then( ( response ) => {
                    if ( response.data.length > 0 ) {
                        // handleUpdateResponse( response );
                    }
                } )
                .catch( function ( error ) {
                    errorHandling( error );
                } );

        }
};
