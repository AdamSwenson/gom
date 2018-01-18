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
    EXAM_JSON_NAME,
    ITEM_ORDER_JSON_NAME,
    ITEM_OBJECT_JSON_NAME,
    processItemOrderFromJson,
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

                //Get a list of item objects from the data
                let items = processItemObjectsFromJson( objectJson );

                //push the item objects into state.items
                _.forEach( items, function ( item ) {
                    commit( mTypes.addNewItem, Payload.factory( {
                        obj: item,
                        mutateSilently: true
                    } ) );
                } );

                //Store the order of the items
                _.forEach( orderJson, function ( d, i ) {
                    //if the parent is null, we are operating on the exam, so we can skip
                    if ( d.parentId === null ) return true;

                    let item = getters[ gTypes.getItemById ]( d.itemId );
                    let parentItem = getters[ gTypes.getItemById ]( d.parentId );

                    //Get or make the new node for the item's position
                    let parentNode = getters[ gTypes.getItemNodeFromOrder ]( parentItem.serialNumber );
                    let itemNode = new Node( item.serialNumber, parentNode.data );

                    //Add the new node to the order store
                    let pl =  Payload.factory( { objNode: itemNode, parentNode: parentNode } )
                    commit( 'addNodeAsChild', pl );
                } );

                resolve();
            } );


        } );

    },


    /**
     * Reads the exam data from the data attribute of a page element
     * Options object may contain:
     *      Options.elementIds = { exam : the id of the element the data is located in}
     * Otherwise, it will use the default element id
     *
     * @param state
     * @param commit
     * @param dispatch
     * @param getters
     * @param options
     * @returns {Promise<any>}
     */
    loadExamFromPageJson: ( { state, commit, dispatch, getters }, options ) => {
        return new Promise( function ( resolve, reject ) {
            //Figure out what element id to use
            let pageElementId = EXAM_JSON_NAME; //options.elementIds.exam ? options.elementIds.exam : EXAM_JSON_NAME

            //Read the data from the page element and parse it into an object
            let examJson = readJsonFromPageString( pageElementId );

            //assume everything is there, just load directly
            let exam = Exam.factory( examJson );

            let pl = Payload.factory( {
                obj: exam,
                mutateSilently: true
            } );
            //Now that we have the exam loaded,
            //we need to do some stuff with it.
            //NB, since these call mutations, they happen
            //synchronously, thus no need to wrap in promises
            //First, we initialize the item store (which holds the
            //order of the items) with the exam
            me.$store.commit( mTypes.initializeItemStorage, pl );
            //Then we et the exam as the current exam
            me.$store.commit( mTypes.setActiveExam, pl );
            return exam;
            if ( exam ) {
                let pl = Payload.factory( { obj: exam, mutateSilently: true } );
                commit( mTypes.initializeItemStorage, pl );

                return resolve( exam );
            }

        } );

    },

    /**
     * These are actions which different parts of the gom
     * call to when they initialize.
     *
     */
    /** This is what gets run when the root instance is mounted for the setup page */
    loadItemsFromPageData:
        ( { state, commit, dispatch, getters }, options ) => {
            return new Promise( function ( resolve, reject ) {
                let objectPageElementId = options.elementIds.itemObjects ? options.elementIds.itemObjects : ITEM_OBJECT_JSON_NAME

                // window.console.log( 'JsonReaders', 'loadInitialData', 40, 'start loading');
                let objectData = readJsonFromPageString( ITEM_OBJECT_JSON_NAME );

                let orderData = readJsonFromPageString( ITEM_ORDER_JSON_NAME );

                let examData = readJsonFromPageString( EXAM_JSON_NAME );


                // window.console.log( 'JsonReaders', 'loadData', 46, state, objectData, examData, orderData );

                //load in the item objects
                processItemObjectsFromJson( objectData );

                //load in the order data
                processItemOrderFromJson( state, orderData );

                resolve();
            } );
            // window.console.log( 'JsonReaders', 'setupOnMount', 87, 'READY' );
        },


};

export default {
    actions,
    mutations,

}
