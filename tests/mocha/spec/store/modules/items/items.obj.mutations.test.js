var compName = 'items.obj.mutations';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.obj.mutations.js' );

require( '../../../../injectglobals' );

import {
    addNodes,
    makeState,
    makeRootState,
    makeTestPayload,
    makeMutationPayload
} from "../../../../helpers/item-test-helpers";

import Comment from '../../../../../../resources/assets/js/models/Comment.js';

//tested object
let mutations = Component;

//tested object


describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let state, rootState, mutationPayload;

    beforeEach( function () {
        state = makeState();
        rootState = makeRootState();
        payload = makeTestPayload();
        mutationPayload = makeMutationPayload();
        item = factories.itemFactory();
    } );

    describe( description( mTypes.addItemIndexMapping ), function () {
        it( "happy path ", function () {

            //call
            mutations[ mTypes.addItemIndexMapping ]( state, rootState, mutationPayload );

            //check
            expect( state.indexMap.get( mutationPayload.index ) ).toBe( mutationPayload.id );
        } );

        // describe.skip( "unhappy paths | ", function () {
        //     it( "payload does not contain index  | ", function () {
        //         // mutations[ mTypes.setItem ]( state, rootState, payload );
        //         // expect( state.items[ payload.obj.id ] ).toBe( payload.obj );
        //     } );
        //
        //     it( "payload does not contain id  | ", function () {
        //         // mutations[ mTypes.setItem ]( state, rootState, payload );
        //         // expect( state.items[ payload.obj.id ] ).toBe( payload.obj );
        //     } );
        // } );
    } );

    describe.skip( description( 'addMappedItem' ), function () {
        //todo
    } );

    describe( description( mTypes.addNewItem ), function () {

        //This is the main use case
        it( "it pushes the item onto the end of state.items when no preexisting value to overwrite ", function () {
            //let index = 100;
            //capture starting length, since should change
            let prevLen = state.items.length;
            //Make an object which has a higher index than the length
            //since the index starts at 0, this will give the next whole number as index
            let index = prevLen;
            // window.console.log( 'items.mutations.spec', 'index', 72, index );
            let item = factories.itemFactory( { index: index } );
            let payload = Payload.factory( { obj: item } );

            //call
            mutations[ mTypes.addNewItem ]( state, payload );
            // window.console.log( 'items.mutations.spec', 'state', 101, state );

            //check
            //make sure expected number is there
            let newLen = state.items.length;
            expect( newLen ).toBe( prevLen + 1 );
            //make sure the new item is who we expect it to be
            expect( state.items[ index ] ).toBe( item );
        } );

        // describe( "unhappy paths | ", function () {
        //     describe( description( 'payload is NOT Payload' ), function () {
        //         it( " payload is Item", function () {
        //             //todo
        //             // it( "happy path", function () {
        //             //     //call
        //             //     mutations[ mTypes.setItem ]( state, item );
        //             //
        //             //     //check
        //             //     expect( state.items[ item.index ] ).toBe( item );
        //             //     // expect( state.items[ item.index ] ).toBe( item );
        //             // } );
        //             //
        //             // describe( "unhappy paths | ", function () {
        //             // } );
        //         } );
        //
        //         it( " payload is empty", function () {
        //             //todo
        //             // it( "happy path", function () {
        //             //     //call
        //             //     mutations[ mTypes.setItem ]( state, item );
        //             //
        //             //     //check
        //             //     expect( state.items[ item.index ] ).toBe( item );
        //             //     // expect( state.items[ item.index ] ).toBe( item );
        //             // } );
        //             //
        //             // describe( "unhappy paths | ", function () {
        //             // } );
        //         } );
        //     } );
        // } );
    } );

    describe.skip( description( 'cleanupEmptyItems' ), function () {
        //todo
    } );

    describe.skip( description( 'onUpdate' ), function () {
        //todo
    } );


    describe( description( mTypes.setItem ), function () {
        //Two main cases.
        //(1) Pure insertion -- where there is no pre-existing object
        // at the index
        //(2) Overwrite -- object at the index which is overwritten
        it( "no preexisting value to overwrite ", function () {
            //let index = 100;
            //capture starting length, since should change
            let prevLen = state.items.length;
            //Make an object which has a higher index than the length
            //since the index starts at 0, this will give the next whole number as index
            let index = prevLen;
            // window.console.log( 'items.mutations.spec', 'index', 72, index );
            let item = factories.itemFactory( index );
            let payload = Payload.factory( { obj: item } );
            // window.console.log( 'items.mutations.spec', 'payload', 156, payload );

            //call
            mutations[ mTypes.setItem ]( state, payload );
            // window.console.log( 'items.mutations.spec', 'state', 159, state );

            //check
            //make sure expected number is there
            let newLen = state.items.length;
            expect( newLen ).toBe( prevLen + 1 );
            //make sure the new item is who we expect it to be
            expect( state.items[ index ] ).toBe( item );

            //
            // let payload = Payload.factory( { obj: item } );
            //
            // //call
            // mutations[ mTypes.setItem ]( state, payload );
            //
            // //check
            // expect( state.items[ item.index ] ).toBe( item );
        } );

        it( "overwrite preexisting value ", function () {
            let index = 1;
            let item = factories.itemFactory( index );
            let payload = Payload.factory( { obj: item } );
            //capture starting length, since should change
            let prevLen = state.items.length;

            //call
            mutations[ mTypes.setItem ]( state, payload );
            // window.console.log( 'items.mutations.spec', 'state', 101, state );

            //check
            //make sure expected number is there
            let newLen = state.items.length;
            expect( newLen ).toBe( prevLen );
            //make sure the new item is who we expect it to be
            expect( state.items[ index ] ).toBe( item );
        } );

        // describe.skip( description( 'Unhappy paths' ), function () {
        //     describe( description( 'payload is NOT Payload' ), function () {
        //         it( " payload is Item", function () {
        //             //todo
        //             // it( "happy path", function () {
        //             //     //call
        //             //     mutations[ mTypes.setItem ]( state, item );
        //             //
        //             //     //check
        //             //     expect( state.items[ item.index ] ).toBe( item );
        //             //     // expect( state.items[ item.index ] ).toBe( item );
        //             // } );
        //             //
        //             // describe( "unhappy paths | ", function () {
        //             // } );
        //         } );
        //
        //         it( " payload is empty", function () {
        //             //todo
        //             // it( "happy path", function () {
        //             //     //call
        //             //     mutations[ mTypes.setItem ]( state, item );
        //             //
        //             //     //check
        //             //     expect( state.items[ item.index ] ).toBe( item );
        //             //     // expect( state.items[ item.index ] ).toBe( item );
        //             // } );
        //             //
        //             // describe( "unhappy paths | ", function () {
        //             // } );
        //         } );
        //     } );
        //
        //     it( "payload.obj not Item | ", function () {
        //
        //         // mutations[ mTypes.setItem ]( state, mutationPayload );
        //         // console.log( 'addItems', state.items , mutationPayload.index);
        //         // expect( state.items[ mutationPayload.index] ).toBe( mutationPayload.obj );
        //         // mutations[ mTypes.setItem ]( state, rootState, payload );
        //         // expect( state.items[ payload.obj.id ] ).toBe( payload.obj );
        //     } );
        //
        // } );

    } );


    describe( description( mTypes.updateComment ), function () {
        it( "alters the comment content for the specified valence", () => {
            item = factories.itemFactory();
            state.items.push( item );
            let idx = state.items.length - 1;
            // window.console.log( 'items.obj.mutations.test', 'item', 241, item);
            _.forEach( Comment.valences, function ( valence ) {
                let newText = faker.company.bs();
                let pl = Payload.factory( {
                    obj: item,
                    // index: idx,
                    updateValence: valence,
                    updateVal: newText
                } );

                mutations[ mTypes.updateComment ]( state, pl );

                //check
                //we see it on the item by itself
                expect( item.getComment( valence ).text ).toBe( newText );

                //todo this was written for the probably unused Vue.set step
                //and we see it in the item as stored in state.items
                // expect(state.items[0].getComment(valence).text).toBe(newText);
            } );

        } );

    } );

    describe( description( mTypes.updateItem ), function () {

            it( "overwrite preexisting value ", function () {
                let index = 1;
                let item = factories.itemFactory( { index: index } );
                let payload = Payload.factory( { index: index, updateProp: 'name', updateVal: item.name } );
                //capture starting length, since should change
                let prevLen = state.items.length;
                // window.console.log( 'items.mutations.spec', 'prev', 67, state, prevLen );

                //call
                mutations[ mTypes.updateItem ]( state, payload );
                // window.console.log( 'items.mutations.spec', 'state', 101, state );
                //check
                //make sure expected number is there
                let newLen = state.items.length;
                expect( newLen ).toBe( prevLen );
                //make sure the new item is who we expect it to be
                expect( state.items[ index ].name ).toBe( item.name );
            } );


        // describe.skip( 'unhappy paths | ', function () {
        //     it( "no preexisting value to overwrite", function () {
        //         let targetIndex = 2;
        //         let item = state[ targetIndex ];
        //         let payload = Payload.factory( { obj: item } );
        //
        //         //call
        //         mutations[ mTypes.setItem ]( state, payload );
        //
        //         //check
        //         expect( state.items[ targetIndex ] ).toBe( item );
        //     } );
        //
        //     it( "payload.obj is undefined ", function () {
        //         // mutations[ mTypes.setItem ]( state, mutationPayload );
        //         // console.log( 'addItems', state.items , mutationPayload.index);
        //         // expect( state.items[ mutationPayload.index] ).toBe( mutationPayload.obj );
        //         // mutations[ mTypes.setItem ]( state, rootState, payload );
        //         // expect( state.items[ payload.obj.id ] ).toBe( payload.obj );
        //     } );
        //
        //     it( "payload is NOT Payload ", function () {
        //     } );
        //
        //     it( "payload is Item", function () {
        //         // it( "happy path", function () {
        //         //     //call
        //         //     mutations[ mTypes.setItem ]( state, item );
        //         //
        //         //     //check
        //         //     expect( state.items[ item.index ] ).toBe( item );
        //         //     // expect( state.items[ item.index ] ).toBe( item );
        //         // } );
        //         //
        //         // describe( "unhappy paths | ", function () {
        //         // } );
        //     } );
        //
        // } );

    } );

    describe( description( mTypes.updateItemSilently ), function () {
        //todo
    } );

    describe( description( mTypes.updateOrder ), function () {
        //todo
    } );


} );

