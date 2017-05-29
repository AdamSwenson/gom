//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import { testAction, description, factories } from '../../../helpers/vuex.spec.helpers';

import {makeState, makeTestPayload, makeMutationPayload} from '../../../helpers/items.tests.helpers'


//Dependencies
import * as items from '../../../../../resources/assets/js/store/modules/items';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Item from '../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../resources/assets/js/models/Payload'

// const makeState = ( n = 5 ) => {
//
//     let s = makeRootState();
//
//     for (let i = 0; i < n; i++) {
//         let e = factories.itemFactory();
//         s.items[ i ] = e;
//         s.indexMap.set( e.id, i );
//     }
//     return s;
// };
//
// const makeRootState = function () {
//     return {
//         items: new Map(),
//         indexMap: new Map(),
//     };
// };
//
// const makeTestPayload = function () {
//     let e = factories.itemFactory();
//     return {
//         ItemIndex: e.index,
//         ItemId: e.id,
//         obj: e
//     };
// };
// const makeMutationPayload = function ( index ) {
//     let e = factories.itemFactory( index );
//     return Payload.factory( {
//         obj: e
//     } );
// };

//tested object
let obj = items.default;
//tested methods
let { getters, actions, mutations } = obj;


describe( "store.modules.items | ", function () {
    beforeEach( function () {
        this.state = makeState();
        this.rootState = makeRootState();
        this.payload = makeTestPayload();
        this.mutationPayload = makeMutationPayload();
        this.item = factories.itemFactory();
        ;
    } );
//
//     describe( "mutations | ", function () {
//         describe( description( mTypes.setItem ), function () {
//
//             describe( "no preexisting | ", function () {
//                 describe( "payload is Payload | ", function () {
//
//                     //This is the main use case
//                     it( "happy path", function () {
//                         let payload = Payload.factory( { obj: this.item } );
//
//                         //call
//                         mutations[ mTypes.setItem ]( this.state, payload );
//
//                         //check
//                         //expect( state.items[ item.index ] ).toBe( item );
//                         expect( this.state.items[ this.item.index ] ).toBe( this.item );
//                     } );
//
//                     describe( 'unhappy paths | ', function () {
//                         it( "payload.obj not Item | ", function () {
//
//                             // mutations[ mTypes.setItem ]( this.state, this.mutationPayload );
//                             // console.log( 'addItems', this.state.items , this.mutationPayload.index);
//                             // expect( this.state.items[ this.mutationPayload.index] ).toBe( this.mutationPayload.obj );
//                             // mutations[ mTypes.setItem ]( this.state, this.rootState, this.payload );
//                             // expect( this.state.items[ this.payload.obj.id ] ).toBe( this.payload.obj );
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
//                     //     mutations[ mTypes.setItem ]( this.state, this.item );
//                     //
//                     //     //check
//                     //     expect( this.state.items[ this.item.index ] ).toBe( this.item );
//                     //     // expect( this.state.items[ item.index ] ).toBe( item );
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
//                 mutations[ mTypes.addItemIndexMapping ]( this.state, this.rootState, this.mutationPayload );
//
//                 //check
//                 expect( this.state.indexMap.get( this.mutationPayload.index ) ).toBe( this.mutationPayload.id );
//             } );
//
//             describe( "unhappy paths | ", function () {
//                 xit( "payload does not contain index  | ", function () {
//                     // mutations[ mTypes.setItem ]( this.state, this.rootState, this.payload );
//                     // expect( this.state.items[ this.payload.obj.id ] ).toBe( this.payload.obj );
//                 } );
//
//                 xit( "payload does not contain id  | ", function () {
//                     // mutations[ mTypes.setItem ]( this.state, this.rootState, this.payload );
//                     // expect( this.state.items[ this.payload.obj.id ] ).toBe( this.payload.obj );
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
//                 let prevLen = this.state.itemsRepo.length;
//                 //call
//                 mutations[ mTypes.addNewItem ]( this.state );
//
//                 //check
//                 //expect( state.items[ item.index ] ).toBe( item );
//                 let r = this.state.itemsRepo[ prevLen + 1 ];
//                 // expect( this.state.itemsRepo.length ).toBe( prevLen + 1 );
//                 expect( r.index ).toBe( prevLen + 1 );
// //                            expect( this.state.items.get( this.item.index ) ).toBe( this.item );
//             } );
//
//             describe( 'unhappy paths | ', function () {
//             } );
//         } );
//     } );
//


    describe( "getters | ", function () {
        describe( "getItem | ", function () {
            it( "happy path | ", function () {
                //prep
                this.state.items[ this.payload.index ] = this.payload.obj;

                //call
                let result = getters.getItem( this.state, {}, this.payload );

                //check
                expect( result ).toBe( this.payload.obj );
                expect( result.index ).toBe( this.payload.obj.index );
            } )

        } );


        describe( "getItemByIndex | ", function () {
            it( "happy path | ", function () {
                //prep
                this.state.items = [];
                let numItems = 3;
                for (let i = 0; i < numItems; i++) {
                    this.state.items[ i ] = Item.factory( { index: i } );
                }

                //call and check
                for (let i = 0; i < numItems; i++) {
                    //call
                    let result = getters.getItemByIndex( this.state, {}, i );
                    // let result = getters.getItemByIndex( this.state, {}, {}, i );
                    //check
                    expect( result ).toBe( this.state.items[ i ] );
                    expect( result.index ).toBe( i );
                }

            } );

        } );


        describe( 'getSortedIds | ', function () {
            it( "happy path ", function () {

                this.state.items = [];
                let numItems = 3;
                let expectedIds = [];
                for (let i = 0; i < numItems; i++) {
                    this.state.items[ i ] = Item.factory( { index: i, id: i } );
                    expectedIds.push( i );
                }

                //call and check
                //call
                let result = getters.getSortedIds( this.state, {} );
                //check
                expect( result ).toBe( expectedIds );

            } );
        } );


        describe( 'getAllIndexesList | ', function () {
            it( "happy path | ", function () {
                //todo
            } );
        } );


        describe( "getAllItems | ", function () {
            it( "happy path | ", function () {
                //call
                let result = getters.getAllItems( this.state, {}, {} );

                //check
                for (let i = 0; i < result.length; i++) {
                    expect( typeof result[ i ] ).toBe( 'object' );
                    expect( result[ i ] instanceof Item ).toBe( true );
                }
                ;
            } );
        } );

        describe( 'getAllItemsList | ', function () {
            it( "happy path | ", function () {
                //todo
            } );
        } );

        describe( 'getNumberOfItems | ', function () {
            it( "happy path | ", function () {
                //todo
            } );
        } );

        describe( 'getMaxIndex | ', function () {
            it( "happy path | ", function () {
                //todo
            } );
        } );

    } );

} );
