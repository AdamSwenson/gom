//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import { testAction, description, factories } from '../../../helpers/vuex.spec.helpers';

import {
    addNodes,
    makeState,
    makeRootState,
    makeTestPayload,
    makeMutationPayload
} from '../../../helpers/items.tests.helpers'


//Dependencies
const orderings = require('../../../../../resources/assets/js/store/modules/items/items.order');
window.console.log( 'item.order.actions.spec', 'orderings', 19, orderings);
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import * as gTypes from '../../../../../resources/assets/js/store/getter-types'

import Item from '../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../resources/assets/js/models/Payload'
import Node from '../../../../../resources/assets/js/models/Node'

import { traverseDF, traverseBF, getSerialNumber } from '../../../../../resources/assets/js/models/NodeTools'

//tested object
let obj = orderings.default;
//tested methods
let { getters, actions, mutations, state } = obj;

describe( "store.modules.item.order actions ", function () {

    beforeEach( function () {
        this.numItems = 5;
        this.testItemIndex = faker.random.number( { min: 0, max: this.numItems - 1 } );
        this.filledState = { itemMap: new Node( 0, 0 ) };
        addNodes( this.filledState.itemMap, this.numItems );
        for (let n of this.filledState.itemMap.children) {
            addNodes( n, this.numItems );
        }
        window.console.log( 'orderings.spec', 'filledState', 34, this.filledState );

    } );


    describe( description( aTypes.addItemToOrder ), function () {
        describe( description( "happy paths" ), function () {
            it( "no index", function () {
                let parent = this.filledState.itemMap.children[ this.testItemIndex ];
                let getters = {
                    [gTypes.getItemNodeFromOrder]: () => {
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
                testAction( actions[ aTypes.addItemToOrder ], payload, this.filledState, expectedMutations, {
                    verbose: true,
                    getters: getters
                } );
            } );

            it( "with index", function () {
                let parent = this.filledState.itemMap.children[ this.testItemIndex ];
                let getters = {
                    [gTypes.getItemNodeFromOrder]: () => {
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
                testAction( actions[ aTypes.addItemToOrder ], payload, this.filledState, expectedMutations, {
                    verbose: true,
                    getters: getters
                } );
            } );
        } );
    } );

    describe( description( aTypes.removeItemFromOrder ), function () {
        describe( description( "happy paths" ), function () {
            it( "by serial number", function () {
                let toRemove = this.filledState.itemMap.children[ this.testItemIndex ];
                let parent = this.filledState.itemMap;
                let getters = {
                    [gTypes.getItemNodeFromOrder]: () => {
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
                testAction( actions[ aTypes.removeItemFromOrder ], payload, this.filledState, expectedMutations, {
                    verbose: true,
                    getters: getters
                } );

                //check that the method was called on the spy
                expect( spyGetter.verify() ).toBe( true );
            } );
        } );
    } );
} );
