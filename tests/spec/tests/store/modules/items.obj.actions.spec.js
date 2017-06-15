//test libraries
require( 'jasmine-jquery' );
import sinon from 'sinon';
let faker = require( 'faker' );

import { testAction, description, factories } from '../../../helpers/vuex.spec.helpers';

import {makeState, makeTestPayload, makeMutationPayload} from '../../../helpers/items.tests.helpers'



//Dependencies
import * as items from '../../../../../resources/assets/js/store/modules/items';

//tested object
let obj = items.default;
//tested methods
let { getters, actions, mutations } = obj;

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Item from '../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../resources/assets/js/models/Payload'


//tested object
// let obj = items.default;
// //tested methods
// let { getters, actions, mutations } = obj;

fdescribe( "store.modules.items.obj actions ", function () {
    beforeEach(function(){

    });

    afterEach(function(){

    });

    xdescribe( description( aTypes.addOlderSibling ), function () {
        //todo
        xit( "happy path  ", function () {

            let state = [];
            state[ 0 ] = { index: 0 };
            state[ 1 ] = { index: 1 };
            //leaves a hole at state[2]
            state[ 3 ] = { index: 3 };

            let action = actions[ aTypes.cleanupItems ];
            let expectedMutations = [
                { type: 'cleanupEmptyItems' },
                { type: mTypes.updateOrder, }
            ];

            testAction( action, {}, state, expectedMutations, { verbose: true } );
        } );
    } );

    xdescribe( description( aTypes.addYoungerSibling ), function () {
        //todo
        xit( "happy path  ", function () {

            let state = [];
            state[ 0 ] = { index: 0 };
            state[ 1 ] = { index: 1 };
            //leaves a hole at state[2]
            state[ 3 ] = { index: 3 };

            let action = actions[ aTypes.cleanupItems ];
            let expectedMutations = [
                { type: 'cleanupEmptyItems' },
                { type: mTypes.updateOrder, }
            ];

            testAction( action, {}, state, expectedMutations, { verbose: true } );
        } );
    } );

    describe( description( aTypes.cleanupItems ), function () {
        it( "happy path  ", function () {

            let state = [];
            state[ 0 ] = { index: 0 };
            state[ 1 ] = { index: 1 };
            //leaves a hole at state[2]
            state[ 3 ] = { index: 3 };

            let action = actions[ aTypes.cleanupItems ];
            window.console.log( 'items.actions.spec', '', 109, actions );
            window.console.log( 'items.actions.spec', 'action', 109, action );
            let expectedMutations = [
                { type: 'cleanupEmptyItems' },
                { type: mTypes.updateOrder, }
            ];

            testAction( action, {}, state, expectedMutations, { verbose: true } );
        } );

    } );

    describe( description( aTypes.deleteItem ), function () {
        //todo
    } );

    describe( description( aTypes.demoteItem ), function () {
        it( "happy path  ", function () {
            let state = makeState();
            //let index = faker.random.arrayElement(state.items.keys());
            let index = 1;
            let item = state.items[index];

            //we can use the same object as both the input and
            //expected result because the tested process returns a
            //different token that has the same props
            let payload = Payload.factory( { index: index } );

            //create a spy for the item that will be retrieved and promoted
            let spyItem = sinon.mock( item );
            spyItem.expects( 'demote' ).once();

            //now create a spy for the getters object it expects
            let spyGetter = sinon.mock( getters, 'getItemByIndex' );
            spyGetter.expects( 'getItemByIndex' ).withArgs( index ).returns( item );

            //Expected endpoint
            let action = actions[ aTypes.demoteItem ];
            let expectedPayload = Payload.factory( { obj: item } );
            let expectedMutations = [
                { type: mTypes.setItem, payload: expectedPayload }
            ];

            //Checks that the appropriate mutations are called
            testAction( action, payload, state, expectedMutations, { verbose: true, getters: getters } );

            //check that the promote method was called on the spy
            expect( spyItem.verify() ).toBe( true );
            expect( spyGetter.verify() ).toBe( true );
        } );

    } );

    describe( description( aTypes.onUpdate ), function () {
        it( "happy path  ", function () {
            let event = sinon.spy();
            let state = {};
            let action = actions[ aTypes.onUpdate ];
            let expectedMutations = [
                { type: aTypes.onUpdate, payload: event },
                { type: mTypes.updateOrder }
            ];

            testAction( action, event, state, expectedMutations, { verbose: true } );
        } );


    } );

    describe( description( aTypes.promoteItem ), function () {

        it( "happy path  ", function () {
            let state = makeState();
            //let index = faker.random.arrayElement(state.items.keys());
            let index = 1;
            let item = state.items[index];

            //we can use the same object as both the input and
            //expected result because the tested process returns a
            //different token that has the same props
            let payload = Payload.factory( { index: index } );

            //create a spy for the item that will be retrieved and promoted
            // let item = state.items[ index ];
            window.console.log( 'items.actions.spec', 'item', 164, item );
            let spyItem = sinon.mock( item );
            spyItem.expects( 'promote' ).once();
            // //replace the original with the spy
            // state.items[index] = item;

            //now create a spy for the getters object it expects
            let spyGetter = sinon.mock( getters, 'getItemByIndex' );
            spyGetter.expects( 'getItemByIndex' ).withArgs( index ).returns( item );

            //Expected endpoint
            let action = actions[ aTypes.promoteItem ];
            let expectedPayload = Payload.factory( { obj: item } );
            let expectedMutations = [
                { type: mTypes.setItem, payload: expectedPayload }
            ];

            //Checks that the appropriate mutations are called
            testAction( action, payload, state, expectedMutations, { verbose: true, getters: getters } );

            //check that the promote method was called on the spy
            expect( spyItem.verify() ).toBe( true );
            expect( spyGetter.verify() ).toBe( true );
        } );

    } );

    describe( description( aTypes.toggleItemPublic ), function () {

        it( "happy path  ", function () {
            let state = makeState();
            // let item = faker.random.arrayElement(state.items);
            let index = 1;
            let item = state.items[index];

            //we can use the same object as both the input and
            //expected result because the tested process returns a
            //different token that has the same props
            let payload = Payload.factory( { index: index, updateProp: 'publicity', updateVal: false } );

            //now create a spy for the getters object it expects
            let spyGetter = sinon.mock( getters, 'getItemByIndex' );
            spyGetter.expects( 'getItemByIndex' ).withArgs( index ).returns( item );

            let action = actions[ aTypes.toggleItemPublic ];
            let expectedPayload = Payload.factory( {
                index: item.index,
                updateProp: 'publicity',
                updateVal: !item.publicity
            } )
            let expectedMutations = [
                { type: mTypes.updateItem, payload: expectedPayload }
            ];

            //Checks that the appropriate mutations are called
            testAction( action, payload, state, expectedMutations, { verbose: true, getters: getters } );

            //check that the promote method was called on the spy
            expect( spyGetter.verify() ).toBe( true );
        } );


        describe( description( 'error path | payload is not Payload' ), function () {
//todo

        } );

    } );

} );


