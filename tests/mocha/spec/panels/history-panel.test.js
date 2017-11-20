import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
// import Vue from 'vue';
import Item from "./../../../../resources/assets/js/models/Item";
import Comment from "./../../../../resources/assets/js/models/Comment";
import Payload from "./../../../../resources/assets/js/models/Payload";
import * as mTypes from "./../../../../resources/assets/js/store/mutation-types";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../resources/assets/js/development/components/panels/history-panel.vue" );


describe( "history-panel  ", () => {

    let getters;
    let mutations;
    let store;
    let item;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let routeSerialNumber;


    describe( " loads into expected default state for testing ", () => {

        beforeEach( () => {
            item = new Item();
            routeSerialNumber = item.serialNumber;
            setupForItem( item );
        } );

        it( " test has been set up properly ", () => {
            expect( store.getters.getItemBySerialNumber() ).toBe( item );
        } );

        // it( 'has the serial number passed in as a prop ', () => {
        //
        // $route.params.serialNumber= ()=> 99;
        //
        // let wrapper = shallow( Component, {
        //     store, localVue,
        //     stubs: ['router-link', 'router-view'],
        //     mocks: {
        //         $route
        //     }
        // } );
        //
        // // wrapper.setProps( { dataSerialNumber: item.serialNumber } );
        // expect( wrapper.vm.serialNumber).toBe( 99 );
        // } );

        it( " has serial number from route ", () => {
            expect( wrapper.vm.serialNumber ).toBe( item.serialNumber );
        } );

        it( 'displays the expected default on first load', () => {
            expect( wrapper.vm.displayed ).toBe( 'stock' )
            expect( wrapper.find( '.comment-setup-panel' ).isEmpty() ).toBe( false );

        } );

        it( ' changes the shouldPrePopulate state when the control is toggled ', () => {
            wrapper.find( '#prepopulationControl' ).element

        } );

    } );

    describe( " displays appropriate comment text in response to events   ", () => {
        let expected = {};

        beforeEach( () => {
            item = new Item();

        } );

        it( " displays the expected comment text when the displayed valence value changes ", () => {

        } );
    } );


    /**
     * Creates the store and mounts the
     * component for the given item
     * @param item
     */
    let setupForItem = ( item ) => {

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

    };


    /**
     * Types the text into the field identified by selector
     * @param selector
     * @param text
     */
    let type = ( selector, text ) => {
        wrapper.find( selector ).element.value = text;
        wrapper.find( selector ).trigger( 'input' );
    };

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

    /**
     * Returns a random element from the Comment.valences
     * array with the exception of stock, which it never returns.
     * @returns string
     */
    let getRandomNonStockValence = () => {
        return _.take( _.shuffle( _.drop( Comment.valences ) ) )[ 0 ];

    }

} )
;


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
