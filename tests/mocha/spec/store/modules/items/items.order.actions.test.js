//The name of the tested component
var compName = 'items.order.actions';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.order.actions.js' );

require( '../../../../injectglobals' );

//tested object
import Item from '../../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../../resources/assets/js/models/Payload'
import Node from '../../../../../../resources/assets/js/models/Node'

import Requests  from '../../../../../../resources/assets/js/api/requests/itemRequests';

import { traverseDF, traverseBF, getSerialNumber } from '../../../../../../resources/assets/js/models/NodeTools'
import { addNodes } from "../../../../helpers/item-test-helpers";

//tested object
let actions = Component;

const testAction = helpers.testAction;
const description = helpers.description;

// let m = sinon.stub(  Requests, 'updateItemsOrder' );
// m.resolves(true);

describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let numItems, filledState, testItemIndex;

    beforeEach( () => {

        exam = factories.examFactory();
        numItems = 5;
        testItemIndex = faker.random.number( { min: 0, max: numItems - 1 } );
        filledState = { itemMap: new Node( 0, 0 ) };
        addNodes( filledState.itemMap, numItems );
        for (let n of filledState.itemMap.children) {
            addNodes( n, numItems );
        }
        // window.console.log( 'orderings.spec', 'filledState', 34, filledState );
    } );


    describe( aTypes.addItemToOrder, function () {
        it( "adds item to end of list when no index provided", function ( done ) {
            let parent = filledState.itemMap.children[ testItemIndex ];
            let getters = {
                [ gTypes.getItemNodeFromOrder ]: () => {
                }
            };
            let toAdd = new Item();

            //Expected endpoint
            let expectedPayload = Payload.factory( { parent: parent, obj: toAdd } );

            let expectedMutations = [
                { type: mTypes.insertNodeIntoOrder, payload: expectedPayload }
            ];
            // let payload = toRemove.serialNumber;
            let payload = Payload.factory( { obj: toAdd, parent: parent } );

            //Checks that the appropriate mutations are called
            testAction( actions[ aTypes.addItemToOrder ], payload, filledState, expectedMutations, {
                verbose: false,
                getters: getters,
                // done
            } );
            done();
        } );

        it( "adds the node at the specified index ", function ( done ) {

            let parent = filledState.itemMap.children[ testItemIndex ];
            let getters = {
                [ gTypes.getItemNodeFromOrder ]: () => {
                }
            };
            let toAdd = new Item();
            let index = faker.random.number();

            //Expected endpoint
            let expectedPayload = Payload.factory( { parent: parent, obj: toAdd, index: index } );

            let expectedMutations = [
                { type: mTypes.insertNodeIntoOrder, payload: expectedPayload }
            ];

            // let payload = toRemove.serialNumber;
            let payload = Payload.factory( {
                index: index,
                obj: toAdd,
                parent: parent
            } );

            //Checks that the appropriate mutations are called
            testAction( actions[ aTypes.addItemToOrder ], payload, filledState, expectedMutations, {
                verbose: false,
                getters: getters,
                // done
            } );
            done();
        } );

    } );

    describe( description( aTypes.removeItemFromOrder ), function () {
        it( "removes the node from the itemMap", function () {
            let toRemove = filledState.itemMap.children[ testItemIndex ];
            let parent = filledState.itemMap;
            let spyGetter = sinon.stub();
            spyGetter.onCall(0).returns(toRemove);
            spyGetter.onCall(1).returns(parent);

            let getters = {
                [ gTypes.getItemNodeFromOrder ]: spyGetter
            };

            //Expected endpoint
            let expectedPayload = Payload.factory( { parent: parent, obj: toRemove } );
            let expectedMutations = [
                { type: mTypes.removeNodeFromOrder, payload: expectedPayload }
            ];

            let payload = Payload.factory( { obj: toRemove } );

            //Checks that the appropriate mutations are called
            testAction( actions[ aTypes.removeItemFromOrder ], payload, filledState, expectedMutations, {
                verbose: false,
                getters: getters
            } );

            //check that the method was called on the spy
            expect( spyGetter.callCount ).toBe( 2 );

        } );
    } );

    describe( description( aTypes.updateItemOrder ), function () {
        it( "it dispatches appropriate methods", function ( done ) {
            let node = new Node( 2, 2 );
            let toRemove = filledState.itemMap.children[ testItemIndex ];
            let parent = filledState.itemMap;
            let getters = {
                [ gTypes.getItemNodeFromOrder ]: () => node,
                getOrderForSync: () => () => {
                },
                [ gTypes.getActiveExam ]: () => () => exam
            };


            let payloadType = 'promote';

            let expectedPayload = Payload.factory( { parent: parent, obj: toRemove, type: payloadType } );

            let expectedMutations = [
                { type: payloadType, payload: expectedPayload }
            ];


            testAction( actions[ aTypes.updateItemOrder ], payload, filledState, expectedMutations, {
                verbose: false,
                getters: getters
            } );
            done();
        } );
    } );
} );

//
// // //now create a spy for the getters object it expects
// let spyGetter = sinon.mock( getters, gTypes.getItemNodeFromOrder );
// spyGetter.expects( gTypes.getItemNodeFromOrder ).withArgs( toRemove.data ).returns( toRemove );
// spyGetter.expects( gTypes.getItemNodeFromOrder ).withArgs( toRemove.parent ).returns( parent );
//
// //Expected endpoint
// let expectedPayload = Payload.factory( { parent: parent, obj: toRemove } );
//
// let expectedMutations = [
//     { type: mTypes.removeNodeFromOrder, payload: expectedPayload }
// ];
// // let payload = toRemove.serialNumber;
// let payload = Payload.factory( { serialNumber: toRemove.data } );
//
// //Checks that the appropriate mutations are called
// testAction( actions[ aTypes.removeItemFromOrder ], payload, filledState, expectedMutations, {
//     verbose: true,
//     getters: getters
// } );
//
// //check that the method was called on the spy
// expect( spyGetter.verify() ).toBe( true );
