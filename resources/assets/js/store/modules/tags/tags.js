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


import { loadTagsForItemRequest, handleLoadResponse } from '../../../api/requests/tagRequests';


const objectGetters = [
    gTypes.getItemBySerialNumber,
    gTypes.getNoteBySerialNumber
];

const getObjectBySerialNumber = ( getters, objectSerialNumber ) => {
    //We don't know what kind of
    //object this relates to, so
    //fall through the options
    //maybe later we could cache the types on
    //imodel

    for (let i = 0; i < objectGetters.length; i++) {
        let o = getters[ objectGetters[ i ] ]()
        if ( o > -1 ) {
            return o;
        }
    }

};


const getTagBySerialNumber = ( state, serialNumber ) => {
    return ( state, serialNumber ) => {
        var r = state.tags.filter( function ( i ) {
            if ( i.serialNumber === serialNumber ) {
                return i;
            }
        } );
        return r[ 0 ];
    }
};


const getTagSerialNumbersFromObjectSerialNumber = ( state, objectSerialNumber ) => {
    return (function ( state, serialNumber ) {
        if ( Object.keys( state.associations ).indexOf( serialNumber ) > -1 ) {
            return state.associations[ serialNumber ];
        }
    })( state, objectSerialNumber );
};

const state = {
    tags: [],

    /**
     * object serial numbers are the keys
     * the values are lists of tag serial numbers
     *
     * The storage has no notion of what sort of object
     * the serial number (key) corresponds to. If that is
     * needed, it should be handled elsewhere
     */
    associations: {}
};

const mutations = {
    [mTypes.createTag]: function ( state, payload ) {
        window.console.log( 'tags', 'createTag', 79, );
        return new Promise( ( resolve, reject ) => {
            let tag = payload.obj;
            state.tags.push( tag );
            resolve();
        } );

    },

    [mTypes.updateTag]: function ( state, payload ) {
        Vue.set( payload.obj, payload.updateProp, payload.updateVal );
    },

    [mTypes.destroyTag]: function ( state, payload ) {
        state.splice( state.tags.indexOf( payload.obj ), 1 );
    },


    [mTypes.associateTag]: function ( state, payload ) {
        // window.console.log( 'tags', mTypes.associateTag, 85, payload, state.associations );
        let objSn = payload.obj.serialNumber;
        let tagSn = payload.tag.serialNumber;

        if(_.isUndefined(tagSn)) return false;

        // /create an entry if one doesn't already exist
        if ( _.isUndefined( state.associations[ objSn ] ) ) {
            Vue.set( state.associations, objSn, [] );
        }

        //     //Tags should be unique. No duplicates
        if ( state.associations[ objSn ].indexOf( tagSn ) > -1 ) return true;

        //     //finally, we actually add it into the store
        state.associations[ objSn ].push( tagSn );
    },


    [ mTypes.disassociateTag ]: function ( state, payload ) {
        let objSn = payload.obj.serialNumber;
        let tagSn = payload.tag.serialNumber;
        let idx = state.associations[ objSn ].indexOf( tagSn );
        state.associations[ objSn ].splice( idx, 1 );
    }


};

const actions = {

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

const getters = {

    [gTypes.getTagBySerialNumber]: ( state, getters, rootState, serialNumber ) =>
        ( serialNumber ) =>
        {
            // [gTypes.getTagBySerialNumber]: ( state, getters, rootState, serialNumber ) => ( serialNumber ) => {
            window.console.log( 'tags', 'gtsn', 217, serialNumber, state );
            //return getTagBySerialNumber( state, serialNumber );
            return (function ( state, serialNumber ) {
                var r = state.tags.filter( function ( i ) {
                    if ( i.serialNumber === serialNumber ) {
                        return i;
                    }
                } );
                return r[ 0 ];
            })( state, serialNumber )
        },

    getTagById: ( state, getters, rootState, id ) => ( id ) => {
        // let serialNumber = (function ( state, id ) {
            var r = state.tags.filter( function ( i ) {
                if ( i.id === id ) {
                    return i;
                }
            } );
            // return r[ 0 ];
        // })( state, id );
      let serialNumber = r[0];
        // window.console.log( 'tags', 'getTagById', 244, r, serialNumber);
        return getTagBySerialNumber( state, serialNumber );
    },

    [gTypes.getAllTags ]: ( state, getters, rootState ) => {
        return state.tags;
    },

    /**
     * Returns all tag objects associated with  the object.
     * We don't need to know anything about the object
     * beyond its serial number.
     *
     * @param state
     * @param getters
     * @param rootState
     * @param object
     */
    [ gTypes.getTagsForObject ]: ( state, getters, rootState, object ) => ( object ) => {
//todo handle case where obj and case where sn
//         let osn = object;
        let osn = _.isNumber( object ) ? object : object.serialNumber;

        let tagSerialNumbers = state.associations[ osn ];
        // let tagSerialNumbers = getTagSerialNumbersFromObjectSerialNumber( state, osn );
        let out = [];

        // window.console.log( 'tags', 'tagSerialNumbers', 155, tagSerialNumbers, object );

        if ( !_.isUndefined( tagSerialNumbers ) && tagSerialNumbers.length > 0 ) {
            //look up tags and return them
            for (let i = 0; i < tagSerialNumbers.length; i++) {
                let tsn = tagSerialNumbers[ i ];
                let tag = getters.getTagBySerialNumber( tsn );
                out.push( tag );
            }
        }
        return out;
    },

    isObjectTagged: ( state, getters, rootState, object, tag ) => ( object, tag ) => {
        let tagSerialNumbers = state.associations[ object.serialNumber ];
        return _.includes( tagSerialNumbers, tag.serialNumber );
    }


};


export default {
    actions,
    getters,
    mutations,
    state,
}