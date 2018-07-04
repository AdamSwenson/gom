//The name of the tested component
var compName = 'card-movement-control';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/items/card-movement-control.vue' );

require( '../../injectglobals' );


import Node from '../../../../resources/assets/js/models/Node';

import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let listOfValues, test;
    let payload, node, exam, item, kumi, kumis, student, grade, note;

    beforeEach( () => {
        note = factories.noteFactory();
        item = factories.itemFactory();
        node = new Node(3, 4);
        let $route = { params: { serialNumber: 44 } };

        actions = { [ aTypes.removeItem ]: sinon.spy() }

        getters = {
            getNewNote: () => () => note,
            getItemBySerialNumber: () => () => item,
            getItemNodeFromOrder: (  ) => (  ) => node
        };

        mutations = {
            increasePosition: sinon.spy(),
            decreasePosition: sinon.spy(),
            promote: sinon.spy(),
            demote: sinon.spy(),
        };

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        //can't use shallow lest it not grab the mixin
        wrapper = mount( Component, {
            store, localVue, mocks: { $route },
            propsData : {item}
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( "methods", () => {
        it( 'calls correct mutation for move up', () => {
            wrapper.find( '.move-up-control' ).trigger( 'click' );
            expect( mutations.increasePosition.callCount ).toBe( 1 );
        } );

        it( 'calls correct mutation for move down', () => {
            wrapper.find( '.move-down-control' ).trigger( 'click' );
            expect( mutations.decreasePosition.callCount ).toBe( 1 );
        } );

        it( 'calls correct mutation for move left', () => {
            wrapper.find( '.move-left-control' ).trigger( 'click' );
            expect( mutations.promote.callCount ).toBe( 1 );
        } );

        it( 'calls correct mutation for move right', () => {
            wrapper.find( '.move-right-control' ).trigger( 'click' );
            expect( mutations.demote.callCount ).toBe( 1 );
        } );

        it( 'calls correct mutation for remove', () => {
            wrapper.find( '.remove-control' ).trigger( 'click' );
            expect( actions[aTypes.removeItem].callCount ).toBe( 1 );
        } );
    } );


} );
