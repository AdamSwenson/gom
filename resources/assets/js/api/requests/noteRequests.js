//
// createItemNote: (item)=>{ return NOTES_BASE_ROUTE + '/item/' + item.id},
//     createExamNote: (exams)=>{ return NOTES_BASE_ROUTE + '/exams/' + exams.id},
//     updateNote: (note)=>{return NOTES_BASE_ROUTE  + '/' + note.id},
//     destroyNote: (note)=>{return NOTES_BASE_ROUTE + '/' + note.id},
//     getNotesForItem: (item)=>{return NOTES_BASE_ROUTE + '/item/' + item.id},
//     getNotesForExam: (exams) =>{return NOTES_BASE_ROUTE+ '/item/' + exams.id }
//    
//
import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT, Routes } from '../apiSettings';

import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Exam from '../../models/Exam'
import Item from '../../models/Item'
import Note from '../../models/Note'

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
    let payload = Payload.factory( { obj: note, mutateSilently: true } );
    payload.updateProp = 'id';
    payload.updateVal = data.id;
    store.commit( 'updateNote', payload );

    payload.updateProp = 'createdAt';
    payload.updateVal = data.created_at;
    store.commit( 'updateNote', payload );

    payload.updateProp = 'updated_at';
    payload.updateVal = data.updated_at;
    store.commit( 'updateNote', payload );

};

// /**
//  * Process the result of a response where we need to
//  * insert new notes into store
//  * @param store
//  * @param response
//  */
// const handleLoadResponse = ( store, itemOrExam, data ) => {
//     _.forEach( data, function ( r ) {
//         // window.console.log( 'noteRequests', 'r', 29, r );
//         let note = Note.factory( { r } );
//         note.id = r.id;
//         note.text = r.text;
//         note.priority = r.priority;
//         note.props = r.props;
//         note.updatedAt = r.updated_at;
//         note.createdAt = r.created_at;
//         note.name = r.name;
//         note.associatedItemSerialNumber = itemOrExam.serialNumber;
//         let payload = Payload.factory( { obj: note, mutateSilently: true } );
//         store.commit( 'createNote', payload );
//     } );
//
// };


const noteRequests = {

    createNoteRequest: ( store = null, note ) => {
        window.console.log( 'apiPlugin---noteRequests', 'createNoteRequest', note );
        let out = {
            requestVersion: REQUEST_VERSION,
            ...note
        };

        if ( !_.isNull( store ) ) {
            let associatedItemOrExam = store.getters.getItemBySerialNumber( note.associatedItemSerialNumber );

            if ( associatedItemOrExam ) {
                let route = associatedItemOrExam instanceof Exam ? Routes.createExamNote( associatedItemOrExam ) : Routes.createItemNote( associatedItemOrExam );

                window.axios
                    .post( route, out )
                    .then( ( response ) => {
                        // if ( response.data.length > 0 ) {
                        handleCreateResponse( store, note, response.data );
                        // }
                    } )
                    .catch( function ( error ) {
                        errorHandling( error );
                    } );
            }
        } else {
            let route = note.associatedObject instanceof Exam ? Routes.createExamNote( note.associatedObject ) : Routes.createItemNote( note.associatedObject );

            return window.axios
                .post( route, out )
                .then( ( response ) => {
                    return response.data;
                } )
                .catch( function ( error ) {
                    errorHandling( error );
                } );
        }
    },

    destroyNoteRequest: ( store = null, note ) => {
        let out = {
            requestVersion: REQUEST_VERSION,
            ...note
        };

        return window.axios
            .delete( Routes.destroyNote( note ), out )
            .then( ( response ) => {
                if ( response.data.length > 0 ) {
                    // this.$store.commit(mTypes.destroyNote, Payload.factory({obj: note}));
                    // handleUpdateResponse( response );
                }
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );

    },

    loadNotesForItemRequest: ( item ) => {
        let out = {
            requestVersion: REQUEST_VERSION
        };
        let route = item.isExam() ? Routes.getNotesForExam( item ) : Routes.getNotesForItem( item )
        return window.axios
            .get( route )
            .then( ( response ) => {
                return response.data
            } )
            .catch( function ( error ) {
                window.console.log( 'examRequests', 'ERROR', 39, error );
                errorHandling( error );
            } );
    },

    /**
     * Asks server to update stored intrinsic properties of
     * a note to match those of the object passed in as a param
     * @param store
     * @param note
     */
    updateNoteRequest: ( store, note ) => {

        let out = {
            requestVersion: REQUEST_VERSION,
            ...note
        };

        return window.axios
            .patch( Routes.updateNote( note ), out )
            .then( ( response ) => {
                if ( response.data.length > 0 ) {
                    // handleUpdateResponse( response );
                }
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },


};

export const { createNoteRequest, destroyNoteRequest, loadNotesForItemRequest, updateNoteRequest } = noteRequests;
