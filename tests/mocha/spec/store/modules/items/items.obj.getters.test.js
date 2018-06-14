
//The name of the tested component
var compName = 'items.obj.getters';
//The path to the tested component
import getters from  '../../../../../../resources/assets/js/store/modules/items/items.obj.getters.js' ;


require( '../../../../injectglobals' );

import {
    makeMutationPayload,
    makeRootState,
    makeState,
    makeTestPayload
} from "../../../../helpers/item-test-helpers";


import { createLocalVue } from 'vue-test-utils';
const localVue = createLocalVue();
localVue.use( Vuex )


describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let state, rootState, mutationPayload, numItems, filledState, testItemIndex;
    let store;

    beforeEach( () => {

        state = makeState();
        rootState = makeRootState();
        payload = makeTestPayload();
        mutationPayload = makeMutationPayload();
        item = factories.itemFactory();
        store = new Vuex.Store({
            state, getters
        });

    } );

    describe( description( gTypes.getItem ), function () {
        describe( description( 'payload contains id ' ), function () {
            it( "happy path", function () {
                //prep
                state.items = [];
                let numItems = 3;
                for (let i = 0; i < numItems; i++) {
                    //creating with item id
                    state.items[ i ] = factories.itemFactory( 0,  i  );
                }

                //call and check
                for (let i = 0; i < numItems; i++) {
                    //call
                    let result = store.getters[ gTypes.getItem ]( Payload.factory( { id: i } ) );
                    // result = result();
                    // let result = getters.getItemByIndex( state, {}, {}, i );
                    //check
                    expect( result ).toBe( state.items[ i ] );
                    expect( result.id ).toBe( i );
                }
            } );
        } );

        describe( description( 'payload contains index ' ), function () {
            it( "happy path", function () {

                //prep
                state.items = [];
                let numItems = 3;
                for (let i = 0; i < numItems; i++) {
                    state.items[ i ] =  factories.itemFactory(index=i);
                }

                //call and check
                for (let i = 0; i < numItems; i++) {
                    //call
                    let result = store.getters[ gTypes.getItem ]( Payload.factory( { index: i } ) );
                    // let result = getters.getItemByIndex( state, {}, {}, i );
                    //check
                    expect( result ).toBe( state.items[ i ] );
                    expect( result.index ).toBe( i );
                }

            } );
        } );
    } );

    describe( description( gTypes.getItemById ), function () {
        it( "happy path", function () {
            //prep
            state.items = [];
            let numItems = 3;
            for (let i = 0; i < numItems; i++) {
                state.items[ i ] =  factories.itemFactory(1, i);;
            }

            //call and check
            for (let i = 0; i < numItems; i++) {
                //call
                let result = store.getters.getItemById( i );
                // let result = getters.getItemByIndex( state, {}, {}, i );
                //check
                expect( result ).toBe( state.items[ i ] );
                expect( result.id ).toBe( i );
            }
        } );
    } );

    describe( description( gTypes.getItemByIndex ), function () {
        it( "happy path", function () {
            //prep
            state.items = [];
            let numItems = 3;
            for (let i = 0; i < numItems; i++) {
                state.items[ i ] =  factories.itemFactory(i);;
            }

            //call and check
            for (let i = 0; i < numItems; i++) {
                //call
                let result = store.getters.getItemByIndex(  i );
                // let result = getters.getItemByIndex( state, {}, {}, i );
                //check
                expect( result ).toBe( state.items[ i ] );
                expect( result.index ).toBe( i );
            }

        } );

    } );

    describe( description( gTypes.getItemBySerialNumber ), function () {
        it( "happy path", function () {
            //prep
            state.items = [];
            let numItems = 3;
            for (let i = 0; i < numItems; i++) {
                state.items[ i ] =factories.itemFactory( i );
            }
            //pick a random object to use for the text
            let testObj = faker.random.arrayElement( state.items );
            //call
            let result = store.getters[ gTypes.getItemBySerialNumber ](  testObj.serialNumber );
            //check
            expect( result ).toBe( testObj );
            expect( result.serialNumber ).toBe( testObj.serialNumber );
        } );

    } );


    describe( 'getAllIndexesList | ', function () {
        xit( "happy path | ", function () {
            //todo
        } );
    } );

    describe( description( gTypes.getAllItems ), function () {
        it( "happy path | ", function () {
            //call
            let result = store.getters[ gTypes.getAllItems ];

            //check
            for (let i = 0; i < result.length; i++) {
                expect( typeof result[ i ] ).toBe( 'object' );
                expect( result[ i ] instanceof global.Item.constructor ).toBe( true );
            }
            ;
        } );
    } );

    describe( description( gTypes.getAllItemsList ), function () {
        it( "happy path | ", function () {
            // window.console.log( 'items.spec', 'ss', 290, state );
            //call
            let result = store.getters[ gTypes.getAllItemsList ];

            //check
            for (let i = 0; i < result.length; i++) {
                expect( typeof result[ i ] ).toBe( 'object' );
                expect( result[ i ] instanceof global.Item.constructor ).toBe( true );
            };
        } );

    } );


    describe( description( gTypes.getItemCount ), function () {
        it( "happy path ", function () {
            state.items = [];
            let numItems = faker.random.number( { min: 1, max: 50 } );
            for (let i = 0; i < numItems; i++) {
                state.items[ i ] = factories.itemFactory( i, i );
            }
            //call
            let result = store.getters[ gTypes.getItemCount ];
            //check
            expect( result ).toBe( numItems );
        } );
    } );

} );//getters


