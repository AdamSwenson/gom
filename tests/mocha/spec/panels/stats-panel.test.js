import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
// import VueRouter from 'vue-router';
import Vuex from 'vuex';
// import Vue from 'vue';
import moxios from 'moxios';

//helpers
import { assertThatSeeText } from '../../helpers/assertions';

import Item from "./../../../../resources/assets/js/models/Item";
import Comment from "./../../../../resources/assets/js/models/Comment";
import Payload from "./../../../../resources/assets/js/models/Payload";
import * as mTypes from "./../../../../resources/assets/js/store/mutation-types";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../resources/assets/js/development/components/setup/stats-panel.vue" );


describe( "stats-panel for items  ", () => {

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

        it( " test store has been set up properly ", () => {
            expect( store.getters.getItemBySerialNumber() ).toBe( item );
        } );

        it( " has serial number from route ", () => {
            expect( wrapper.vm.serialNumber ).toBe( item.serialNumber );
        } );

        it( 'displays the expected component div on first load', () => {
            expect( wrapper.find( '.stats-panel' ).isEmpty() ).toBe( false );
        } );

    } );



    /**
     * Asserts that the specified text is present within
     * the specified selector or page if no selector is
     * specified
     * @param text
     * @param selector
     */
    let see = ( text, selector ) => {
        let wrap = selector ? wrapper.find( selector ) : wrapper;
        expect( wrap.html() ).toContain( text );
    };

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
