//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import { testAction, description, factories } from '../../../../helpers/vuex.spec.helpers';

//Dependencies
//import * as items from '../../../../../resources/assets/js/store/modules/items';

import * as mTypes from '../../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../../resources/assets/js/store/action-types'
import * as gTypes from '../../../../../../resources/assets/js/store/getter-types'
import Item from '../../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../../resources/assets/js/models/Payload'
import Student from '../../../../../../resources/assets/js/models/Student'

import * as Roster from '../../../../../../resources/assets/js/store/modules/roster/roster';

let { state, getters, actions, mutations } = Roster;

describe( "rosters  ", function () {
    beforeEach( function () {
    } );

    describe( description( "getters" ), function () {
        beforeEach( function () {
            this.state = { roster:[]};
            this.numStudents = faker.random.number( { min: 1, max: 50 } );

            for (let i = 0; i < this.numStudents; i++) {
                this.state.roster.push(Student.factory( { id: i, identifier: i } ));
            }

            this.testObj = faker.random.arrayElement( this.state.roster );

        } );


        describe( description( 'getStudentFromRosterBySerialNumber' ), function () {
            it( "happy path", function () {
                //call
                let result = getters.getStudentFromRosterBySerialNumber(  this.testObj.serialNumber );

                // let result = getters.getStudentFromRosterBySerialNumber( this.state, {}, {}, this.testObj.serialNumber );
                //check
                expect( result ).toBe( this.testObj );
                expect( result.serialNumber ).toBe( this.testObj.serialNumber );
            } );
        } );


        describe( description( 'getStudentFromRosterById' ), function () {
            it( "happy path", function () {
                //call and check
                for (let i = 0; i < this.numStudents; i++) {
                    //call
                    let result = getters.getStudentFromRosterById( this.state, {}, {}, i );
                    //check
                    expect( result ).toBe( this.state.roster[ i ] );
                    expect( result.id ).toBe( i );
                }
            } );
        } );

        describe( description( 'getStudentCount' ), function () {
            it( "happy path ", function () {
                //call
                let result = getters.getStudentCount ( this.state, {} );
                //check
                expect( result ).toBe( this.numStudents );
            } );
        } );

    } );//getters

});
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

