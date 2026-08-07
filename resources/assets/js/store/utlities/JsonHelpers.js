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

const JsonHelpers = {
    EXAM_JSON_NAME: 'exam',
    ITEM_ORDER_JSON_NAME: 'order',
    ITEM_OBJECT_JSON_NAME: 'items',


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

};

export default JsonHelpers;
export const { EXAM_JSON_NAME, ITEM_ORDER_JSON_NAME, ITEM_OBJECT_JSON_NAME, processItemObjectsFromJson, readJsonFromPageString } = JsonHelpers;
