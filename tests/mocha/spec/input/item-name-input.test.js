//The name of the tested component
var compName = 'item-name-input';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/input/item-name-input.vue' );

require( '../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import moxios from 'moxios';
import faker from 'faker';

//helpers
// import { see } from '../../helpers/test-helpers';
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';
// import * as factories from '../../helpers/factories';

// import * as gTypes from "../../../../resources/assets/js/store/getter-types";

import Payload from '../../../../resources/assets/js/models/Payload';
//
// import * as mTypes from "../../../../../resources/assets/js/store/mutation-types";
// import * as gTypes from "../../../../../resources/assets/js/js/store/getter-types";
// import * as nggTypes from "../../../../../resources/assets/js/store/new-grading-getter-types";


const localVue = createLocalVue();

localVue.use( Vuex )


describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;
    let item;
    let spy;

    beforeEach( () => {
        item = factories.itemFactory();

        getters = {
            [ gTypes.getItemBySerialNumber ]: ( v ) => ( v ) => {
                return item;
            }
        };

        spy = sinon.spy()

        mutations = {
            [ mTypes.updateItem ]: spy
        };


        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = shallow( Component, {
            store, localVue
        } );

        wrapper.vm.serialNumber = item.serialNumber;

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            let cdiv = wrapper.find( componentDivIdentifier );
            expect( cdiv.is( 'input' ) ).toBe( true )
        } );
    } );

    describe( " computed ", () => {
        it( 'calls proper mutation when text programmatically entered', () => {
            let testText = 'taco';
            //proper mutation called
            let pl = Payload.factory( {
                obj: item,
                updateProp: 'name',
                updateVal: testText
            } );

            //call
            wrapper.vm.name = testText;

            //check
            expect( spy.callCount ).toBe( 1 );
            expect( spy.args[ 0 ][ 1 ] ).toMatchObject( pl );

        } )

        it( 'calls proper mutation when text entered into box', () => {
            let testText = 'taco';
            let pl = Payload.factory( {
                obj: item,
                updateProp: 'name',
                updateVal: testText
            } );

            //call
            let cdiv = wrapper.find( componentDivIdentifier );
            cdiv.element.value = testText;
            cdiv.trigger( 'change' );

            //check
            expect( spy.callCount ).toBe( 1 );
            expect( spy.args[ 0 ][ 1 ] ).toMatchObject( pl );
        } );


        it( 'is appropriately lazy and does not call mutation on input event', () => {
            let testText = 'taco';

            //call
            let cdiv = wrapper.find( componentDivIdentifier );
            cdiv.element.value = testText;
            cdiv.trigger( 'input' );

            //check
            expect( spy.callCount ).toBe( 0 );
        } );


    } );


} );
