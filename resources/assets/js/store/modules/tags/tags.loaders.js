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


import { loadTagsForItemRequest } from '../../../api/requests/tagRequests';

module.exports = {
    actions: {

        loadTagsForItem: ( { state, dispatch, commit, getters }, itemOrExam ) => {
            return new Promise( function ( resolve, reject ) {
                return loadTagsForItemRequest( itemOrExam )
                    .then( function ( data ) {
                        _.forEach( data, function ( r ) {
                            //make sure we don't already have a tag
                            //object
                            let tag = getters.getTagById( r.id );

                            if ( _.isUndefined( tag ) ) {
                                tag = Tag.factory( { r } );
                                tag.id = r.id;
                                tag.text = r.text;
                                tag.props = r.props;
                                tag.name = r.name;
                                let payload = Payload.factory( { obj: tag, mutateSilently: true } );
                                commit( mTypes.createTag, payload );
                            }

                            if ( !_.isUndefined( r.items ) ) {
                                for (let i = 0; i < r.items.length; i++) {
                                    let item = getters.getItemById( r.items[ i ].id );
                                    if ( item ) commit( mTypes.associateTag, Payload.factory( {
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
                                commit( mTypes.associateTag, Payload.factory( {
                                    obj: itemOrExam,
                                    tag: tag,
                                    mutateSilently: true
                                } ) );
                            }
                        } );

                        resolve();
                    } );
            } );
        },


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

    }

};


