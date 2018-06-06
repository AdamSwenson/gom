//The name of the tested component
var compName = 'children-display-control';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/input/children-display-control.vue' );


import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import moxios from 'moxios';
import faker from 'faker';

//helpers
// import { see } from '../../helpers/test-helpers';
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';
import * as factories from '../../helpers/factories';

// import * as mTypes from "../../../../../resources/assets/js/store/mutation-types";
import * as gTypes from "../../../../resources/assets/js/store/getter-types";
// import * as nggTypes from "../../../../../resources/assets/js/store/new-grading-getter-types";

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
    let spy2;

    beforeEach( () => {
        item = factories.itemFactory();

        getters = {
            [gTypes.getItemBySerialNumber] : ( v ) => ( v ) => {
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

    describe( " methods ", () => {
        describe( 'toggleVisibility', () => {
            it( 'when isExam is true, calls for exam toggle ', () => {
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

                let payload = Payload.factory( { serialNumber: item.serialNumber } );

                //call
                wrapper.vm.toggleVisibility();

                //check
                expect( spy2.callCount ).toBe( 0 );
                expect( spy.callCount ).toBe( 1 );
                expect( spy.args[0][1].serialNumber ).toBe(payload.serialNumber);
            } );
        } )

    } );


} );