// describe( description( aTypes.createItem ), function () {
//     it( "happy path  ", function () {
//         let action = actions[ aTypes.createItem ];
//         let expectedMutations = [
//             {
//                 type: mTypes.addNewItem,
//             }
//         ];
//
//         testAction( action, {}, this.state, expectedMutations, { verbose: true } );
//     } );
//
//
//     describe( "unhappy paths | ", function () {
//         //needs non instance of Item case too
//     } );
// } );

// describe( description( aTypes.loadItems ), function () {
//     xit( "happy path | ", function () {
//         let action = actions[ aTypes.loadItems ];
//         let expectedMutations = [
//             {
//                 type: mTypes.setItem,
//                 payload: this.payload
//             }//,
//             //
//             // {
//             //     type: mTypes.addIndexMapping,
//             //     payload: this.payload
//             // }
//         ];
//
//         testAction( action, this.payload, this.state, expectedMutations );
//     } );
//
//     describe( "unhappy paths | ", function () {
//         //needs non instance of Item case too
//     } );
// } );

//
//
// describe( description( aTypes.addNewItem ), function () {
//     it( "happy path  ", function () {
//
//         // let action = actions[ aTypes.addNewItem ];
//         // expect( typeof action ).not.toBe( 'undefined' );
//         //
//         // let expectedMutations = [
//         //     {
//         //         type: mTypes.setItem,
//         //         payload: this.mutationPayload
//         //     }
//         // ];
//         //
//         // testAction( action, {
//         //     index: this.mutationPayload.index,
//         //     id: this.mutationPayload.id,
//         //     obj: this.mutationPayload.obj
//         // }, this.state, expectedMutations );
//
//
//         let action = actions[ aTypes.addNewItem ];
//
//         let numPreexisting = this.state.items.size;
//         // let pl = Item.factory({index: numPreexisting + 1, id: numPreexisting + 1 })})
//
//         let item = Item.factory( {index: numPreexisting + 1} );
//         let pl = Payload.factory( {obj: item} );
//
//         let expectedMutations = [
//             {
//                 type: mTypes.setItem,
//                 payload: pl
//             }
//         ];
//
//         testAction( action, {}, this.state, expectedMutations, {verbose: true} );
//     } );
//
//
//     describe( "unhappy paths | ", function () {
//         //needs non instance of Item case too
//     } );
// } );


