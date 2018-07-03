import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
// import Vue from 'vue';
import moxios from 'moxios';

//helpers
import { assertThatSeeText } from '../../helpers/assertions';
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';

import Item from "./../../../../resources/assets/js/models/Item";
import Comment from "./../../../../resources/assets/js/models/Comment";
import Payload from "./../../../../resources/assets/js/models/Payload";
import * as mTypes from "./../../../../resources/assets/js/store/mutation-types";
import * as gTypes from "./../../../../resources/assets/js/store/getter-types";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../resources/assets/js/development/components/setup/exam-detail-panel.vue" );


describe( " exam-detail-panel ", () => {
    let componentDivIdentifier = '.exam-detail-panel';

    let getters;
    let mutations;
    let store;
    let item;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let routeSerialNumber;

    beforeEach( () => {
        item = new Item();
        routeSerialNumber = item.serialNumber;

        // import and pass your custom axios instance to this method
        // moxios.install()

        getters = {
            getItemBySerialNumber: ( v ) => ( v ) => {
                return item;
            },
            [ gTypes.getItemCount ]: ( v ) => ( v ) => {
            },

            getStudentCount: ( v ) => ( v ) => {
            },

        };

        mutations = {
            [ mTypes.updateComment ]: sinon.spy()
        };

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        $route.params.serialNumber = item.serialNumber;

        wrapper = shallow( Component, {
            store, localVue,
            stubs: [ 'router-link', 'router-view' ],
            mocks: {
                $route
            }
        } );

    } );

    afterEach( function () {
        // import and pass your custom axios instance to this method
        // moxios.uninstall()
    } )

    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );

    } );

} );
