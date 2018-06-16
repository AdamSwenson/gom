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


import { loadAllUserTagsRequest, loadTagsForItemRequest } from '../../../api/requests/tagRequests';

module.exports = {
    actions: {
        /**
         * Requests all tags that the user has created from the server.
         * Saves all data centrally.
         * @param state
         * @param dispatch
         * @param commit
         * @param getters
         * @returns {Promise<any>}
         */
        loadAllUserTagsFromServer: ( { state, dispatch, commit, getters } ) => {
            return new Promise( function ( resolve, reject ) {

                let pp = loadAllUserTagsRequest();
                return pp.then( function ( data ) {
                    window.console.log( 'tags.loaders', 'data', 36);
                    _.forEach( data, ( tagData ) => {
                        // window.console.log( 'tags.loaders', 'tagdata', 38, tagData);
                        let tag = getters.getTagById( tagData.id );
                        if ( _.isUndefined( tag ) ) {
                            tag = Tag.factory( { tagData } );
                            //not sure why this is necessary. But without doing
                            //this explicitly, the factory will not set the properties
                            tag.id = tagData.id;
                            tag.name = tagData.name;
                            tag.props = tagData.props;
                            let payload = Payload.factory( { obj: tag, mutateSilently: true } );
                            window.console.log( 'tags.loaders', 'tag', 40, );

                            commit( mTypes.addTag, payload )
                        }
                    } );
                    resolve();
                } );
            } );
        },


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
                                commit( mTypes.addTag, payload );
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
         * When an item is loaded, its tags list contains bare objects
         * with tag data loaded from the db.
         * This replaces the bare object with a Tag object and
         * adds the Tag to the central store, if it wasn't already present.
         * @param state
         * @param dispatch
         * @param commit
         * @param getters
         * @param itemObject
         */
        processItemTags: ( { state, dispatch, commit, getters } ) => {
            return new Promise( function ( resolve, reject ) {
                // let items = state.items;

                let items = getters[ gTypes.getAllItems ];
                if ( items.length === 0 ) resolve();

                _.forEach( items, function ( item ) {
                    if ( item.tags.length > 0 ) {
                        for (let idx = 0; idx < item.tags.length; idx++) {
                            let tagData = item.tags[ idx ];
                            //try getting the pre-existing tag object
                            let tag = getters.getTagById( tagData.id );
                            //if the tag object doesn't already exist in the store
                            //create a new object
                            if ( _.isUndefined( tag ) ) {
                                // window.console.log( 'tags.loaders', 'tagData', 129, tagData);
                                tag = Tag.factory( { tagData } );
                                //not sure why this is necessary. But without doing
                                //this explicitly, the factory will not set the properties
                                tag.id = tagData.id;
                                tag.name = tagData.name;
                                tag.props = tagData.props;
                                let payload = Payload.factory( { obj: tag, mutateSilently: true } );
                                //add it to the central store, so we won't have to do this
                                //again
                                commit( mTypes.addTag, payload );
                            }
                            //Now replace the bare data object on the item with the Tag instance
                            let pl2 = Payload.factory( { index: idx, tag: tag, obj: item } );
                            commit( 'replaceBareObjectWithTag', pl2 );
                        }
                    }
                } );
                resolve();
            } );
        },


    },
    mutations:
        {
            replaceBareObjectWithTag: function ( state, payload ) {
                let { obj, index, tag } = payload;
                obj.tags[ index ] = tag;
            }

        }


};


