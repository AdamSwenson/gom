/**
 * Created by adam on 7/6/17.
 */

import {REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT} from '../apiSettings';

import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Exam from '../../models/Exam'
import Item from '../../models/Item'

const ROUTE_BASE = 'comments';

const makeRoute = (item)=>{return ROUTE_BASE + '/' + item.id};

module.exports = {

    updateComment: ( store , item ) => {
        window.console.log( 'apiPlugin-commentRequests', 'updateComment', 8 );
        let out = {
            requestVersion: REQUEST_VERSION
        };

        if ( holdForIdLoading( item ) ) {
//copy so vuex doesn't yell
            let out = Object.assign( {}, item );
            out.requestVersion = REQUEST_VERSION;

            //put/patch
            window.axios
                .post( makeRoute(item), out )
                .then( ( response ) => {
                    // handleResponse( store, item, response );
                } )
                .catch( function ( error ) {
                    errorHandling( error );
                } );
        }
    }

}