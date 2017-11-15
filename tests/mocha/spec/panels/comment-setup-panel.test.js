import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
// import Vue from 'vue';
import Item from "./../../../../resources/assets/js/models/Item";
import Comment from "./../../../../resources/assets/js/models/Comment";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../resources/assets/js/development/components/panels/comment-setup-panel.vue" );


describe( "comment-setup-panel  ", () => {

    let getters;
    let mutations;
    let store;
    let item;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let routeSerialNumber;
    let testTextString = "test text for ";

    beforeEach( () => {
        item = new Item();
        _.forEach(Comment.valences, function(valence){
           item.comments[valence] = testTextString + valence;
        });

        routeSerialNumber = item.serialNumber;
        getters = {
            getItemBySerialNumber: ( v ) => ( v ) => {
                return item;
            }
        };

        mutations = {
            updateComment : new sinon.spy()
        };

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        $route.params.serialNumber = routeSerialNumber;

        wrapper = shallow( Component, {
            store, localVue,
            stubs: [ 'router-link', 'router-view' ],
            mocks: {
                $route
            }
        } );


    } );

    it( "checks test has been set up properly ", () => {
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
    } );

    it( " displays the intended text when the valence buttons are clicked ", () => {

        _.forEach( Comment.valences, function ( valence ) {
            wrapper.vm.displayed = valence;
            wrapper.trigger('input');
            expect( wrapper.html() ).toContain( testTextString + valence );
        } );


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
