//
// createItemTag: (item)=>{ return TAGS_BASE_ROUTE + '/item/' + item.id},
//     createExamTag: (exam)=>{ return TAGS_BASE_ROUTE + '/exam/' + exam.id},
//     updateTag: (tag)=>{return TAGS_BASE_ROUTE  + '/' + tag.id},
//     destroyTag: (tag)=>{return TAGS_BASE_ROUTE + '/' + tag.id},
//     getTagsForItem: (item)=>{return TAGS_BASE_ROUTE + '/item/' + item.id},
//     getTagsForExam: (exam) =>{return TAGS_BASE_ROUTE+ '/item/' + exam.id }
//    
//
import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT, Routes } from '../apiSettings';

import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Exam from '../../models/Exam'
import Item from '../../models/Item'
import Student from '../../models/Student'

import Tag from '../../models/Tag'

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
const handleCreateResponse = ( store, tag, data ) => {
    // window.console.log( 'tagRequests', 'r', 29, r );
    let payload = Payload.factory( { obj: tag, mutateSilently: true } );
    payload.updateProp = 'id';
    payload.updateVal = data.id;
    store.commit( mTypes.updateTag, payload );
};

/**
 * Process the result of a response where we need to
 * insert new tags into store
 * @param store
 * @param response
 */
const handleLoadResponse = ( store, data, itemOrExam ) => {
    // window.console.log( 'tagRequests', 'handleLoadResponse', 48, store );
    _.forEach( data, function ( r ) {
        // window.console.log( 'tagRequests', 'r', 29, r );

        //make sure we don't already have a tag
        //object
        let tag = store.getters.getTagById( r.id );
        // window.console.log( 'tagRequests', 'tag', 55, tag);

        if ( _.isUndefined( tag ) ) {
            tag = Tag.factory( { r } );
            tag.id = r.id;
            tag.text = r.text;
            tag.props = r.props;
            tag.name = r.name;
            let payload = Payload.factory( { obj: tag, mutateSilently: true } );
            store.commit( mTypes.createTag, payload );
        }

        if ( !_.isUndefined( r.items ) ) {
            for (let i = 0; i < r.items.length; i++) {
                let item = store.getters.getItemById( r.items[ i ].id );
                if ( item ) store.commit( mTypes.associateTag, Payload.factory( {
                    obj: item,
                    tag: tag,
                    mutateSilently: true
                } ) );
            }

        }

        if ( !_.isUndefined( r.exams ) ) {
            // let item = store.getters.getExamById( r.pivot.exam_id );
            // if ( item ) store.commit( mTypes.associateTag, Payload.factory( { obj: item, tag: tag } ) );
        }


        //if we were given an object to query,
        // we will associate it with the tag
        else if ( itemOrExam ) {
            store.commit( mTypes.associateTag, Payload.factory( { obj: itemOrExam, tag: tag, mutateSilently: true } ) );
        }

    } );

};


