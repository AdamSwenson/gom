//The name of the tested component
var compName = 'children-display-control';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/items/children-display-control.vue' );

require( '../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';

import VueRouter from 'vue-router';
import Vuex from 'vuex';

//helpers
// import { see } from '../../helpers/test-helpers';
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';

import Payload from '../../../../resources/assets/js/models/Payload';

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
    let children;
    let spy2, spy3, spy4;

    beforeEach( () => {
        item = factories.itemFactory();
        children = factories.makeItems( 3 );
        spy3 = sinon.stub();
        spy3.returns( true );


        getters = {
            [ gTypes.getItemBySerialNumber ]: ( v ) => ( v ) => {
                return item;
            },
            isItemChildrenVisible: () => () => spy3,
            getItemChildren: (  ) => (  ) => children

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


    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            wrapper = shallow( Component, {
                store, localVue, propsData: { serialNumber: item.serialNumber }
            } );

            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );


    describe( 'toggleVisibility -- exams', () => {
        it( 'when isExam is true, calls for exam toggle ', () => {
            item.isExam = () => {
                return true;
            };
            wrapper = shallow( Component, {
                store, localVue, propsData: { serialNumber: item.serialNumber }
            } );


            //call
            wrapper.vm.toggleVisibility();

            //check
            expect( spy2.callCount ).toBe( 1 );
            expect( spy.callCount ).toBe( 0 );
        } );

        it( 'when isExam is true, calls for exam toggle ', () => {
            wrapper = shallow( Component, {
                store, localVue, propsData: { serialNumber: item.serialNumber }
            } );

            item.isExam = () => {
                return true;
            };

            //call
            wrapper.vm.toggleVisibility();

            //check
            expect( spy2.callCount ).toBe( 1 );
            expect( spy.callCount ).toBe( 0 );
        } );


        it( 'when isExam is false, calls for item toggle with expected payload', () => {
            item.isExam = () => {
                return false;
            }
            wrapper = shallow( Component, {
                store, localVue, propsData: { serialNumber: item.serialNumber }
            } );

            let payload = Payload.factory( { serialNumber: item.serialNumber } );

            //call
            wrapper.vm.toggleVisibility();

            //check
            expect( spy2.callCount ).toBe( 0 );
            expect( spy.callCount ).toBe( 1 );
            expect( spy.args[ 0 ][ 1 ].serialNumber ).toBe( payload.serialNumber );
        } );
    } );

    describe( "toggleVisibility -- items", () => {
        it( " calls for children to be toggled when it has children", () => {
            // wrapper.setComputed( { numberChildren: 4 } );
            wrapper = shallow( Component, {
                store, localVue, propsData: { serialNumber: item.serialNumber }
            } );

            //call
            wrapper.vm.toggleVisibility();

            //check
            expect( spy2.callCount ).toBe( 0 );
            expect( spy.callCount ).toBe( 1 );

        } );

        it( "does not call for children to be toggled when has no children", () => {

            item.isExam = () => {
                return false;
            }
            wrapper = shallow( Component, {
                store, localVue, propsData: { serialNumber: item.serialNumber }
            } );


            wrapper.setComputed( { numberChildren: () => 0 } );
            //call
            wrapper.vm.toggleVisibility();

            //check
            expect( spy2.callCount ).toBe( 0 );
            expect( spy.callCount ).toBe( 0 );
        } );

    } );
} );