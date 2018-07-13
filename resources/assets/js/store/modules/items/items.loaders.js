import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types'

import Node from "../../../models/Node";
import { getNode } from "../../../models/NodeTools";
import { getItem } from "../../utlities/itemHelpers";

import Payload from '../../../models/Payload'
import Item from '../../../models/Item'
import Exam from '../../../models/Exam'

//these are originally defined in jsonReaders

import {
    processItemObjectsFromJson,
    readJsonFromPageString
} from '../../utlities/JsonHelpers';


import itemRequests from "../../../api/requests/itemRequests";


const mutations = {


    /**
     * Given a new child node and parent node, this
     * simply pushes the child node into the parent's children
     * array.
     * @param state
     * @param payload
     */
    addNodeAsChild: ( state, payload ) => {
        let { objNode, parentNode } = payload;
        parentNode.children.push( objNode );
    }
};

const actions = {
    /**
     * Loads item object and item order data from json
     * representations in the data attributes of page elements.
     *
     * Then dispatches processAndStoreLoadedItems to do the actual
     * processing and storing of the obtained json objects.
     *
     * The payload is an object with properties items and order. Those
     * hold string names of the elements on the page holding the data.
     *
     */
    loadItemsFromPageJson: ( { state, commit, dispatch, getters }, jsonLocations ) => {
        return new Promise( function ( resolve, reject ) {

            let objectJson = readJsonFromPageString( jsonLocations.items );
            let orderJson = readJsonFromPageString( jsonLocations.order );

            dispatch( 'processAndStoreLoadedItems', {
                itemObjectJson: objectJson,
                itemOrderJson: orderJson
            } ).then( function () {
                window.console.log( 'items.loaders', 'loadItemsFromPageJson', 58, 'done' );
                resolve();
            } );
        } );
    },


    /**
     * Requests item object and item order data from the server
     * for the given exam.
     *
     * Then dispatches processAndStoreLoadedItems to do the actual
     * processing and storing of the obtained json objects.
     *
     * @param state
     * @param commit
     * @param dispatch
     * @param getters
     * @param exam Exam
     * @returns {Promise<any>}
     */
    loadItemsFromServer: ( { state, commit, dispatch, getters }, exam ) => {
        return new Promise( function ( resolve, reject ) {
            //Make the request to the server and return the data
            //in the promise.
            let p = itemRequests.getItemsForExam( exam );
            p.then( function ( data ) {
                //The returned object  will have the keys
                //  'itemObjects'
                //  'itemOrder'
                let objectJson = data.itemObjects;
                let orderJson = data.itemOrder;

                dispatch( 'processAndStoreLoadedItems', {
                    itemObjectJson: objectJson,
                    itemOrderJson: orderJson
                } ).then( function () {
                    return resolve();
                } );
            } );
        } );
    },


    /**
     * Once we have loaded some item data as json objects, from
     * either the server or a json on the page, this action
     * handles actually creating the Item objects and saving them
     * in the correct order.
     *
     * It takes as its payload an object with the properties: itemObjectJson
     * and itemOrderJson
     *
     * NB, this is broken up into a series of helper functions which carry out
     * the subsidiary tasks. This is to make testing and maintenance easier.
     *
     * @param state
     * @param commit
     * @param dispatch
     * @param getters
     * @param objs {itemObjectJson, itemOrderJson}
     * @returns {Promise<any>}
     */
    processAndStoreLoadedItems: ( { state, commit, dispatch, getters }, objs ) => {
        return new Promise( function ( resolve, reject ) {

            let { itemObjectJson, itemOrderJson } = objs;

            let items = handleItems( commit, getters, itemObjectJson );
            //We're first going to go through and make a bunch of nodes.
            //Then we'll figure out how to get them into the store correctly
            let nodes = handleNodes( commit, getters, itemOrderJson );

            //now that we are assured that we have all the nodes created
            //we can go back through the list of nodes and push them into their
            //respective parents.
            //This should maintain relative order at each level, assuming that the
            //server sent everything in order.
            handleAssociations( commit, getters, nodes );

            //Finally, each loaded Item has a tags list which contains
            //bare data objects. This action replaces the
            //data objects with Tag objects from the central store
            let p3 = dispatch( 'processItemTags' );
            p3.then( () => {
                resolve();
            } );
        } );
    },


};

/* ++++++++++++++++++++++++++
The following are all components of the above methods. They were broken out
to make testing and maintenance easier.

They are not meant to be called on their own.
Thus while they are exported to make it easier to test them,
they are only actually used in this file.
++++++++++++++++++++++++++ */


/**
 * Consumes a list of node objects and stores the
 * associations which they represent.
 *
 * @param commit
 * @param getters
 * @param items
 * @param nodes
 */
export const handleAssociations = ( commit, getters, nodes ) => {
    //now that we are assured that we have all the nodes created
    //we can go back through the list of nodes and push them into their
    //respective parents.
    //This should maintain relative order at each level, assuming that the
    //server sent everything in order.
    _.forEach( nodes, function ( node ) {
        let parentNode = nodes[ _.findIndex( nodes, { data: node.parent } ) ];

        if ( _.isUndefined( parentNode ) ) {
            //this is the exam
            parentNode = getters[ gTypes.getItemNodeFromOrder ]( node.parent );
        }

        //Add the new node to the order store
        let pl = Payload.factory( { objNode: node, parentNode: parentNode } )
        commit( 'addNodeAsChild', pl );
    } );

}

/**
 * Subtask of processAndStoreLoadedItems
 *
 * Consumes a list of generic objects from the incoming
 * json, creates Items from them, and stores the items
 *
 * @param state
 * @param commit
 * @param dispatch
 * @param getters
 * @param itemObjectJson
 * @returns {Promise<any>}
 */
export const handleItems = ( commit, getters, itemObjectJson ) => {
    //Get a list of item objects from the data
    let items = processItemObjectsFromJson( itemObjectJson );

    //push the item objects into state.items
    _.forEach( items, function ( item ) {
        commit( mTypes.addNewItem, Payload.factory( {
            obj: item,
            mutateSilently: true
        } ) );
    } );

    return items;
}

/**
 * Consumes the json item order object and
 * creates the relevant nodes.
 * Does not associate them with each other.
 * @param state
 * @param commit
 * @param dispatch
 * @param getters
 * @param itemOrderJson
 * @returns list
 */
export const handleNodes = ( commit, getters, itemOrderJson ) => {
    let nodes = [];

    _.forEach( itemOrderJson, function ( d, i ) {
        //if the parent is null, we are operating on the exam, so we can skip
        if ( d.parentId === null ) return true;

        let item = getters[ gTypes.getItemById ]( d.itemId );
        let parentItem = getters[ gTypes.getItemById ]( d.parentId );

        //Make the new node with the item serial number
        let itemNode = new Node( item.serialNumber, parentItem.serialNumber );
        nodes.push( itemNode );
    } );

    return nodes;

};


export default {
    actions,
    mutations,

}