//
//     describe( "mutations | ", function () {
//         describe( description( mTypes.setItem ), function () {
//
//             describe( "no preexisting | ", function () {
//                 describe( "payload is Payload | ", function () {
//
//                     //This is the main use case
//                     it( "happy path", function () {
//                         let payload = Payload.factory( { obj: item } );
//
//                         //call
//                         mutations[ mTypes.setItem ]( state, payload );
//
//                         //check
//                         //expect( state.items[ item.index ] ).toBe( item );
//                         expect( state.items[ item.index ] ).toBe( item );
//                     } );
//
//                     describe( 'unhappy paths | ', function () {
//                         it( "payload.obj not Item | ", function () {
//
//                             // mutations[ mTypes.setItem ]( state, mutationPayload );
//                             // console.log( 'addItems', state.items , mutationPayload.index);
//                             // expect( state.items[ mutationPayload.index] ).toBe( mutationPayload.obj );
//                             // mutations[ mTypes.setItem ]( state, rootState, payload );
//                             // expect( state.items[ payload.obj.id ] ).toBe( payload.obj );
//                         } );
//
//
//                     } );
//
//                 } );
//
//                 describe( " payload is Item", function () {
//                     // it( "happy path", function () {
//                     //     //call
//                     //     mutations[ mTypes.setItem ]( state, item );
//                     //
//                     //     //check
//                     //     expect( state.items[ item.index ] ).toBe( item );
//                     //     // expect( state.items[ item.index ] ).toBe( item );
//                     // } );
//                     //
//                     // describe( "unhappy paths | ", function () {
//                     // } );
//                 } );
//
//             } );
//         } );
//         describe( description( mTypes.addItemIndexMapping ), function () {
//             it( "happy path ", function () {
//
//                 //call
//                 mutations[ mTypes.addItemIndexMapping ]( state, rootState, mutationPayload );
//
//                 //check
//                 expect( state.indexMap.get( mutationPayload.index ) ).toBe( mutationPayload.id );
//             } );
//
//             describe( "unhappy paths | ", function () {
//                 xit( "payload does not contain index  | ", function () {
//                     // mutations[ mTypes.setItem ]( state, rootState, payload );
//                     // expect( state.items[ payload.obj.id ] ).toBe( payload.obj );
//                 } );
//
//                 xit( "payload does not contain id  | ", function () {
//                     // mutations[ mTypes.setItem ]( state, rootState, payload );
//                     // expect( state.items[ payload.obj.id ] ).toBe( payload.obj );
//                 } );
//             } );
//         } );
//
//         describe( description( mTypes.loadItems ), function () {
//             xit( "happy path | ", function () {
//                 //todo
//             } );
//         } );
//
//         describe( description( mTypes.addNewItem ), function () {
//             it( "happy path", function () {
//                 let prevLen = state.itemsRepo.length;
//                 //call
//                 mutations[ mTypes.addNewItem ]( state );
//
//                 //check
//                 //expect( state.items[ item.index ] ).toBe( item );
//                 let r = state.itemsRepo[ prevLen + 1 ];
//                 // expect( state.itemsRepo.length ).toBe( prevLen + 1 );
//                 expect( r.index ).toBe( prevLen + 1 );
// //                            expect( state.items.get( item.index ) ).toBe( item );
//             } );
//
//             describe( 'unhappy paths | ', function () {
//             } );
//         } );
//     } );
//

