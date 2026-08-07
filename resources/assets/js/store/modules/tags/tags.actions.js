/**
 * Created by adam on 7/31/17.
 */
import Vue from 'vue';
import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types';


import Payload from '../../../models/Payload'
import Item from '../../../models/Item'
import Exam from '../../../models/Exam'
import Student from '../../../models/Student'

import Tag from '../../../models/Tag'

import {
    associateTagRequest,
    createTagRequest,
    disassociateTagRequest,
    loadAllUserTagsRequest,
    loadTagsForItemRequest,
} from '../../../api/requests/tagRequests';

export default {
    /**
     * Creates a relationship between an existing tag and existing taggable
     * object
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @returns {Promise<any>}
     */
    associateTag: ( { state, dispatch, commit, getters }, { tag, obj } ) => {
        return new Promise( function ( resolve, reject ) {
            // send request to server to associate the tag with the object
            associateTagRequest( tag, obj )
                .then( function () {
                    let pl = Payload.factory( { obj, tag } );
                    //create the association locally
                    commit( mTypes.associateTag, pl );
                    resolve();
                } );
        } );
    },

    /**
     * Takes a newly created tag object and creates a record in the server.
     * The server returns an id, which we add to the tag before pushing
     * it into our central store.
     * The promise returns the tag object, with id
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @returns {Promise<any>}
     */
    createTag: ( { state, dispatch, commit, getters }, tag ) => {
        return new Promise( function ( resolve, reject ) {
            //sends request to create a new tag
            let p2 = createTagRequest( tag );
            p2.then( function ( data ) {
                //set the id from the server
                tag.id = data.id;
                //once it has been created on the server,
                //save it on the client (with id)
                let payload = Payload.factory( { obj: tag, mutateSilently: true } );
                commit( mTypes.addTag, payload )
                resolve( tag );
            } );
        } );
    },

    /**
     * Stores the new tag centrally, asks the server to create the tag,
     * then associates the tag with whatever object has been passed in
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param payload
     */
    createAndAssociateTag: ( { state, dispatch, commit, getters }, payload ) => {
        return new Promise( function ( resolve, reject ) {
            let { tag, obj } = payload;

            dispatch( 'createTag', tag )
                .then( function ( tag ) {
                    dispatch( 'associateTag', payload )
                        .then( function () {
                            resolve( tag );
                        } );
                } );
        } );
    },

};

