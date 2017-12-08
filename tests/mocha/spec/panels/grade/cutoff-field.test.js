import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
// import Vue from 'vue';
import moxios from 'moxios';

let faker = require( 'faker' );
//helpers
import { see, type } from '../../../helpers/test-helpers';

import Exam from "./../../../../../resources/assets/js/models/Exam";
import Comment from "./../../../../../resources/assets/js/models/Comment";
import Payload from "./../../../../../resources/assets/js/models/Payload";
import * as mTypes from "./../../../../../resources/assets/js/store/mutation-types";
import * as gTypes from "./../../../../../resources/assets/js/store/getter-types";
import GradeAssignment from "../../../../../resources/assets/js/models/GradeAssignment";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../../resources/assets/js/development/components/panels/grade/cutoff-field.vue" );


describe( "cutoff-field  ", function () {
    let componentDivId = '.cut-off-field';
    let getters;
    let mutations;
    let store;
    let grade;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let routeSerialNumber;
    let updateStub = sinon.stub();
    let getterStub = sinon.stub();
    let getterStub2 = sinon.stub();
    let minScore = 3;

    beforeEach( function () {

        grade = faker.random.arrayElement( GradeAssignment.defaults );

        getterStub.returns( grade );

        let totalScores = [ 2, 2, 5, 6, 7, 9 ];
        getterStub2.returns( totalScores );

        getters = {
            [ gTypes.getGradeFrequencies ]: sinon.stub(),
            [ gTypes.getCutOffsForLetterGrade ]: getterStub,
            [ gTypes.getTotalScores ]: getterStub2
        };

        mutations = {
            [ mTypes.updateGradeCutoffs ]: updateStub
        };

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = shallow( Component, {
            store, localVue,
        } );

        wrapper.setProps( { grade: grade } );

    } );


    describe( " loads into expected default state for testing ", () => {

        it( 'displays the expected component div on first load', () => {


            expect( wrapper.find( componentDivId ).isEmpty() ).toBe( false );
        } );

    } );


    describe( " loading indicator  ", () => {
    } );

    describe( " when a value is entered into the min score field", () => {

        it( " calls the update mutation for min", () => {
            let testVal = 45;
            type( wrapper, '.minScore', testVal );

            expect( updateStub.callCount ).toBe( 1 );
        } );
    } );


    describe( " gradeFrequency  ", function () {
        let freqs;

        beforeEach( function () {
            //create the frequency object which
            //the stubbed getter will return to the component
            freqs = {};
            _.forEach( GradeAssignment.defaults, function ( g ) {
                freqs[ g.displayValue ] = faker.random.number();
            } );
            //set up the stub getter
            getters[ gTypes.getGradeFrequencies ].returns( freqs );
        } );

        it( " returns the count corresponding to the component's grade ", function () {
            let gr = grade.displayVal;
            let expectedCount = freqs[ gr ];
            expect( wrapper.vm.gradeFrequency ).toBe( expectedCount );
            // expect(getters[gTypes.getGradeFrequencies].callCount).toBe(1);
        } );

        it( " displays the count in the expected area  ", function () {

        } );

    } );

    describe( " displays expected data after loading async   ", () => {
        let expected = {};

        it( " happy path ", () => {
            //     let data = {
            //         numStudents: 590,
            //         numGraded: 400
            //     };
            //
            //     updateStub.withArgs( Payload.factory( {
            //         mutateSilently: true,
            //         obj: exam,
            //         updateProp: 'numberStudents',
            //         updateVal: data.numStudents
            //     } ) ).returns( data.numStudents );
            //
            //
            //     updateStub.withArgs( Payload.factory( {
            //         mutateSilently: true,
            //         obj: exam,
            //         updateProp: 'numberGraded',
            //         updateVal: data.numGraded
            //     } ) ).returns( data.numGraded );
            //
            //     // updateStub.onCall( 1 ).returns( data.numGraded );
            //
            //     moxios.wait( function () {
            //         let request = moxios.requests.mostRecent()
            //         request.respondWith( {
            //             status: 200,
            //             response: [ data ]
            //         } ).then( function () {
            //             //check that mutation was called as expected
            //             expect( updateStub.callCount ).toBe( 2 );
            //
            //             //should see values on page
            //             see( wrapper, data.numStudents, '.number-graded' );
            //             see( wrapper, data.numGraded, '.number-graded' );
            //             see( wrapper, data.numStudents - data.numGraded, '.number-graded' );
            //
            //         } );
            //     } )
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
