import * as mTypes from '../../store/mutation-types'
import * as aTypes from '../../store/action-types'
import * as gTypes from '../../store/getter-types'

import Node from "../../models/Node";
import { getNode } from "../../models/NodeTools";
import { getItem } from "../../store/utlities/itemHelpers";

import Payload from '../../models/Payload'
import Item from '../../models/Item'
import Exam from '../../models/Exam'

import itemRequests from "../../api/requests/itemRequests";

const processItemOrderFromJson = function ( state, orderData ) {

    _.forEach( orderData, function ( d, i ) {
        let item = (( state, d ) => {
            return getItem( state, d.itemId )
        })( state, d );
        //if the parent is null it is the exam, and we can skip
        if ( d.parentId === null ) return true;

        // these are top level
        //and should be added as children of the exam.
        //if the parent is null, we add the exam instead
        //todo this must be fixed since an item could have the same id as an exam
        let parentNode = (d.parentId === state.items[ 0 ].id) ? state.itemMap : (function ( state, d ) {
            let parentItem = getItem( state, d.parentId );
            return getNode( state, parentItem.serialNumber );
        })( state, d );

        let itemNode = new Node( item.serialNumber, parentNode.data );


//if an index was specified, splice it in at the index
//                 if ( !_.isUndefined( index ) ) {
//                     parentNode.children.splice( index, 0, itemNode );
//                 }
//                 else {
//otherwise just push it on the end
        parentNode.children.push( itemNode );
    } );

};

const processItemObjectFromJson = function ( state, objectData ) {
    _.forEach( objectData, function ( d, i ) {
        let item = Item.factory( d ); //.factory( {id: id, index: index} );
        item.loadCommentsFromJson( d.comments );
        state.items.push( item );
    } );
};

const mutations = {
    /** This is what gets run when the root instance is mounted for the setup page */
    [ mTypes.loadInitialData ]: ( state, payload ) => {
        return new Promise( function ( resolve, reject ) {

            // window.console.log( 'JsonReaders', 'loadInitialData', 40, 'start loading');
            let objectData = JSON.parse( document.getElementById( ITEM_OBJECT_JSON_NAME ).getAttribute( 'data' ) );

            let orderData = JSON.parse( document.getElementById( ITEM_ORDER_JSON_NAME ).getAttribute( 'data' ) );

            let examData = JSON.parse( document.getElementById( EXAM_JSON_NAME ).getAttribute( 'data' ) );


            // window.console.log( 'JsonReaders', 'loadData', 46, state, objectData, examData, orderData );

            //assume everything is there, just load directly
            let exam = Exam.factory( examData );

            //set it in items
            state.items[ 0 ] = exam;

            //initialize the order store
            state.itemMap = new Node( exam.serialNumber, exam.serialNumber );

            //load in the item objects
            processItemObjectFromJson( state, objectData );

            //load in the order data
            processItemOrderFromJson( state, orderData );

            resolve();
        } );
        // window.console.log( 'JsonReaders', 'setupOnMount', 87, 'READY' );
    },


    //todo move to more appropriate location once working
    initializeItemStore: ( state ) => {
        return new Promise( function ( resolve, reject ) {
            let exam = new Exam();
            state.items[ 0 ] = exam;
            state.itemMap = new Node( exam.serialNumber, exam.serialNumber );
            resolve();
        } );
    },

    saveItemsFromServer: ( state, payload ) => {
        processItemObjectFromJson( state, payload.obj );
    },

    saveOrderFromServer: ( state, payload ) => {

        processItemOrderFromJson( state, payload.obj );
    }
};

const actions = {

    loadItemsFromServer: ( { state, commit, dispatch, getters }, exam ) => {
        return new Promise( function ( resolve, reject ) {

            //ahem. initialize the store
            commit( 'initializeItemStorage', Payload.factory( { obj: exam } ) );

            //The returned array  will have the keys
            //  'itemObjects'
            //  'itemOrder'
            let p = itemRequests.getItemsForExam( exam );
            p.then( function ( data ) {

                //save the item objects
                commit( 'saveItemsFromServer', Payload.factory( {
                    obj: data.itemObjects,
                    mutateSilently: true
                } ) );

                //store their ordering
                commit( 'saveOrderFromServer', Payload.factory( {
                    obj: data.itemOrder,
                    mutateSilently: true
                } ) );

                resolve();
            } );


        } );

    }

};

export default {
    actions,
    mutations,

}
