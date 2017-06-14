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
import * as orderings from '../../../../../resources/assets/js/store/modules/items.order';

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

const makeFilledState = ( state, numItems = 5, testIndex = null ) => {
    addNodes( state.itemMap, numItems );
    for (let n of state.itemMap.children) {
        addNodes( n, numItems );
    }
};

fdescribe( "store.modules.item.order mutations  ", function () {

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

    describe( description( mTypes.removeNodeFromOrder ), function () {

        it( "happy path", function () {

            let parent = this.filledState.itemMap.children[ this.testItemIndex ];//.children[ this.testItemIndex ];
            let numChildren = parent.children.length;
            let toRemove = parent.children[ faker.random.number( { min: 0, max: parent.children.length - 1 } ) ];
            let toRemoveSerial = toRemove.data;
            let payload = { obj: toRemove, parent: parent };

            //call
            mutations[ mTypes.removeNodeFromOrder ]( this.filledState, payload );
            // window.console.log( 'orderings.spec', 'add', 76, this.filledState );

            //check
            let result = this.filledState.itemMap.children[ this.testItemIndex ];//.children[ this.testItemIndex ];
            ;
            //parent is unchanged other than children
            expect( parent.data ).toBe( result.data );
            expect( parent.parent ).toBe( result.parent );
            expect( parent.children.length ).toBe( numChildren - 1 );
            //make sure not in array
            for (let i = 0; i < parent.children; i++) {
                expect( parent.children[ i ].data ).not.toBe( toRemoveSerial );

            }
        } );
    } );

    describe( description( mTypes.insertNodeIntoOrder ), function () {

        describe( description( 'happy paths' ), function () {

            it( "no index set", function () {
                //Should just push onto the end of the parent's children
                //array

                let parent = this.filledState.itemMap.children[ this.testItemIndex ].children[ this.testItemIndex ];
                let numChildren = parent.children.length;
                let toAddSerial = faker.random.number();

                let toAdd = new Node( toAddSerial, parent.data ); //this step is handled by the action in the real code
                let payload = { obj: toAdd, parent: parent };

                //call
                mutations[ mTypes.insertNodeIntoOrder ]( this.filledState, payload );
                // window.console.log( 'orderings.spec', 'add', 76, this.filledState );

                //check
                let result = this.filledState.itemMap.children[ this.testItemIndex ].children[ this.testItemIndex ];
                //parent properties are unchanged (other than children)
                expect( result.data ).toBe( parent.data );
                expect( result.parent ).toBe( parent.parent );
                expect( result.children.length ).toBe( numChildren + 1 );
                //check the node we added
                let added = result.children[ result.children.length - 1 ];
                expect( added ).toBe( toAdd );
                // explicitly check that it has the parent's isn set properly
                expect( added.parent ).toBe( parent.data );

            } );

            it( "index set", function () {
                //Should splice into particular location of
                // the parent's children array
                let parent = this.filledState.itemMap.children[ this.testItemIndex ];//.children[ this.testItemIndex ];
                let numChildren = parent.children.length;
                let toAddSerial = faker.random.number();
                let toAdd = new Node( toAddSerial, parent.data ); //this step is handled by the action in the real code
                let index = faker.random.number( { min: 0, max: parent.children.length - 1 } )

                //call
                let payload = { index: index, obj: toAdd, parent: parent };
                mutations[ mTypes.insertNodeIntoOrder ]( this.filledState, payload );
                // window.console.log( 'orderings.spec', 'add', 76, this.filledState );

                //check
                let result = this.filledState.itemMap.children[ this.testItemIndex ];//children[ this.testItemIndex ];
                //parent properties are unchanged (other than children)
                expect( result.data ).toBe( parent.data );
                expect( result.parent ).toBe( parent.parent );
                expect( result.children.length ).toBe( numChildren + 1 );

                //check the node we added
                let added = result.children[ index ];
                expect( added.data ).toBe( toAddSerial );
                expect( added.children.length ).toBe( toAdd.children.length );
                // explicitly check that it has the parent's isn set properly
                expect( added.parent ).toBe( parent.data );
            } );

        } );

    } );

} );

describe( description( "actions" ), function () {
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
