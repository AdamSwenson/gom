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


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../resources/assets/js/development/components/setup/history-panel.vue" );


describe( "history-panel  ", () => {

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
        moxios.install()


        getters = {
            getItemBySerialNumber: ( v ) => ( v ) => {
                return item;
            }
        };

        mutations = {
            [mTypes.updateComment]: sinon.spy()
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
        moxios.uninstall()
    } )

    describe( " loads into expected default state for testing ", () => {

        it( " has serial number from route ", () => {
            expect( wrapper.vm.serialNumber ).toBe( item.serialNumber );
        } );

        it( 'displays the expected default on first load', () => {
            expect( wrapper.find( '.history-panel' ).isEmpty() ).toBe( false );
        } );

    } );


    describe( " displays exam names upon loading async   ", () => {
        let expected = {};

        // it( " displays the expected comment text when the displayed valence value changes ", () => {
        //     let exam = {
        //         created_at: "2017-11-10 09:57:27",
        //         id: 5,
        //         locked: false,
        //         name: "Repudiandae et.",
        //         previously_released: false,
        //         released: false,
        //         term: "Quia.",
        //         updated_at: "2017-11-10 09:57:27",
        //         user_id: 1,
        //         year: "2017",
        //     };
        //     moxios.wait( function () {
        //         let request = moxios.requests.mostRecent();
        //         request.respondWith( {
        //             status: 200,
        //             response: [ exam ]
        //         } ).then( function () {
        //
        //             //should see
        //             see( exam.name, '.exam-list' );
        //
        //         } );
        //     } )
        // } )
    } );
} );

