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

module.exports = {

    [ gTypes.getTagBySerialNumber ]: ( state, getters, rootState, serialNumber ) =>
        ( serialNumber ) => {
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
        let tags = getters[gTypes.getAllTags];
        // let serialNumber = (function ( state, id ) {
        var r = tags.filter( function ( i ) {
            if ( i.id === id ) {
                return i;
            }
        } );
        return r[0];
        // return r[ 0 ];
        // })( state, id );
        // let serialNumber = r[ 0 ];
        // window.console.log( 'tags', 'getTagById', 244, r, serialNumber);
        // return getTagBySerialNumber( state, serialNumber );
    },

    [ gTypes.getAllTags ]: ( state, getters, rootState ) => {
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

