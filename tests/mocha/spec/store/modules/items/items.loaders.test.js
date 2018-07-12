//The name of the tested component
var compName = 'items.loaders';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.loaders.js' );


require( '../../../../injectglobals' );

import { makeFilledState } from "../../../../../spec/helpers/items.tests.helpers";

import { processItemObjectsFromJson } from "../../../../../../resources/assets/js/store/utlities/JsonHelpers";
import itemRequests from "../../../../../../resources/assets/js/api/requests/itemRequests";
import Node from "../../../../../../resources/assets/js/models/Node";
import Payload from "../../../../../../resources/assets/js/models/Payload";
import Item from "../../../../../../resources/assets/js/models/Item";

//tested object
let { mutations, actions } = Component.default;

describe( compName, () => {
    let listOfValues, test;
    let data;
    let payload, exam, item, kumi, kumis, student, grade;
    let getters;

    let itemJson, itemOrderJson, itemObjectJson, items;

    beforeEach( () => {
        data = JSON.parse( '{"exam":{"id":12,"user_id":2,"term":null,"year":null,"name":"A","public_name":null,"description":null,"family":null,"locked":false,"released":false,"created_at":"2018-07-11 17:25:50","updated_at":"2018-07-11 17:25:57","previously_released":false},"itemObjects":[{"id":42,"name":"a1","text":"","displayText":null,"comment_text":null,"max_score":100,"settings":null,"exam_id":null,"user_id":2,"created_at":"2018-07-11 17:26:04","updated_at":"2018-07-11 17:26:07","deleted_at":null,"is_extra_credit":null,"comments":[],"tags":[]},{"id":43,"name":"a2","text":"","displayText":null,"comment_text":null,"max_score":100,"settings":null,"exam_id":null,"user_id":2,"created_at":"2018-07-11 17:26:14","updated_at":"2018-07-11 17:26:19","deleted_at":null,"is_extra_credit":null,"comments":[],"tags":[]},{"id":41,"name":"a","text":"","displayText":null,"comment_text":null,"max_score":100,"settings":null,"exam_id":null,"user_id":2,"created_at":"2018-07-11 17:25:58","updated_at":"2018-07-11 17:26:04","deleted_at":null,"is_extra_credit":null,"comments":[],"tags":[]}],"itemOrder":[{"examId":12,"itemId":42,"parentId":41,"itemOrder":0},{"examId":12,"itemId":43,"parentId":42,"itemOrder":0},{"examId":12,"itemId":41,"parentId":12,"itemOrder":0}]}' );

        itemObjectJson = '{"exam":{"id":12,"user_id":2,"term":null,"year":null,"name":"A","public_name":null,"description":null,"family":null,"locked":false,"released":false,"created_at":"2018-07-11 17:25:50","updated_at":"2018-07-11 17:25:57","previously_released":false},"itemObjects":[{"id":42,"name":"a1","text":"","displayText":null,"comment_text":null,"max_score":100,"settings":null,"exam_id":null,"user_id":2,"created_at":"2018-07-11 17:26:04","updated_at":"2018-07-11 17:26:07","deleted_at":null,"is_extra_credit":null,"comments":[],"tags":[]},{"id":43,"name":"a2","text":"","displayText":null,"comment_text":null,"max_score":100,"settings":null,"exam_id":null,"user_id":2,"created_at":"2018-07-11 17:26:14","updated_at":"2018-07-11 17:26:19","deleted_at":null,"is_extra_credit":null,"comments":[],"tags":[]},{"id":41,"name":"a","text":"","displayText":null,"comment_text":null,"max_score":100,"settings":null,"exam_id":null,"user_id":2,"created_at":"2018-07-11 17:25:58","updated_at":"2018-07-11 17:26:04","deleted_at":null,"is_extra_credit":null,"comments":[],"tags":[]}]"';

        // itemOrderJson = '"itemOrder":[{"examId":12,"itemId":42,"parentId":41,"itemOrder":0},{"examId":12,"itemId":43,"parentId":42,"itemOrder":0},{"examId":12,"itemId":41,"parentId":12,"itemOrder":0}]}';

        items = [];
        _.forEach( data.itemOrder, function ( ord ) {
            let item = Item.factory( { id: ord.itemId } );
            items.push( item );
            if ( _.findIndex( items, { id: ord.parentId } ) === -1 ) {
                items.push( Item.factory( { id: ord.parentId } ) );
            }
        } );


        let spy = sinon.spy();
        getters = {
            [ gTypes.getItemById ]: ( id ) => {
                return items[ _.findIndex( items, { id: id } ) ];
            },
            [ gTypes.getItemNodeFromOrder ]: ( isn ) => ( isn ) => {
                return data.itemOrder[ _.findIndex( data.itemOrder, { itemId: isn } ) ]
            }
        };

    } );


    describe( " mutations ", () => {

        it( 'addNodeAsChild', () => {
            let objNode = new Node( 3 );
            let parentNode = new Node( 2 );

            mutations.addNodeAsChild( {}, { objNode, parentNode } );
            expect( parentNode.children.length ).toBe( 1 );
            expect( parentNode.children[ 0 ] ).toMatchObject( objNode );

        } );
    } );


    describe( " actions", () => {

        describe.skip( 'loadItemsFromPageJson', () => {
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

        } );

        describe.skip( 'loadItemsFromServer', () => {

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

        } );

        describe( 'processAndStoreLoadedItems', () => {
            //NB, because there are so many subsidiary tasks, I've
            //broken it up into helper functions.

            beforeEach( () => {} );


            it( " handleItems creates item objects from a json object", () => {
                let commit = sinon.spy();

                //call
                Component.handleItems( commit, {}, data.itemObjects );

                //check
                expect( commit.callCount ).toBe( data.itemObjects.length );

                _.forEach( commit.args, function ( call ) {
                    //called correct mutation
                    expect( call[ 0 ] ).toBe( mTypes.addNewItem );
                    //gave the mutation an item object
                    expect( call[ 1 ].obj instanceof Item ).toBeTruthy();
                    //did it silently
                    expect( data.itemObjects.includes( call[ 1 ].mutateSilently ) ).toBeFalsy();
                } );

            } );


            it( " handleNodes creates node objects from a json object", () => {
                let commit = sinon.spy();

                //call
                let results = Component.handleNodes( commit, getters, data.itemOrder );

                //check
                expect( results.length ).toBe( data.itemOrder.length );

                _.forEach( results, function ( r ) {
                    //created a node object
                    expect( r instanceof Node ).toBeTruthy();
                    //todo add test that node has correct attributes if needed....
                } );
            } );

            it( " handleAssociations creates the correct relationships", () => {

                //prep
                let commit = sinon.spy();
                //todo I know. Not really an atomic unit test. Whatevs....
                let nodes = Component.handleNodes( commit, getters, data.itemOrder );

                //call
                Component.handleAssociations( commit, getters, nodes );

                //check
                expect( commit.callCount ).toBe( data.itemOrder.length );
                _.forEach( commit.args, function ( call ) {
                    //called correct mutation
                    expect( call[ 0 ] ).toBe( 'addNodeAsChild' );
                } );

            } );

            it( " dispatches an action to process associated tags", (done) => {
                let spy = sinon.stub();
                spy.resolves(true);
                let spy2=sinon.spy();

                payload = {
                    itemObjectJson: data.itemObjects,
                    itemOrderJson: data.itemOrder
                };


                //call
                let p = actions.processAndStoreLoadedItems( {
                    state: {},
                    commit: spy2,
                    dispatch: spy,
                    getters
                }, payload );
                p.then( function () {
                    //something was dispatched
                    expect( spy.callCount ).toBe( 1 );
                    //that thing had the right name
                    expect( spy.args[ 0 ][ 0 ] ).toBe( 'processItemTags' )
                done();
                } );
            } );

        } );

    } );
} );
