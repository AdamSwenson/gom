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



module.exports = {

    /**
     * When an item is loaded, it has an object of
     * tags from the db. These need to be matched up
     * with the client storage of tags
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param itemObject
     */
    processItemTags: ( { state, dispatch, commit, getters }, itemObject ) => {
        if ( itemObject.tags.length === 0 ) return true;

        _.forEach( itemObject.tags, function ( r ) {
            // window.console.log( 'tagRequests', 'r', 29, r );

            //make sure we don't already have a tag
            //object
            let tag = getters.getTagById( r.id );
            // window.console.log( 'tagRequests', 'tag', 55, tag);

            //if the tag doesn't already exist
            //we create it
            if ( _.isUndefined( tag ) ) {
                tag = Tag.factory( { r } );
                tag.id = r.id;
                tag.text = r.text;
                tag.props = r.props;
                tag.name = r.name;
                let payload = Payload.factory( { obj: tag, mutateSilently: true } );
                commit( mTypes.createTag, payload );
            }

            //now we associate the item with the tag
            commit( mTypes.associateTag, Payload.factory( {
                obj: itemObject,
                tag: tag,
                mutateSilently: true
            } ) );
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
        let sendRequest = ( object, tag ) => {
            window.console.log( 'tags', 'sendRequest', 170, );
            //If the menu is attached to an object, create an association
            if ( object ) {
                commit( mTypes.associateTag, Payload.factory( {
                    obj: object,
                    tag: tag
                } ) );
            }
        };

        let { obj, tag } = payload;

        let p = commit( mTypes.createTag, Payload.factory( { obj: tag } ) );

        // p.then( ( object, tag ) => {
        if ( tag.id > -1 ) {
            window.console.log( 'tags', 'createAndAssociateTag', 183, 'id set', obj, tag );
            sendRequest( obj, tag );
        }
        else {
            setTimeout( function () {
                window.console.log( 'tags', 'not set', 188, obj, tag );
                sendRequest( obj, tag )
            }, 5000 )

        }


        // } );

    }

};
