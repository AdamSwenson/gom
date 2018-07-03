//The name of the tested component
var compName = 'items.obj.getters';
//The path to the tested component
import getters from '../../../../../../resources/assets/js/store/modules/items/items.obj.getters.js' ;


require( '../../../../injectglobals' );

import {
    makeFilledState,
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
        numItems = 3;
        state = makeState( numItems );
        rootState = makeRootState();
        payload = makeTestPayload();
        mutationPayload = makeMutationPayload();
        item = factories.itemFactory();
        store = new Vuex.Store( {
            state, getters
        } );

    } );

    describe( description( gTypes.getItem ), function () {
        it( 'payload contains id ', function () {
            _.forEach( state.items, ( item ) => {
                let result = store.getters[ gTypes.getItem ]( Payload.factory( { id: item.id } ) );
                //check
                expect( _.isUndefined( result ) ).toBe( false );
                expect( result ).toMatchObject( item );
            } );
        } );

        it( 'payload contains index ', function () {
            _.forEach( state.items, ( item ) => {
                let result = store.getters[ gTypes.getItem ]( Payload.factory( { index: item.index } ) );
                //check
                expect( _.isUndefined( result ) ).toBe( false );
                expect( result ).toMatchObject( item );
            } );
        } );
    } );

    describe( description( gTypes.getItemById ), function () {
        it( "happy path", function () {
            _.forEach( state.items, ( item ) => {
                let result = store.getters[ gTypes.getItemById ]( item.id );
                //check
                expect( _.isUndefined( result ) ).toBe( false );
                expect( result ).toMatchObject( item );
            } );
        } );
    } );

    describe( description( gTypes.getItemByIndex ), function () {
        it( "happy path", function () {
            _.forEach( state.items, ( item ) => {
                let result = store.getters[ gTypes.getItemByIndex ]( item.index );
                //check
                expect( _.isUndefined( result ) ).toBe( false );
                expect( result ).toMatchObject( item );
            } );
        } );
    } );

    describe( description( gTypes.getItemBySerialNumber ), function () {
        it( "happy path", function () {
            _.forEach( state.items, ( item ) => {
                let result = store.getters[ gTypes.getItemBySerialNumber ]( item.serialNumber );
                //check
                expect( _.isUndefined( result ) ).toBe( false );
                expect( result ).toMatchObject( item );
            } );
        } );
    } );


    // describe.skip( 'getAllIndexesList | ', function () {
    //     xit( "happy path | ", function () {
    //         //todo
    //     } );
    // } );

    describe( description( gTypes.getAllItems ), function () {
        it( "happy path | ", function () {
            //call
            let result = store.getters[ gTypes.getAllItems ];

            //check
            for (let i = 0; i < result.length; i++) {
                expect( typeof result[ i ] ).toBe( 'object' );
                expect( result[ i ] instanceof global.Item.constructor ).toBe( true );
            }
        } );
    } );

    describe( description( gTypes.getAllItemsList ), function () {
        it( "happy path | ", function () {
            //call
            let result = store.getters[ gTypes.getAllItemsList ];

            //check
            for (let i = 0; i < result.length; i++) {
                expect( typeof result[ i ] ).toBe( 'object' );
                expect( result[ i ] instanceof global.Item.constructor ).toBe( true );
            }

        } );

    } );


    describe( description( gTypes.getItemCount ), function () {
        it( "happy path ", function () {
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

