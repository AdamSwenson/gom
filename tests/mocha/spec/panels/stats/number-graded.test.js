import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
// import Vue from 'vue';
import moxios from 'moxios';

//helpers
import { see } from '../../../helpers/test-helpers';

import Exam from "./../../../../../resources/assets/js/models/Exam";
import Comment from "./../../../../../resources/assets/js/models/Comment";
import Payload from "./../../../../../resources/assets/js/models/Payload";
import * as mTypes from "./../../../../../resources/assets/js/store/mutation-types";
import * as gTypes from "./../../../../../resources/assets/js/store/getter-types";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../../resources/assets/js/development/components/setup/stats/number-graded.vue" );


describe( "number-graded  ", () => {

    let getters;
    let mutations;
    let store;
    let exam;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let routeSerialNumber;
    let updateStub = sinon.stub();

    beforeEach( () => {
        exam = new Exam();

        // import and pass your custom axios instance to this method
        moxios.install()

        getters = {
        };

        mutations = {
            [mTypes.updateItem]: updateStub
        };

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        $route.params.serialNumber = exam.serialNumber;

        wrapper = shallow( Component, {
            store, localVue,
            stubs: [ 'router-link', 'router-view' ],
            mocks: {
                $route
            }
        } );

        wrapper.setProps({ exam: exam });

    } );

    afterEach( function () {
        // import and pass your custom axios instance to this method
        moxios.uninstall()
    } )

    describe( " loads into expected default state for testing ", () => {

        it( 'displays the expected component div on first load', () => {
            expect( wrapper.find( '.number-graded' ).isEmpty() ).toBe( false );
        } );

    } );


    describe( " loading indicator  ", () => {

        it( " loading indicator displays and data is hidden when isLoading is true  ", () => {
            wrapper.vm.isLoading = true;
            wrapper.update();
            expect( wrapper.contains( '.loadingArea ' ) ).toBe( true );
            expect( wrapper.contains( '.number-graded-list' ) ).toBe( false );
        } );

        it( " loading indicator is hidden and data is visible when isLoading is false  ", () => {
            //not loading; should see list of exams
            wrapper.vm.isLoading = false;
            wrapper.update();
            expect( wrapper.contains( '.loadingArea ' ) ).toBe( false );
            expect( wrapper.contains( '.number-graded-list' ) ).toBe( true );
        } );
    } );


    describe( " displays expected data after loading async   ", () => {
        let expected = {};

        it( " happy path ", () => {
            let data = {
                numStudents: 590,
                numGraded: 400
            };

            updateStub.withArgs( Payload.factory( {
                mutateSilently: true,
                obj: exam,
                updateProp: 'numberStudents',
                updateVal: data.numStudents
            } ) ).returns( data.numStudents );


            updateStub.withArgs( Payload.factory( {
                mutateSilently: true,
                obj: exam,
                updateProp: 'numberGraded',
                updateVal: data.numGraded
            } ) ).returns( data.numGraded );

            // updateStub.onCall( 1 ).returns( data.numGraded );

            moxios.wait( function () {
                let request = moxios.requests.mostRecent()
                request.respondWith( {
                    status: 200,
                    response: [ data ]
                } ).then( function () {
                    //check that mutation was called as expected
                    expect( updateStub.callCount ).toBe( 2 );

                    //should see values on page
                    see( wrapper, data.numStudents, '.number-graded' );
                    see( wrapper, data.numGraded, '.number-graded' );
                    see( wrapper, data.numStudents - data.numGraded, '.number-graded' );

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
