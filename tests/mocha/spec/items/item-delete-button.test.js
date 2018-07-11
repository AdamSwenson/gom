
//The name of the tested component
import sinon from "sinon";

var compName = 'item-delete-button';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/items/item-delete-button.vue');

require( '../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';

import VueRouter from 'vue-router';
import Vuex from 'vuex';
import moxios from 'moxios';

//helpers
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';

const localVue = createLocalVue();

localVue.use( Vuex )



describe(  compName , () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;
    let item;
    let spy;
    let spy2;

    beforeEach( () => {
        item = factories.itemFactory();

        getters = {
            [ gTypes.getItemBySerialNumber ]: ( v ) => ( v ) => {
                return item;
            }
        };

        spy = sinon.spy()
        spy2 = sinon.spy()

        mutations = {
            toggleChildrenVisibility: spy,
            toggleExamChildrenVisibility: spy2
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
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );


    describe(" methods -- item", () => {
        it('calls delete for an item');

    });


    describe(" methods -- exam", () => {
        it('calls delete for an exam');

    });


});
