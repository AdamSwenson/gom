/**
 * Created by adam on 7/31/17.
 */
import Vue from 'vue';
import * as mTypes from '../../mutation-types'

module.exports = {
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
