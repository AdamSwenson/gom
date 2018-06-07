//The name of the tested component
var compName = 'max-score-input';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/input/max-score-input.vue' );

require( '../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import moxios from 'moxios';

//helpers
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';


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
    let test;

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

        test = faker.number;

        wrapper.vm.serialNumber = item.serialNumber;
        wrapper.vm.item = item;

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( " computed ", () => {
        it( 'calls proper mutation when text programmatically entered', () => {
            //proper mutation called
            let pl = Payload.factory( {
                obj: item,
                updateProp: 'maxScore',
                updateVal: test
            } );

            //call
            wrapper.vm.maxScore = test;

            //check
            expect( spy.callCount ).toBe( 1 );
            expect( spy.args[ 0 ][ 1 ] ).toMatchObject( pl );

        } )


    } );

} );
