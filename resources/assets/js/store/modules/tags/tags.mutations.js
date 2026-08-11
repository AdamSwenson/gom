/**
 * Created by adam on 7/31/17.
 */
import Vue from 'vue';
import * as mTypes from '../../mutation-types'

export default {
    /**
     * Adds a tag object to the client's central store
     * @param state
     * @param payload
     */
    [ mTypes.addTag ]: function ( state, payload ) {
        let tag = payload.obj;
        state.tags.push( tag );
    },

    /**
     * Updates properties of the tag
     * @param state
     * @param payload
     */
    [ mTypes.updateTag ]: function ( state, payload ) {
        Vue.set( payload.obj, payload.updateProp, payload.updateVal );
    },

    /**
     * Remove tag from central store. Does not remove tag from
     * any items it is associated with
     * @param state
     * @param payload
     */
    [ mTypes.destroyTag ]: function ( state, payload ) {

        let idx = _.findIndex( state.tags, payload.obj );
        state.tags.splice( idx, 1 );
    },


    /**
     * Update the taggable object's tags list to
     * contain the tag
     * @param state
     * @param payload
     * @returns {boolean}
     */
    [ mTypes.associateTag ]: function ( state, payload ) {
        // window.console.log( 'tags', mTypes.associateTag, 85, payload, state.associations );
        // let objSn = payload.obj.serialNumber;
        // let tagSn = payload.tag.serialNumber;

        let { tag, obj } = payload;
        obj.tags.push( tag );

        // if(_.isUndefined(tagSn)) return false;
        //
        // // /create an entry if one doesn't already exist
        // if ( _.isUndefined( state.associations[ objSn ] ) ) {
        //     Vue.set( state.associations, objSn, [] );
        // }
        //
        // //     //Tags should be unique. No duplicates
        // if ( state.associations[ objSn ].indexOf( tagSn ) > -1 ) return true;
        //
        // //     //finally, we actually add it into the store
        // state.associations[ objSn ].push( tagSn );
    },


    [ mTypes.disassociateTag ]: function ( state, payload ) {
        payload.obj.tags.splice( _.findIndex( payload.obj.tags, payload.tag ), 1 );

        // let objSn = payload.obj.serialNumber;
        // let tagSn = payload.tag.serialNumber;
        // let idx = state.associations[ objSn ].indexOf( tagSn );
        // state.associations[ objSn ].splice( idx, 1 );
    }


};