module.exports = {

    associateTagRequest: ( store, tag, object ) => {
        let out = {
            requestVersion: REQUEST_VERSION
        };
        window.console.log( 'tagRequests', 'associateTagRequest', 100, object );

        if ( object.kind === 'item' ) {
            window.axios
                .post( Routes.tagItem( object, tag ), out )
                .then( ( response ) => {
                } )
                .catch( function ( error ) {
                    errorHandling( error );
                } );
            return true;
        }


        switch ( object ) {
            case object.kind === 'item':
                window.axios
                    .post( Routes.tagItem( object, tag ), out )
                    .then( ( response ) => {
                    } )
                    .catch( function ( error ) {
                        errorHandling( error );
                    } );
                break;
            case object instanceof Item:
                window.axios
                    .post( Routes.tagItem( object, tag ), out )
                    .then( ( response ) => {
                    } )
                    .catch( function ( error ) {
                        errorHandling( error );
                    } );
                break;

            case object instanceof Exam:
                window.axios
                    .post( Routes.tagExam( object, tag ), out )
                    .then( ( response ) => {
                    } )
                    .catch( function ( error ) {
                        errorHandling( error );
                    } );
                break;
            case object instanceof Student:
                window.axios
                    .post( Routes.tagStudent( object, tag ), out )
                    .then( ( response ) => {
                    } )
                    .catch( function ( error ) {
                        errorHandling( error );
                    } );
                break;
            default:
        }
    },

    disassociateTagRequest: ( store, tag, object ) => {
        switch ( object ) {
            case object instanceof Item:
            case object instanceof Item:
                window.axios
                    .delete( Routes.tagItem( object, tag ), out )
                    .then( ( response ) => {
                    } )
                    .catch( function ( error ) {
                        errorHandling( error );
                    } );
                break;

            case object instanceof Exam:
                window.axios
                    .delete( Routes.tagExam( object, tag ), out )
                    .then( ( response ) => {
                    } )
                    .catch( function ( error ) {
                        errorHandling( error );
                    } );
                break;
            case object instanceof Student:
                window.axios
                    .delete( Routes.tagStudent( object, tag ), out )
                    .then( ( response ) => {
                    } )
                    .catch( function ( error ) {
                        errorHandling( error );
                    } );
                break;
            default:
        }
    },

    createTagRequest: ( store, tag ) => {
        window.console.log( 'apiPlugin---tagRequests', 'createTagRequest', tag );
        let out = {
            requestVersion: REQUEST_VERSION,
            ...tag
        };

        window.axios
            .post( Routes.createTag(), out )
            .then( ( response ) => {
                // if ( response.data.length > 0 ) {
                handleCreateResponse( store, tag, response.data );
                // }
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    destroyTagRequest: ( store, tag ) => {
        let out = {
            requestVersion: REQUEST_VERSION,
            ...tag
        };

        window.axios
            .delete( Routes.destroyTag( tag ), out )
            .then( ( response ) => {
                if ( response.data.length > 0 ) {
                    // handleUpdateResponse( response );
                }
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );

    },

    /**
     * Gets all tags belonging to the user from the
     * server
     *
     * If store is null, it will return an
     * array of tag objects once the promise has
     * resolved.
     * If store is filled with a store object, it
     * will load them into storage.
     * @param store
     */
    loadAllUserTagsRequest: ( store = null ) => {
        return window.axios
            .get( Routes.getAllUserTags() )
            .then( ( response ) => {
                window.console.log( 'loadAllUserTagsRequest', '', 195, response );
                if ( !_.isNull( store ) ) {
                    handleLoadResponse( store, response.data );
                }
                else {
                    let tags = [];
                    _.forEach( response.data, ( t ) => {
                        tags.push( Tag.factory( t ) );
                    } );
                    return tags;
                }
            })
            .catch( function ( error ) {
                window.console.log( 'examRequests', 'ERROR', 39, error );
                errorHandling( error );
            } );
    },

    /**
     * Gets the tags for the item.
     * If store is null, it will return an
     * array of tag objects once the promise has
     * resolved.
     * If store is filled with a store object, it
     * will load them into storage.
     * @param store
     * @param item
     * @returns {Promise.<T>|*}
     */
    loadTagsForItemRequest: ( store = null, item ) => {
        let out = {
            requestVersion: REQUEST_VERSION
        };

        return window.axios
            .get( Routes.getTagsForItem( item ) )
            .then( ( response ) => {
                window.console.log( 'loadTagsForItemRequest', '', 213, response );
                if ( !_.isNull( store ) ) {
                    handleLoadResponse( store, response.data, item );
                } else {
                    let tags = [];
                    _.forEach( response.data, ( t ) => {
                        tags.push( Tag.factory( t ) );
                    } );
                    return tags;
                }

            } )
            .catch( function ( error ) {
                window.console.log( 'examRequests', 'ERROR', 39, error );
                errorHandling( error );
            } );
    },

    /**
     * Asks server to update stored intrinsic properties of
     * a tag to match those of the object passed in as a param
     * @param store
     * @param tag
     */
    updateTagRequest:
        ( store, tag ) => {

            let out = {
                requestVersion: REQUEST_VERSION,
                ...tag
            };

            window.axios
                .patch( Routes.updateTag( tag ), out )
                .then( ( response ) => {
                    if ( response.data.length > 0 ) {
                        // handleUpdateResponse( response );
                    }
                } )
                .catch( function ( error ) {
                    errorHandling( error );
                } );
        },


}
;
