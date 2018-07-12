
//The name of the tested component
var compName = 'items.loaders';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.loaders.js' );


require( '../../../../injectglobals' );

import {makeFilledState} from "../../../../../spec/helpers/items.tests.helpers";

import { processItemObjectsFromJson } from "../../../../../../resources/assets/js/store/utlities/JsonHelpers";
import itemRequests from "../../../../../../resources/assets/js/api/requests/itemRequests";
import Node from "../../../../../../resources/assets/js/models/Node";
import Payload from "../../../../../../resources/assets/js/models/Payload";


//tested object
let {mutations,actions } = Component.default;

describe( compName, () => {
    let listOfValues, test;
    let data;
    let payload, exam, item, kumi, kumis, student, grade;

    let itemJson, itemOrderJson;
    beforeEach( () => {
        let data = JSON.parse('{"exam":{"id":12,"user_id":2,"term":null,"year":null,"name":"A","public_name":null,"description":null,"family":null,"locked":false,"released":false,"created_at":"2018-07-11 17:25:50","updated_at":"2018-07-11 17:25:57","previously_released":false},"itemObjects":[{"id":42,"name":"a1","text":"","displayText":null,"comment_text":null,"max_score":100,"settings":null,"exam_id":null,"user_id":2,"created_at":"2018-07-11 17:26:04","updated_at":"2018-07-11 17:26:07","deleted_at":null,"is_extra_credit":null,"comments":[],"tags":[]},{"id":43,"name":"a2","text":"","displayText":null,"comment_text":null,"max_score":100,"settings":null,"exam_id":null,"user_id":2,"created_at":"2018-07-11 17:26:14","updated_at":"2018-07-11 17:26:19","deleted_at":null,"is_extra_credit":null,"comments":[],"tags":[]},{"id":41,"name":"a","text":"","displayText":null,"comment_text":null,"max_score":100,"settings":null,"exam_id":null,"user_id":2,"created_at":"2018-07-11 17:25:58","updated_at":"2018-07-11 17:26:04","deleted_at":null,"is_extra_credit":null,"comments":[],"tags":[]}],"itemOrder":[{"examId":12,"itemId":42,"parentId":41,"itemOrder":0},{"examId":12,"itemId":43,"parentId":42,"itemOrder":0},{"examId":12,"itemId":41,"parentId":12,"itemOrder":0}]}');


        // let s = makeFilledState()

    } );


    describe( " actions", () => {

        it.skip('loadItemsFromPageJson', (  ) => {
        //
        // /**
        //  * Loads item object and item order data from json
        //  * representations in the data attributes of page elements.
        //  *
        //  * Then dispatches processAndStoreLoadedItems to do the actual
        //  * processing and storing of the obtained json objects.
        //  *
        //  * The payload is an object with properties items and order. Those
        //  * hold string names of the elements on the page holding the data.
        //  *
        //  */
        // loadItemsFromPageJson: ( { state, commit, dispatch, getters }, jsonLocations ) => {
        //     return new Promise( function ( resolve, reject ) {
        //
        //         let objectJson = readJsonFromPageString( jsonLocations.items );
        //         let orderJson = readJsonFromPageString( jsonLocations.order );
        //
        //         dispatch( 'processAndStoreLoadedItems', {
        //             itemObjectJson: objectJson,
        //             itemOrderJson: orderJson
        //         } ).then( function () {
        //             window.console.log( 'items.loaders', 'loadItemsFromPageJson', 58, 'done');
        //             resolve();
        //         } );
        //     } );
        // },
        //

        });

        it.skip('loadItemsFromServer', (  ) => {

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
        //     loadItemsFromServer: ( { state, commit, dispatch, getters }, exam ) => {
        //     return new Promise( function ( resolve, reject ) {
        //         //Make the request to the server and return the data
        //         //in the promise.
        //         let p = itemRequests.getItemsForExam( exam );
        //         p.then( function ( data ) {
        //             //The returned object  will have the keys
        //             //  'itemObjects'
        //             //  'itemOrder'
        //             let objectJson = data.itemObjects;
        //             let orderJson = data.itemOrder;
        //
        //             dispatch( 'processAndStoreLoadedItems', {
        //                 itemObjectJson: objectJson,
        //                 itemOrderJson: orderJson
        //             } ).then( function () {
        //                 resolve();
        //             } );
        //         } );
        //     } );
        // },

        });

        it('processAndStoreLoadedItems', (  ) => {

            let payload =  {
                itemObjectJson: data.itemObjects,
                itemOrderJson: data.itemOrder
            };

            window.console.log( 'items.loaders.test', 'd', 110, data.itemOrder);

            // /**
            //  * Once we have loaded some item data as json objects, from
            //  * either the server or a json on the page, this action
            //  * handles actually creating the Item objects and saving them
            //  * in the correct order.
            //  *
            //  * It takes as its payload an object with the properties: itemObjectJson
            //  * and itemOrderJson
            //  *
            //  * @param state
            //  * @param commit
            //  * @param dispatch
            //  * @param getters
            //  * @param objs {itemObjectJson, itemOrderJson}
            //  * @returns {Promise<any>}
            //  */
            // processAndStoreLoadedItems: ( { state, commit, dispatch, getters }, objs ) => {
            //     return new Promise( function ( resolve, reject ) {
            //
            //         let { itemObjectJson, itemOrderJson } = objs;
            //
            //         //Get a list of item objects from the data
            //         let items = processItemObjectsFromJson( itemObjectJson );
            //
            //         //push the item objects into state.items
            //         _.forEach( items, function ( item ) {
            //             commit( mTypes.addNewItem, Payload.factory( {
            //                 obj: item,
            //                 mutateSilently: true
            //             } ) );
            //         } );
            //
            //         //Store the order of the items
            //         _.forEach( itemOrderJson, function ( d, i ) {
            //             //if the parent is null, we are operating on the exam, so we can skip
            //             if ( d.parentId === null ) return true;
            //
            //             let item = getters[ gTypes.getItemById ]( d.itemId );
            //             let parentItem = getters[ gTypes.getItemById ]( d.parentId );
            //
            //             //Get or make the new node for the item's position
            //             let parentNode = getters[ gTypes.getItemNodeFromOrder ]( parentItem.serialNumber );
            //             let itemNode = new Node( item.serialNumber, parentNode.data );
            //
            //             //Add the new node to the order store
            //             let pl = Payload.factory( { objNode: itemNode, parentNode: parentNode } )
            //             commit( 'addNodeAsChild', pl );
            //         } );
            //
            //         resolve();
            //     } );
            // },
            //
        });



});

    describe( " mutations ", () => {

        it.skip( 'addNodeAsChild', () => {
            //
            // /**
            //  * Given a new child node and parent node, this
            //  * simply pushes the child node into the parent's children
            //  * array.
            //  * @param state
            //  * @param payload
            //  */
            // addNodeAsChild: ( state, payload ) => {
            //     let { objNode, parentNode } = payload;
            //     parentNode.children.push( objNode );
            // }
        } );
    } );

} );
