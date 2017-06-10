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
import * as items from '../../../../../resources/assets/js/store/modules/items';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import * as gTypes from '../../../../../resources/assets/js/store/getter-types'
import Item from '../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../resources/assets/js/models/Payload'
import Node from '../../../../../resources/assets/js/models/Node'
import {traverseDF} from '../../../../../resources/assets/js/models/NodeTools'

//tested object
let obj = items.default;
//tested methods
let { getters, actions, mutations } = obj;


fdescribe( "store.modules.items | ", function () {
    beforeEach( function () {
        this.state = makeState();
        this.rootState = makeRootState();
        this.payload = makeTestPayload();
        this.mutationPayload = makeMutationPayload();
        this.item = factories.itemFactory();
    } );

    describe( "getters | ", function () {
        describe( description( gTypes.getItem ), function () {
            describe( description( 'payload contains id ' ), function () {
                it( "happy path", function () {
                    //prep
                    this.state.items = [];
                    let numItems = 3;
                    for (let i = 0; i < numItems; i++) {
                        this.state.items[ i ] = Item.factory( { id: i } );
                    }

                    //call and check
                    for (let i = 0; i < numItems; i++) {
                        //call
                        let result = getters[ gTypes.getItem ]( this.state, getters, Payload.factory( { id: i } ) );
                        // let result = getters.getItemByIndex( this.state, {}, {}, i );
                        //check
                        expect( result ).toBe( this.state.items[ i ] );
                        expect( result.id ).toBe( i );
                    }
                } );
            } );

            describe( description( 'payload contains index ' ), function () {
                it( "happy path", function () {

                    //prep
                    this.state.items = [];
                    let numItems = 3;
                    for (let i = 0; i < numItems; i++) {
                        this.state.items[ i ] = Item.factory( { index: i } );
                    }

                    //call and check
                    for (let i = 0; i < numItems; i++) {
                        //call
                        let result = getters[ gTypes.getItem ]( this.state, getters, Payload.factory( { index: i } ) );
                        // let result = getters.getItemByIndex( this.state, {}, {}, i );
                        //check
                        expect( result ).toBe( this.state.items[ i ] );
                        expect( result.index ).toBe( i );
                    }

                } );
            } );
        } );

        describe( description( gTypes.getItemById ), function () {
            it( "happy path", function () {
                //prep
                this.state.items = [];
                let numItems = 3;
                for (let i = 0; i < numItems; i++) {
                    this.state.items[ i ] = Item.factory( { id: i } );
                }

                //call and check
                for (let i = 0; i < numItems; i++) {
                    //call
                    let result = getters.getItemById( this.state, {}, i );
                    // let result = getters.getItemByIndex( this.state, {}, {}, i );
                    //check
                    expect( result ).toBe( this.state.items[ i ] );
                    expect( result.id ).toBe( i );
                }
            } );
        } );

        describe( description( gTypes.getItemByIndex ), function () {
            it( "happy path", function () {
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

        describe( description( gTypes.getItemBySerialNumber ), function () {
            it( "happy path", function () {
                //prep
                this.state.items = [];
                let numItems = 3;
                for (let i = 0; i < numItems; i++) {
                    this.state.items[ i ] = Item.factory( { index: i } );
                }
                //pick a random object to use for the text
                let testObj = faker.random.arrayElement( this.state.items );
                //call
                let result = getters[ gTypes.getItemBySerialNumber ]( this.state, {}, testObj.serialNumber );
                //check
                expect( result ).toBe( testObj );
                expect( result.serialNumber ).toBe( testObj.serialNumber );
            } );

        } );


        describe( 'getSortedIds | ', function () {
            beforeEach( function () {
                let numItems = 5;
                this.expectedIds = [];
                this.state.itemMap = new Node( 0, 0 ) ;
                addNodes( this.state.itemMap, numItems );
                for (let n of this.state.itemMap.children) {
                    addNodes( n, numItems );
                }

                let serialNumbers = addNodes.isns;

                // window.console.log( 'items.spec', 'serialNumbers', 259, serialNumbers );
                //Now make corresponding items for the items array
                for (let i = 0; i < serialNumbers.length; i++) {
                    let a = new Item();
                    a.serialNumber = serialNumbers[ i ];
                    a.id = 2 * a.serialNumber;
                    this.expectedIds.push(a.id);
                    this.state.items.push( a );
                }
            } );

            it( "happy path ", function () {
                window.console.log( 'items.spec', 'state', 275, this.state );
                let result = getters['getSortedIds'](this.state, getters);
                window.console.log( 'items.spec', 'rrrr', 179, result);

                let tester = (currentNode) => {
                    //ignore the exam
                    if (currentNode.data === 0) return true;

                    expect(currentNode.dataType).toBe('id');
                    expect(this.expectedIds.includes(currentNode.data)).toBe(true);
                    window.console.log( 'items.spec', 'tester', 188, 'tested', currentNode);
                };

                traverseDF(result, tester);

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
                let result = getters[ gTypes.getAllItems ]( this.state, {}, {} );

                //check
                for (let i = 0; i < result.length; i++) {
                    expect( typeof result[ i ] ).toBe( 'object' );
                    expect( result[ i ] instanceof Item ).toBe( true );
                }
                ;
            } );
        } );

        describe( description( gTypes.getAllItemsList ), function () {
            it( "happy path | ", function () {
                window.console.log( 'items.spec', 'ss', 290, this.state );
                //call
                let result = getters[ gTypes.getAllItemsList ]( this.state, getters );

                //check
                for (let i = 0; i < result.length; i++) {
                    expect( typeof result[ i ] ).toBe( 'object' );
                    expect( result[ i ] instanceof Item ).toBe( true );
                }
                ;
            } );

        } );


        describe( description( gTypes.getItemCount ), function () {
            it( "happy path ", function () {
                this.state.items = [];
                let numItems = faker.random.number( { min: 1, max: 50 } );
                for (let i = 0; i < numItems; i++) {
                    this.state.items[ i ] = Item.factory( { index: i, id: i } );
                }
                //call
                let result = getters[ gTypes.getItemCount ]( this.state, {} );
                //check
                expect( result ).toBe( numItems );
            } );
        } );

    } );//getters


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

