
//The name of the tested component
var compName = 'items.order.actions';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.order.actions.js' );

require( '../../../../injectglobals' );

//tested object
import Item from '../../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../../resources/assets/js/models/Payload'
import Node from '../../../../../../resources/assets/js/models/Node'

import { traverseDF, traverseBF, getSerialNumber } from '../../../../../../resources/assets/js/models/NodeTools'
import { addNodes } from "../../../../helpers/item-test-helpers";

//tested object
let actions = Component;

const testAction = helpers.testAction;
const description = helpers.description;


describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let numItems, filledState, testItemIndex;
    
    beforeEach( () => {
            numItems = 5;
            testItemIndex = faker.random.number( { min: 0, max: numItems - 1 } );
            filledState = { itemMap: new Node( 0, 0 ) };
            addNodes( filledState.itemMap, numItems );
            for (let n of filledState.itemMap.children) {
                addNodes( n, numItems );
            }
            window.console.log( 'orderings.spec', 'filledState', 34, filledState );
        } );


        describe( aTypes.addItemToOrder , function () {
            describe( description( "happy paths" ), function () {
                it( "no index", function () {
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
                        verbose: true,
                        getters: getters
                    } );
                } );

                it( "with index", function () {
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
                        verbose: true,
                        getters: getters
                    } );
                } );
            } );
        } );

        describe( description( aTypes.removeItemFromOrder ), function () {
            describe( description( "happy paths" ), function () {
                it( "by serial number", function () {
                    let toRemove = filledState.itemMap.children[ testItemIndex ];
                    let parent = filledState.itemMap;
                    let getters = {
                        [ gTypes.getItemNodeFromOrder ]: () => {
                        }
                    };

                    // //now create a spy for the getters object it expects
                    let spyGetter = sinon.mock( getters, gTypes.getItemNodeFromOrder );
                    spyGetter.expects( gTypes.getItemNodeFromOrder ).withArgs( toRemove.data ).returns( toRemove );
                    spyGetter.expects( gTypes.getItemNodeFromOrder ).withArgs( toRemove.parent ).returns( parent );

                    //Expected endpoint
                    let expectedPayload = Payload.factory( { parent: parent, obj: toRemove } );

                    let expectedMutations = [
                        { type: mTypes.removeNodeFromOrder, payload: expectedPayload }
                    ];
                    // let payload = toRemove.serialNumber;
                    let payload = Payload.factory( { serialNumber: toRemove.data } );

                    //Checks that the appropriate mutations are called
                    testAction( actions[ aTypes.removeItemFromOrder ], payload, filledState, expectedMutations, {
                        verbose: true,
                        getters: getters
                    } );

                    //check that the method was called on the spy
                    expect( spyGetter.verify() ).toBe( true );
                } );
            } );
        } );
} );
