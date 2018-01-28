import Node from "../../models/Node";
import Item from "../../models/Item";
import { getNode } from "../../models/NodeTools";
import { getItem, getItemFromPayload, buildPayloadFromInput } from './itemHelpers'

/**
 * These tools and ants are
 * used in managing json string data,
 * including data that has been loaded into
 * the page as a string
 */

module.exports = {
    EXAM_JSON_NAME: 'exam',
    ITEM_ORDER_JSON_NAME: 'order',
    ITEM_OBJECT_JSON_NAME: 'items',

//     processItemOrderFromJson: function ( state, orderData ) {
//
//         _.forEach( orderData, function ( d, i ) {
//             let item = (( state, d ) => {
//                 return getItem( state, d.itemId )
//             })( state, d );
//             //if the parent is null it is the exam, and we can skip
//             if ( d.parentId === null ) return true;
//
//             // these are top level
//             //and should be added as children of the exam.
//             //if the parent is null, we add the exam instead
//             //todo this must be fixed since an item could have the same id as an exam
//             let parentNode = (d.parentId === state.items[ 0 ].id) ? state.itemMap : (function ( state, d ) {
//                 let parentItem = getItem( state, d.parentId );
//                 return getNode( state, parentItem.serialNumber );
//             })( state, d );
//
//             let itemNode = new Node( item.serialNumber, parentNode.data );
//
//
// //if an index was specified, splice it in at the index
// //                 if ( !_.isUndefined( index ) ) {
// //                     parentNode.children.splice( index, 0, itemNode );
// //                 }
// //                 else {
// //otherwise just push it on the end
//             parentNode.children.push( itemNode );
//         } );
//
//     },

    /**
     * Given a json object containing server representations
     * of items, this will return an array of Item objects
     * @param objectData
     * @returns {Array}
     */
    processItemObjectsFromJson: function ( objectData ) {
        let items = [];
        _.forEach( objectData, function ( d, i ) {
            let item = Item.factory(d); //.factory( {id: id, index: index} );
            item.loadCommentsFromJson( d.comments );
            items.push( item );
        } );
        return items;
    },

    /**
     * When the server has stored data we need as a json string
     * in the data attribute of some page element, this reads it
     * and returns an object
     *
     * @param elementId
     * @returns {any}
     */
    readJsonFromPageString: function ( elementId ) {
        let e = document.getElementById( elementId ).getAttribute( 'data' );
        // window.console.log( 'feedback-page', 'loadJson', 66, e);
        let j = JSON.parse( e );
        // window.console.log( 'feedback-page', 'loadJson', 68, j);
        return j;
    }

}