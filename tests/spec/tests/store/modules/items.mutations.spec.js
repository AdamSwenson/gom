//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import { testAction, description, factories } from '../../../helpers/vuex.spec.helpers';

import { makeState, makeRootState, makeTestPayload, makeMutationPayload } from '../../../helpers/items.tests.helpers'


//Dependencies
import * as items from '../../../../../resources/assets/js/store/modules/items';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Item from '../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../resources/assets/js/models/Payload'


//tested object
let obj = items.default;
//tested methods
let { getters, actions, mutations } = obj;


describe( "store.modules.items.mutations | mutations | ", function () {
    beforeEach( function () {
        this.state = makeState();
        this.rootState = makeRootState();
        this.payload = makeTestPayload();
        this.mutationPayload = makeMutationPayload();
        this.item = factories.itemFactory();
        ;
    } );

    describe( description( mTypes.addItemIndexMapping ), function () {
        it( "happy path ", function () {

            //call
            mutations[ mTypes.addItemIndexMapping ]( this.state, this.rootState, this.mutationPayload );

            //check
            expect( this.state.indexMap.get( this.mutationPayload.index ) ).toBe( this.mutationPayload.id );
        } );

        describe( "unhappy paths | ", function () {
            xit( "payload does not contain index  | ", function () {
                // mutations[ mTypes.setItem ]( this.state, this.rootState, this.payload );
                // expect( this.state.items[ this.payload.obj.id ] ).toBe( this.payload.obj );
            } );

            xit( "payload does not contain id  | ", function () {
                // mutations[ mTypes.setItem ]( this.state, this.rootState, this.payload );
                // expect( this.state.items[ this.payload.obj.id ] ).toBe( this.payload.obj );
            } );
        } );
    } );

    describe( description( 'addMappedItem' ), function () {
        //todo
    } );

    describe( description( mTypes.addNewItem ), function () {

        describe( description( "Happy paths " ), function () {

            //This is the main use case
            it( "no preexisting value to overwrite ", function () {
                //let index = 100;
                //capture starting length, since should change
                let prevLen = this.state.items.length;
                //Make an object which has a higher index than the length
                //since the index starts at 0, this will give the next whole number as index
                let index = prevLen;
                window.console.log( 'items.mutations.spec', 'index', 72, index );
                let item = factories.itemFactory( { index: index } );
                let payload = Payload.factory( { obj: item } );

                //call
                mutations[ mTypes.addNewItem ]( this.state, payload );
                window.console.log( 'items.mutations.spec', 'state', 101, this.state );

                //check
                //make sure expected number is there
                let newLen = this.state.items.length;
                expect( newLen ).toBe( prevLen + 1 );
                //make sure the new item is who we expect it to be
                expect( this.state.items[ index ] ).toBe( item );
            } );

        } );

        describe( "unhappy paths | ", function () {
            describe( description( 'payload is NOT Payload' ), function () {
                it( " payload is Item", function () {
                    //todo
                    // it( "happy path", function () {
                    //     //call
                    //     mutations[ mTypes.setItem ]( this.state, this.item );
                    //
                    //     //check
                    //     expect( this.state.items[ this.item.index ] ).toBe( this.item );
                    //     // expect( this.state.items[ item.index ] ).toBe( item );
                    // } );
                    //
                    // describe( "unhappy paths | ", function () {
                    // } );
                } );

                it( " payload is empty", function () {
                    //todo
                    // it( "happy path", function () {
                    //     //call
                    //     mutations[ mTypes.setItem ]( this.state, this.item );
                    //
                    //     //check
                    //     expect( this.state.items[ this.item.index ] ).toBe( this.item );
                    //     // expect( this.state.items[ item.index ] ).toBe( item );
                    // } );
                    //
                    // describe( "unhappy paths | ", function () {
                    // } );
                } );
            } );
        } );
    } );


    describe( description( 'cleanupEmptyItems' ), function () {
        //todo
    } );

    describe( description( 'onUpdate' ), function () {
        //todo
    } );


    describe( description( mTypes.setItem ), function () {
        //Two main cases.
        //(1) Pure insertion -- where there is no pre-existing object
        // at the index
        //(2) Overwrite -- object at the index which is overwritten

        describe( description( "Happy paths" ), function () {

            it( "no preexisting value to overwrite ", function () {
                //let index = 100;
                //capture starting length, since should change
                let prevLen = this.state.items.length;
                //Make an object which has a higher index than the length
                //since the index starts at 0, this will give the next whole number as index
                let index = prevLen;
                window.console.log( 'items.mutations.spec', 'index', 72, index );
                let item = factories.itemFactory(index );
                let payload = Payload.factory( { obj: item } );
                window.console.log( 'items.mutations.spec', 'payload', 156, payload );

                //call
                mutations[ mTypes.setItem ]( this.state, payload );
                window.console.log( 'items.mutations.spec', 'state', 159, this.state );

                //check
                //make sure expected number is there
                let newLen = this.state.items.length;
                expect( newLen ).toBe( prevLen + 1 );
                //make sure the new item is who we expect it to be
                expect( this.state.items[ index ] ).toBe( item );

                //
                // let payload = Payload.factory( { obj: this.item } );
                //
                // //call
                // mutations[ mTypes.setItem ]( this.state, payload );
                //
                // //check
                // expect( this.state.items[ this.item.index ] ).toBe( this.item );
            } );

            it( "overwrite preexisting value ", function () {
                let index = 1;
                let item = factories.itemFactory( index  );
                let payload = Payload.factory( { obj: item } );
                //capture starting length, since should change
                let prevLen = this.state.items.length;

                //call
                mutations[ mTypes.setItem ]( this.state, payload );
                window.console.log( 'items.mutations.spec', 'state', 101, this.state );

                //check
                //make sure expected number is there
                let newLen = this.state.items.length;
                expect( newLen ).toBe( prevLen );
                //make sure the new item is who we expect it to be
                expect( this.state.items[ index ] ).toBe( item );
            } );
        } );

        describe( description( 'Unhappy paths' ), function () {
            describe( description( 'payload is NOT Payload' ), function () {
                it( " payload is Item", function () {
                    //todo
                    // it( "happy path", function () {
                    //     //call
                    //     mutations[ mTypes.setItem ]( this.state, this.item );
                    //
                    //     //check
                    //     expect( this.state.items[ this.item.index ] ).toBe( this.item );
                    //     // expect( this.state.items[ item.index ] ).toBe( item );
                    // } );
                    //
                    // describe( "unhappy paths | ", function () {
                    // } );
                } );

                it( " payload is empty", function () {
                    //todo
                    // it( "happy path", function () {
                    //     //call
                    //     mutations[ mTypes.setItem ]( this.state, this.item );
                    //
                    //     //check
                    //     expect( this.state.items[ this.item.index ] ).toBe( this.item );
                    //     // expect( this.state.items[ item.index ] ).toBe( item );
                    // } );
                    //
                    // describe( "unhappy paths | ", function () {
                    // } );
                } );
            } );

            it( "payload.obj not Item | ", function () {

                // mutations[ mTypes.setItem ]( this.state, this.mutationPayload );
                // console.log( 'addItems', this.state.items , this.mutationPayload.index);
                // expect( this.state.items[ this.mutationPayload.index] ).toBe( this.mutationPayload.obj );
                // mutations[ mTypes.setItem ]( this.state, this.rootState, this.payload );
                // expect( this.state.items[ this.payload.obj.id ] ).toBe( this.payload.obj );
            } );

        } );

    } );



    describe( description( mTypes.updateComment ), function () {
        //todo
    } );

    describe( description( mTypes.updateItem ), function () {

        describe( "Happy paths  | ", function () {
            it( "overwrite preexisting value ", function () {
                let index = 1;
                let item = factories.itemFactory( { index: index } );
                let payload = Payload.factory( { obj: item } );
                //capture starting length, since should change
                let prevLen = this.state.items.length;
                // window.console.log( 'items.mutations.spec', 'prev', 67, this.state, prevLen );

                //call
                mutations[ mTypes.updateItem ]( this.state, payload );
                window.console.log( 'items.mutations.spec', 'state', 101, this.state );
                //check
                //make sure expected number is there
                let newLen = this.state.items.length;
                expect( newLen ).toBe( prevLen );
                //make sure the new item is who we expect it to be
                expect( this.state.items[ index ] ).toBe( this.item );
            } );

        } );

        describe( 'unhappy paths | ', function () {
            it( "no preexisting value to overwrite", function () {
                let targetIndex = 2;
                let item = this.state[ targetIndex ];
                let payload = Payload.factory( { obj: this.item } );

                //call
                mutations[ mTypes.setItem ]( this.state, payload );

                //check
                expect( this.state.items[ targetIndex ] ).toBe( this.item );
            } );

            it( "payload.obj is undefined ", function () {
                // mutations[ mTypes.setItem ]( this.state, this.mutationPayload );
                // console.log( 'addItems', this.state.items , this.mutationPayload.index);
                // expect( this.state.items[ this.mutationPayload.index] ).toBe( this.mutationPayload.obj );
                // mutations[ mTypes.setItem ]( this.state, this.rootState, this.payload );
                // expect( this.state.items[ this.payload.obj.id ] ).toBe( this.payload.obj );
            } );

            it( "payload is NOT Payload ", function () {
            } );

            it( "payload is Item", function () {
                // it( "happy path", function () {
                //     //call
                //     mutations[ mTypes.setItem ]( this.state, this.item );
                //
                //     //check
                //     expect( this.state.items[ this.item.index ] ).toBe( this.item );
                //     // expect( this.state.items[ item.index ] ).toBe( item );
                // } );
                //
                // describe( "unhappy paths | ", function () {
                // } );
            } );

        } );

    } );

    describe( description( mTypes.updateItemSilently ), function () {
        //todo
    } );
    describe( description( mTypes.updateOrder ), function () {
        //todo
    } );


} );


// it( "overwrite preexisting value ", function () {
//     let index = 1;
//     let item = factories.itemFactory( { index: index } );
//     let payload = Payload.factory( { obj: item } );
//     //capture starting length, since should change
//     let prevLen = this.state.items.length;
//     // window.console.log( 'items.mutations.spec', 'prev', 67, this.state, prevLen );
//
//     //call
//     mutations[ mTypes.addNewItem ]( this.state, payload );
//     window.console.log( 'items.mutations.spec', 'state', 101, this.state );
//     //check
//     //make sure expected number is there
//     let newLen = this.state.items.length;
//     expect( newLen ).toBe( prevLen );
//     //make sure the new item is who we expect it to be
//     expect( this.state.items[ index ] ).toBe( this.item );
// } );
