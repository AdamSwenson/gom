import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
// import Vue from 'vue';
import moxios from 'moxios';

//helpers
import { assertThatSeeText } from '../helpers/assertions';
import { assertExpectedDivIsDisplayed } from '../helpers/assertions';

import Item from "../../../resources/assets/js/models/Item";
import Comment from "../../../resources/assets/js/models/Comment";
import Payload from "../../../resources/assets/js/models/Payload";
import * as mTypes from "../../../resources/assets/js/store/mutation-types";
import * as gTypes from "../../../resources/assets/js/store/getter-types";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../resources/assets/js/development/components/setup/exam-stats-panel.vue" );


describe( "stats-panel for exam  ", () => {

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
            },
            [ gTypes.getItemCount ]: (v)=> (v) =>{},

            getStudentCount: (v)=> (v) =>{},

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

        it( 'displays the expected component div on first load', () => {
            expect( wrapper.find( '.exam-stats-panel' ).isEmpty() ).toBe( false );
        } );

    } );


    describe( " loading indicator  ", () => {

        it( " loading indicator displays and time-list is hidden when isTimeLoading is true  ", () => {
            wrapper.vm.isTimeLoading = true;
            wrapper.update();
            expect( wrapper.contains( '.load-indicator ' ) ).toBe( true );
            expect( wrapper.contains( '.time-list' ) ).toBe( false );
        });

        it( " loading indicator is hidden and time-list is visibile when isTimeLoading is false  ", () => {
            //not loading; should see list of exams
            wrapper.vm.isTimeLoading = false;
            wrapper.update();
            expect( wrapper.contains( '.load-indicator ' ) ).toBe( false );
            expect( wrapper.contains( '.time-list' ) ).toBe( true );
        } );
    } );


    describe( " displays expected data after loading async   ", () => {
        let expected = {};

        it( " happy path ", () => {
            let data = {
                elapsedSeconds :
                 590.86,
                };

            moxios.wait( function () {
                let request = moxios.requests.mostRecent()
                request.respondWith( {
                    status: 200,
                    response: [ data ]
                } ).then( function () {

                    //should see
                           assertThatSeeText( wrapper, data.elapsedSeconds, '.timeBox' );

                } );
            } )
        } )
    } );
} );


//
//     beforeEach(  ()=> {
// //runs before each test
// //         let component = mount( commentPanel );
//
//     })

// wrapper.vm // the mounted Vue instance


//
// describe( "computed properties ", () => {
//
//     it( 'displays the expected default on first load',  ()=> {
//        // let component = mount( commentPanel );
//
//         expect( wrapper.vm.displayed ).toBe( 'stock' )
//
//         expect( true ).toBe( true );
//     } );
//
// } );
//
// describe(  "methods" , function () {
//     beforeEach( function () {
//         let component = mount( commentPanel );
//
//     } );
//
//     it( 'prePopulateComments | ', function () {
//         expect( true ).toBe( true );
//     } );
// } );
// } );
